<?php

namespace storage;

use \zpt\anno\Annotations;

class SqliteStorage extends Storage
{

	/**
	 *
	 * @var \SQLite3
	 */
	private $sqlite;

	/**
	 * @inheritdoc
	 */
	public function __construct($connection_string)
	{
		// @TODO move secret to config
		$this->sqlite = new \SQLite3(RUNTIME_DEFAULT . $connection_string, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, 'secret');
	}

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
			if ($refl_class->hasProperty($orderfield)) // @todo check if property is valid column
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
	 * @return string
	 */
	private function createWhere($attributes)
	{
		// @TODO compare operator
		$condition = array();
		$query = '';
		foreach ($attributes as $column => $data)
		{
			$cmp = $data == null ? ' IS ' : '= :';
			$bind =  $data == null ? 'NULL' : $data;

			$condition[] = $column . $cmp . $bind;
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
		$classAnnotations = new Annotations($classReflector);
		if ($classAnnotations->hasAnnotation('tableName')) {
			return $classAnnotations['tableName'];
		}

		throw new \InvalidArgumentException('Given class is not persistable');
	}

	/**
	 * Bind values to prepared statement
	 *
	 * @param \SQLite3Stmt $stmt
	 * @param array $attributes
	 * @param boolean $skip_null
	 * @return void
	 */
	private function bindValues(\SQLite3Stmt $stmt, array $attributes, $skip_null = false) {
		foreach ($attributes as $column => $data) {
			$bind_type = null;
			if (is_integer($data)) {
				$bind_type = SQLITE3_INTEGER;
			} else if (is_float($data)) {
				$bind_type = SQLITE3_FLOAT;
			} else if ($data === null) {
				if ($skip_null) {
					continue; // no binding of null values in where condition, they are handle in createWhere as IS NULL
				}
				$bind_type = SQLITE3_NULL;
			} else {
				$bind_type = SQLITE3_TEXT;
			}
			$stmt->bindValue(':' . $column, $data, $bind_type);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function find(Persistable $empty_model, $attributes = array(), $order = array())
	{
		$table = $this->createTableName($empty_model);

		$query = 'SELECT * FROM ' . $table;

		$query .= $this->createWhere($attributes);
		$query .= $this->createOrderBy($order, $empty_model);

		$stmt = $this->sqlite->prepare($query);

		$this->bindValues($stmt, $attributes, true);

		$result = $stmt->execute();
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

		/*foreach ($model as $key => $property) {
			$fields[$key] = "'" . $this->sqlite->escapeString($property) . "'";
		}*/

		$classReflector = new \ReflectionClass($model);

		foreach ($classReflector->getProperties() as $propReflector) {
			$propAnnotations = new Annotations($propReflector);
			if ($propAnnotations->hasAnnotation('column')) {
				$fields[$propReflector->getName()] = $propReflector->getValue($model);
			}
		}

		$id = $fields['id'];
		$stmt = null;
		if (empty($id))
		{
			unset($fields['id']); // we don't want a null id field
			// INSERT
			$query = sprintf('INSERT INTO ' . $table . '(%s) VALUES (%s)',
				implode(',', array_keys($fields)),
				':' . implode(',:', array_keys($fields))
			);
			$stmt = $this->sqlite->prepare($query);
		}
		else {
			// UPDATE
			// TODO implement
			throw new \InvalidArgumentException(sprintf('storage update not implemented yet for persitable id %d', $id), 500);
		}

		$this->bindValues($stmt, $fields);
		return $stmt->execute();
	}
}
