<?php

namespace storage;

use InvalidArgumentException;
use PDO;
use PDOStatement;

class PDOStorage extends Storage {

	/**
	 * @var PDO
	 */
	private $pdo;

	/**
	 * @inheritdoc
	 */
	public function __construct($connectionString) {
		parent::__construct($connectionString);
		$connectionProperties = new ConnectionProperties($connectionString);

		$dsn = $connectionProperties->system . ':dbname=' . $connectionProperties->name . ';host=' . $connectionProperties->host;
		$user = $connectionProperties->user;
		$password = $connectionProperties->pass;

		$this->pdo = new PDO($dsn, $user, $password);
	}

	/**
	 * Bind values to prepared statement
	 *
	 * @param PDOStatement $stmt
	 * @param array $attributes
	 * @param boolean $skipNull
	 * @return void
	 */
	protected function bindValues(PDOStatement $stmt, array $attributes, $skipNull = false) {
		foreach ($attributes as $column => $data) {
			$bindType = null;
			if (is_integer($data)) {
				$bindType = PDO::PARAM_INT;
			} else if (is_float($data)) {
				// @todo how to handle floats here?
				$bindType = PDO::PARAM_STR;
			} else if ($data === null) {
				if ($skipNull) {
					continue; // no binding of null values in where condition, they are handle in createWhere as IS NULL
				}
				$bindType = PDO::PARAM_NULL;
			} else if (is_bool($data)) {
				$bindType = PDO::PARAM_BOOL;
			} else {
				$bindType = PDO::PARAM_STR;
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

		$stmt = $this->pdo->prepare($query);

		$this->bindValues($stmt, $attributes, true);

		$list = array();

		$stmt->execute();
		while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
			$clone = clone $emptyModel;
			foreach ($row as $column => $data) {
				if (property_exists($clone, $column)) {

					if (is_numeric($data) && stripos($data, '.') !== false) {
						$data = (float)$data;
					} else if (is_numeric($data)) {
						$data = (int)$data;
					}

					$clone->$column = $data;
				}
			}

			if ($clone->isValid()) {
				$list[] = $clone;
			} else {
				throw new InvalidArgumentException($this->pdo->errorInfo());
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
		if (empty($id)) {
			unset($fields['id']); // we don't want a null id field
			// INSERT
			$query = sprintf('INSERT INTO ' . $table . '(%s) VALUES (%s)',
				implode(',', array_keys($fields)),
				':' . implode(',:', array_keys($fields))
			);
			$stmt = $this->pdo->prepare($query);
			$isNew = true;
		} else {
			// UPDATE
			// TODO implement
			throw new InvalidArgumentException(sprintf('storage update not implemented yet for persistable id %d', $id), 500);
		}

		$this->bindValues($stmt, $fields);

		$ret = $stmt->execute();
		if ($ret && $isNew) {
			$model->setId($this->pdo->lastInsertId());
		}
		return $ret;
	}

	/**
	 * delete all models
	 *
	 * @param Persistable $model
	 * @return boolean
	 */
	public function truncate(Persistable $model) {
		$table = $this->createTableName($model);
		$query = 'DELETE FROM ' . $table;
		$this->pdo->exec($query);

		return true;
	}
}
