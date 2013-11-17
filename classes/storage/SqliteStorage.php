<?php

namespace storage;

use \models\Model;
use \zpt\anno\Annotations;

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
	 * @param Persistable $empty_model
	 * @return string
	 */
	private function createOrderBy($order, Persistable $empty_model)
	{
		if (empty($order))
		{
			return ' ORDER BY id DESC';
		}

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

	/**
	 * create where part of query
	 *
	 * @param array $attributes
	 * @param Persistable $empty_model
	 * @return string
	 */
	private function createWhere($attributes, Persistable $empty_model)
	{
		// @TODO quoting, escaping, compare operator
		$condition = array();
		$query = '';
		foreach ($attributes as $column => $data)
		{
			$condition[] = $column . ' = ' . $data;
		}

		if (!empty($condition))
		{
			$query .= ' WHERE ' . implode(' AND ', $condition);
		}
		return $query;
	}

	/**
	 * @param Persistable $model
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	private function createTableName(Persistable $model) {
		$classReflector = new \ReflectionClass($model);
		$classAnnotations = new \zpt\anno\Annotations($classReflector);
		if ($classAnnotations->hasAnnotation('tableName')) {
			return $classAnnotations['tableName'];
		}

		throw new \InvalidArgumentException('Given class is not persistable');
	}

	/**
	 * @inheritdoc
	 */
	public function find(Persistable $empty_model, $attributes = array(), $order = array())
	{
		$table = $this->createTableName($empty_model);

		$query = 'SELECT * FROM ' . $table;

		$query .= $this->createWhere($attributes, $empty_model);
		$query .= $this->createOrderBy($order, $empty_model);

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

	/**
	 * @inheritdoc
	 */
	public function __construct($connection_string)
	{
		// @TODO move secret to config
		$this->sqlite = new \SQLite3(RUNTIME_DEFAULT . $connection_string, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, 'secret');
	}

	/**
	 * @inheritdoc
	 */
	public function load(Persistable $empty_model)
	{
		$list = $this->find($empty_model, array('id' => $empty_model->id));
		return array_pop($list);
	}

	/**
	 * @inheritdoc
	 */
	public function save(Persistable $model)
	{
		$table = $this->createTableName($model);
		$fields = array();
		foreach ($model as $key => $property) {
			$fields[$key] = "'" . $this->sqlite->escapeString($property) . "'";
		}

		$id = $fields['id'];
		unset($fields['id']);
		if (empty($fields['id']))
		{
			// INSERT
			$query = sprintf('INSERT INTO ' . $table . '(%s) VALUES (%s)',
				implode(',', array_keys($fields)),
				implode(',', array_values($fields))
			);
		}
		else {
			// UPDATE
			// TODO implement
			throw new \InvalidArgumentException('storage update not implemented yet', 500);
		}
		return $this->sqlite->exec($query);
	}
}
