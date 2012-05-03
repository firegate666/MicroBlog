<?php

/**
 * wrap content of $_SERVER
 */
class Request
{

	private $serverVars;

	private $getParams;

	private $postParams;

	/**
	 * 
	 * @param array $server_vars
	 * @param array $get_params
	 * @param array $post_params
	 */
	public function __construct($server_vars, $get_params, $post_params)
	{
		$this->serverVars = $server_vars;
		$this->getParams = $get_params;
		$this->postParams = $post_params;
	}

	/**
	 * 
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getParam($name, $default = null)
	{
		if (array_key_exists($name, $this->getParams))
		{
			return $this->getParams[$name];
		}
		return $default;
	}

	/**
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function postParam($name, $default = null)
	{
		if (array_key_exists($name, $this->postParams))
		{
			return $this->postParams[$name];
		}
		return $default;
	}
}
