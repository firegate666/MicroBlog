<?php
/**
 * Created by PhpStorm.
 * User: marcobehnke
 * Date: 22.11.13
 * Time: 15:23
 */

namespace storage;


class MysqlStorage extends Storage {

	/**
	 * @var \PDO
	 */
	private $mysqli;

	/**
	 * Split connection string into parts
	 *
	 * @param string $connection_string
	 * @return object {host: string, user: string, pass: string, name: string, port: integer}
	 */
	private function splitConnectionString($connection_string) {
		$connection_parts = explode('@', $connection_string);

		$user_pass = explode(':', $connection_parts[0]);
		$host_db = explode('/', $connection_parts[1]);

		$host_port = explode(':', $host_db[0]);

		$user = $user_pass[0];
		$pass = $user_pass[1];

		$host = $host_port[0];
		$port = $host_port[1];

		$name = $host_db[1];

		return (object) array(
			'host' =>$host,
			'user' =>$user,
			'pass' =>$pass,
			'name' =>$name,
			'port' =>$port
		);
	}

	/**
	 * @inheritdoc
	 */
	public function __construct($connection_string)
	{
		parent::__construct($connection_string);
		$connection_properties = $this->splitConnectionString($connection_string);

		$dsn = 'mysql:dbname=' . $connection_properties->name . ';host=' . $connection_properties->host;
		$user = $connection_properties->user;
		$password = $connection_properties->pass;

		$this->mysqli = new \PDO($dsn, $user, $password);
	}
	/**
	 * Bind values to prepared statement
	 *
	 * @param \PDOStatement $stmt
	 * @param array $attributes
	 * @param boolean $skip_null
	 * @return void
	 */
	protected function bindValues(\PDOStatement $stmt, array $attributes, $skip_null = false) {
		foreach ($attributes as $column => $data) {
			$bind_type = null;
			if (is_integer($data)) {
				$bind_type = \PDO::PARAM_INT;
			} else if (is_float($data)) {
				// @todo how to handle floats here?
				$bind_type = \PDO::PARAM_STR;
			} else if ($data === null) {
				if ($skip_null) {
					continue; // no binding of null values in where condition, they are handle in createWhere as IS NULL
				}
				$bind_type = \PDO::PARAM_NULL;
			} else if (is_bool($data)) {
				$bind_type = \PDO::PARAM_BOOL;
			} else {
				$bind_type = \PDO::PARAM_STR;
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

		$stmt = $this->mysqli->prepare($query);

		$this->bindValues($stmt, $attributes, true);

		$list = array();

		$stmt->execute();
		while (($row = $stmt->fetch(\PDO::FETCH_ASSOC)) !== false)
		{
			$clone = clone $empty_model;
			foreach ($row as $column => $data)
			{
				if (property_exists($clone, $column))
				{

					if (is_numeric($data) && stripos($data, '.') !== false) {
						$data = (float)$data;
					} else if (is_numeric($data)) {
						$data = (int)$data;
					}

					$clone->$column = $data;
				}
			}

			if ($clone->isValid())
			{
				$list[] = $clone;
			}
			else{
				throw new \InvalidArgumentException($this->mysqli->errorInfo());
			}
			// TODO log failures
		}
		return $list;
	}

	/**
	 * @inheritdoc
	 */
	public function save(Persistable $model)
	{
		$table = $this->createTableName($model);
		$fields = array();

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
			$stmt = $this->mysqli->prepare($query);
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
