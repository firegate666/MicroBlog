<?php

namespace storage;

use InvalidArgumentException;
use SQLite3;

/**
 * SQLite3 specific implementation of the storage class
 *
 * @package storage
 */
class SqliteStorage extends Storage {

	/**
	 *
	 * @var SQLite3
	 */
	private $sqlite;

	/**
	 * @inheritdoc
	 */
	public function __construct($connectionString) {
		parent::__construct($connectionString);
		// @TODO move secret to config
		$this->sqlite = new SQLite3(RUNTIME_DEFAULT . $connectionString, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, 'secret');
	}

	/**
	 * Bind values to prepared statement
	 *
	 * @param \SQLite3Stmt $stmt
	 * @param array $attributes
	 * @param boolean $skipNull
	 * @return void
	 */
	protected function bindValues(\SQLite3Stmt $stmt, array $attributes, $skipNull = false) {
		foreach ($attributes as $column => $data) {
			$bindType = null;
			if (is_integer($data)) {
				$bindType = SQLITE3_INTEGER;
			} else if (is_float($data)) {
				$bindType = SQLITE3_FLOAT;
			} else if ($data === null) {
				if ($skipNull) {
					continue; // no binding of null values in where condition, they are handle in createWhere as IS NULL
				}
				$bindType = SQLITE3_NULL;
			} else {
				$bindType = SQLITE3_TEXT;
			}
			$stmt->bindValue(':' . $column, $data, $bindType);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function find(Persistable $emptyModel, $attributes = array(), $order = array()) {
		$table = $this->createTableName($emptyModel);

		$query = 'SELECT * FROM ' . $table;

		$query .= $this->createWhere($attributes);
		$query .= $this->createOrderBy($order, $emptyModel);

		$this->getLogger()->debug($query);
		$this->getLogger()->debug(json_encode($attributes));

		$stmt = $this->sqlite->prepare($query);

		$this->bindValues($stmt, $attributes, true);

		$result = $stmt->execute();
		$list = array();
		while (($row = $result->fetchArray(SQLITE3_ASSOC)) !== false) {
			$clone = clone $emptyModel;
			foreach ($row as $column => $data) {
				if (property_exists($clone, $column)) {
					$clone->$column = $data;
				}
			}

			if ($clone->isValid()) {
				$list[] = $clone;
			}
			// TODO log failures
		}
		return $list;
	}

	/**
	 * @inheritdoc
	 */
	public function save(Persistable $model) {
		$table = $this->createTableName($model);
		$fields = $this->extractStorableFields($model);

		$id = $fields['id'];
		$stmt = null;
		$isNew = false;
		if (empty($id)) {
			unset($fields['id']); // we don't want a null id field
			// INSERT
			$query = sprintf('INSERT INTO ' . $table . '(%s) VALUES (%s)',
				implode(',', array_keys($fields)),
				':' . implode(',:', array_keys($fields))
			);
			$stmt = $this->sqlite->prepare($query);
			$isNew = true;
		} else {
			// UPDATE
			// TODO implement
			throw new InvalidArgumentException(sprintf('storage update not implemented yet for persistable id %d', $id), 500);
		}

		$this->bindValues($stmt, $fields);
		$ret = $stmt->execute();

		if ($ret && $isNew) {
			$model->setId($this->sqlite->lastInsertRowID());
		}

		return $ret;
	}
}
