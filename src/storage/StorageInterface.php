<?php

namespace storage;

use Psr\Log\LoggerInterface;

interface StorageInterface {

	/**
	 * @param LoggerInterface $logger
	 * @return void
	 */
	public function setLogger(LoggerInterface $logger);

	/**
	 * load model
	 *
	 * @param Persistable $emptyModel
	 * @return Persistable filled with data
	 */
	public function load(Persistable $emptyModel);

	/**
	 * persist model
	 *
	 * @param Persistable $model
	 * @return boolean
	 */
	public function save(Persistable $model);

	/**
	 * find a set of models
	 *
	 * @param Persistable $emptyModel
	 * @param array $attributes key/value with matching search criterias
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return Persistable[] array set of models
	 */
	public function find(Persistable $emptyModel, $attributes = array(), $order = array());

	/**
	 * find all models
	 *
	 * @param Persistable $emptyModel
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return array set of models
	 */
	public function findAll(Persistable $emptyModel, $order = array());

	/**
	 * delete all models
	 *
	 * @param Persistable $model
	 * @return boolean
	 */
	public function truncate(Persistable $model);
}
