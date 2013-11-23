<?php

namespace helper;

/**
 * wrap content of $_SERVER
 */
class Request {

	/**
	 * @var string[]
	 */
	private $serverVars;

	/**
	 * @var array
	 */
	private $getParams;

	/**
	 * @var array
	 */
	private $postParams;

	/**
	 * @param array $serverVars
	 * @param array $getParams
	 * @param array $postParams
	 */
	public function __construct($serverVars, $getParams, $postParams) {
		$this->serverVars = $serverVars;
		$this->getParams = $getParams;
		$this->postParams = $postParams;
	}

	/**
	 * Get request parameter, post over get
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function postOrGetParam($name, $default = null) {
		return $this->postParam($name, $this->getParam($name, $default));
	}

	/**
	 * Get request parameter, get over post
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getOrPostParam($name, $default = null) {
		return $this->getParam($name, $this->postParam($name, $default));
	}

	/**
	 * Get get parameter
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getParam($name, $default = null) {
		if ($this->hasGetParam($name)) {
			return $this->getParams[$name];
		}
		return $default;
	}

	/**
	 * @param string $name
	 * @return boolean
	 */
	public function hasGetParam($name) {
		return array_key_exists($name, $this->getParams);
	}

	/**
	 * @param string $name
	 * @return boolean
	 */
	public function hasPostParam($name) {
		return array_key_exists($name, $this->postParams);
	}

	/**
	 * @param string $name
	 * @return boolean
	 */
	public function hasGetOrPostParam($name) {
		return $this->hasGetParam($name) || $this->hasPostParam($name);
	}

	/**
	 * get post parameter
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function postParam($name, $default = null) {
		if (array_key_exists($name, $this->postParams)) {
			return $this->postParams[$name];
		}
		return $default;
	}

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function serverVar($name, $default = null) {
		if (array_key_exists($name, $this->serverVars)) {
			return $this->serverVars[$name];
		}
		return $default;
	}

	/**
	 * @return boolean
	 */
	public function isAjax() {
		return !empty($this->serverVars['HTTP_X_REQUESTED_WITH']);
	}
}
