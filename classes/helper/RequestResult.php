<?php

namespace helper;

/**
 * Request result object
 * Normally returns from controller and is rendered to page
 *
 * @package helper
 */
abstract class RequestResult
{
	/**
	 * @var mixed
	 */
	protected $result;

	/**
	 * @var integer
	 */
	protected $http_status;

	/**
	 *
	 * @param mixed $result
	 * @param integer $http_status
	 */
	public function __construct($result, $http_status = 200)
	{
		$this->result = $result;
		$this->http_status = $http_status;
	}

	/**
	 * @return mixed
	 */
	public abstract function getResult();

	/**
	 * get http status code
	 *
	 * @return integer
	 */
	public function getHttpStatus()
	{
		return $this->http_status;
	}

	/**
	 * @return integer timestamp
	 */
	public function validUntil()
	{
		return false;
	}

}
