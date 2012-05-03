<?php

abstract class Storage
{

	/**
	 * persist model
	 *
	 * @param Model $model
	 * @return boolean
	 */
	public abstract function save(Model $model);

	/**
	 * load model
	 *
	 * @param Model $empty_model
	 * @return Model filled with data
	 */
	public abstract function load(Model $empty_model);

	/**
	 * find a set of models
	 *
	 * @param Model $empty_model
	 * @param array $attributes key/value with matching search criterias
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return array set of models
	 */
	public abstract function find(Model $empty_model, $attributes = array(), $order = array());

	/**
	 * find all models
	 *
	 * @param Model $empty_model
	 * @param array $order key/value with attributes to order by as key and ASC or DESC as value
	 * @return array set of models
	 */
	public function findAll(Model $empty_model, $order = array()) {
		return $this->find($empty_model, array(), $order);
	}

	/**
	 * connect to storage
	 *
	 * @param string $identifier
	 * @return boolean
	 */
	public abstract function connect($identifier);

	/**
	 * disconnect from storage
	 *
	 * @return boolean
	 */
	public abstract function disconnet();
}
