<?php

namespace storage;

use \models\Model;

class SqliteStorage extends Storage
{

	/**
	 *
	 * @var \SQLite3
	 */
	private $sqlite;

	/**
	 * create order by part of statement
	 *
	 * @param array $order
	 * @return string
	 */
	private function createOrderBy($order, $empty_model)
	{
		$orders = array();
		$query = '';
		$refl_class = new \ReflectionClass($empty_model);
		foreach($order as $orderfield => $orderdirection)
		{
			if ($refl_class->hasProperty($orderfield))
			{
				$orders[] = $this->sqlite->escapeString($orderfield)
				. ' '
						. (in_array(strtoupper($orderdirection), array('ASC', 'DESC')) ? $orderdirection : 'DESC')
						;
			}
			// TODO log invalid attributes
		}
		if (!empty($orders)) {
			$query .= ' ORDER BY ' . implode(', ', $orders);
		}
		return $query;
	}

	/*
	 * (non-PHPdoc) @see Storage::find()
	 */
	public function find(Model $empty_model, $attributes = array(), $order = array())
	{
		$table = explode('\\', get_class($empty_model));
		$table = array_pop($table);
		$query = 'SELECT * FROM ' . $table;

		// @TODO quoting, escaping, compare operator
		$condition = array();
		foreach ($attributes as $column => $data)
		{
			$condition[] = $column . ' = ' . $data;
		}

		if (!empty($condition))
		{
			$query .= ' WHERE ' . implode(' AND ', $condition);
		}

		if (empty($order))
		{
			$query .= ' ORDER BY id DESC';
		}
		else
		{
			$query .= $this->createOrderBy($order, $empty_model);
		}

		$result = $this->sqlite->query($query);
		$list = array();
		while (($row = $result->fetchArray(SQLITE3_ASSOC)) !== false)
		{
			$clone = clone $empty_model;
			foreach ($row as $column => $data)
			{
				if (property_exists($clone, $column))
				{
					$clone->$column = $data;
				}
			}

			if ($clone->isValid())
			{
				$list[] = $clone;
			}
			// TODO log failures
		}
		return $list;
	}

	/*
	 * (non-PHPdoc) @see Storage::__construct()
	 */
	public function __construct($connection_string)
	{
		$runtime_path = __DIR__ . '/../../runtime/';
		// @TODO move secret to config
		$this->sqlite = new \SQLite3($runtime_path . $connection_string, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, 'secret');
	}

	/*
	 * (non-PHPdoc) @see Storage::load()
	 */
	public function load(Model $empty_model)
	{
		$list = $this->find($empty_model, array('id' => $empty_model->id));
		return array_pop($list);
	}

	/*
	 * (non-PHPdoc) @see Storage::save()
	 */
	public function save(Model $model)
	{
		// TODO Auto-generated method stub
	}
}
