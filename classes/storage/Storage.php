<?php

namespace storage;

use \models\Model;

abstract class Storage
{

	/**
	 *
	 * @param string $connectionString
	 */
	public abstract function __construct($connectionString);

	/**
	 * persist model
	 *
	 * @param Persistable $model
	 * @return boolean
	 */
	public abstract function save(Persistable $model);

	/**
	 * load model
	 *
	 * @param Persistable $empty_model
	 * @return Model filled with data
	 */
	public abstract function load(Persistable $empty_model);

	/**
	 * find a set of models
	 *
	 * @param Persistable $empty_model
	 * @param array $attributes key/value with matching search criterias
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return array set of models
	 */
	public abstract function find(Persistable $empty_model, $attributes = array(), $order = array());

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
}
