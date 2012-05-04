<?php
namespace helper;

/**
 * wrap content of $_SERVER
 */
class Request
{

	private $server_vars;

	private $get_params;

	private $post_params;

	/**
	 *
	 * @param array $server_vars
	 * @param array $get_params
	 * @param array $post_params
	 */
	public function __construct($server_vars, $get_params, $post_params)
	{
		$this->server_vars = $server_vars;
		$this->get_params = $get_params;
		$this->post_params = $post_params;
	}

	/**
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function postOrGetParam($name, $default = null)
	{
		return $this->postParam($name, $this->getParam($name, $default));
	}

	/**
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getOrPostParam($name, $default = null)
	{
		return $this->getParam($name, $this->postParam($name, $default));
	}

	/**
	 *
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function getParam($name, $default = null)
	{
		if (array_key_exists($name, $this->get_params))
		{
			return $this->get_params[$name];
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
		if (array_key_exists($name, $this->post_params))
		{
			return $this->post_params[$name];
		}
		return $default;
	}
}
