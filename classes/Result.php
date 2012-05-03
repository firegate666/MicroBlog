<?php

abstract class Result
{
	protected $result;
	
	public function __construct($result) {
		$this->result = $result;
	}
	
	/**
	 * @return mixed
	 */
	public abstract function getResult();
}
