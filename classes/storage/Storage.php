<?php

namespace storage;

use Psr\Log\LoggerInterface;
use \zpt\anno\Annotations;

abstract class Storage implements StorageInterface
{

	/**
	 * @var OrderByBuilder
	 */
	protected $orderByBuilder;

	/**
	 * @var WhereBuilder
	 */
	protected $whereBuilder;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 *
	 * @param string $connectionString
	 */
	public function __construct($connectionString) {
		$this->orderByBuilder = new OrderByBuilder();
		$this->whereBuilder = new WhereBuilder();
	}

	/**
	 * @param LoggerInterface $logger
	 * @return void
	 */
	public function setLogger(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	/**
	 * @return LoggerInterface
	 */
	public function getLogger() {
		return $this->logger;
	}

	/**
	 * load model
	 *
	 * @param Persistable $empty_model
	 * @return Persistable filled with data
	 */
	public function load(Persistable $empty_model)
	{
		$list = $this->find($empty_model, array('id' => $empty_model->id));
		return array_pop($list);
	}

	/**
	 * find all models
	 *
	 * @param Persistable $empty_model
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return array set of models
	 */
	public function findAll(Persistable $empty_model, $order = array())
	{
		return $this->find($empty_model, array(), $order);
	}

	/**
	 * @param Persistable $model
	 * @return mixed
	 * @throws \InvalidArgumentException
	 */
	protected function createTableName(Persistable $model) {
		$classReflector = new \ReflectionClass($model);
		$classAnnotations = new Annotations($classReflector);
		if ($classAnnotations->hasAnnotation('tableName')) {
			return $classAnnotations['tableName'];
		}

		throw new \InvalidArgumentException('Given class is not persistable');
	}

	/**
	 * create order by part of statement
	 *
	 * @param array $order
	 * @param Persistable $empty_model
	 * @return string
	 */
	protected function createOrderBy($order, Persistable $empty_model)
	{
		return $this->orderByBuilder->build($order, $empty_model);
	}

	/**
	 * create where part of query
	 *
	 * @param array $attributes
	 * @return string
	 */
	protected function createWhere($attributes)
	{
		return $this->whereBuilder->build($attributes);
	}
}
