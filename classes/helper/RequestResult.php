<?php

namespace helper;

abstract class RequestResult
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

	/**
	 *
	 * @return integer timestamp
	 */
	public function validUntil()
	{
		return false;
	}
}
