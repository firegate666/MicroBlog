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
		foreach ($attributes as $column => $data) {
			$condition[] = $column . ' = ' . $data;
		}

		if (!empty($condition)) {
			$query .= ' WHERE ' . implode(' AND ', $condition);
		}

		// @TODO read order from param
		if (empty($order)) {
			$query .= ' ORDER BY id DESC';
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
			// @TODO validate object
			$list[] = $clone;
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
		// TODO Auto-generated method stub
	}

	/*
	 * (non-PHPdoc) @see Storage::save()
	 */
	public function save(Model $model)
	{
		// TODO Auto-generated method stub
	}
}
