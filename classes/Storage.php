<?php

abstract class Storage
{

	public abstract function save(Model $model);

	public abstract function load(Model $empty_model);

	public abstract function connect($identifier);

	public abstract function disconnet();
}
