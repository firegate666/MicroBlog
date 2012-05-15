<?php

namespace helper;

abstract class Result
{

	protected $result;

	/**
	 *
	 * @param mixed $result
	 */
	public function __construct($result)
	{
		$this->result = $result;
	}

	/**
	 *
	 * @return mixed
	 */
	public abstract function getResult();
}
