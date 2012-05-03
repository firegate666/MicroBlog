<?php

abstract class Storage
{

	public abstract function save(Model $model);

	public abstract function load(Model $empty_model);

	public abstract function find(Model $empty_model, $attributes = array(), $order = array());

	public function findAll(Model $empty_model, $order = array()) {
		return $this->find($empty_model, array(), $order);
	}

	public abstract function connect($identifier);

	public abstract function disconnet();
}
