<?php

namespace helper;

/**
 * Request result object
 * Normally returns from controller and is rendered to page
 *
 * @package helper
 */
abstract class RequestResult {
	/**
	 * @var mixed
	 */
	protected $result;

	/**
	 * @var integer
	 */
	protected $httpStatus;

	/**
	 *
	 * @param mixed $result
	 * @param integer $httpStatus
	 */
	public function __construct($result, $httpStatus = 200) {
		$this->result = $result;
		$this->httpStatus = $httpStatus;
	}

	/**
	 * @return string
	 */
	public abstract function getResult();

	/**
	 * @return array
	 */
	public abstract function getHeaders();

	/**
	 * get http status code
	 *
	 * @return integer
	 */
	public function getHttpStatus() {
		return $this->httpStatus;
	}

	/**
	 * @return integer timestamp
	 */
	public function validUntil() {
		return false;
	}
}
