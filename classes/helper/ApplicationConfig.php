<?php

namespace helper;

final class ApplicationConfig
{

	/**
	 *
	 * @var string path to base ini config file
	 */
	private $path_to_config;

	/**
	 *
	 * @var array
	 */
	private $config = array();

	/**
	 *
	 * @var array
	 */
	private $default_config = array();

	/**
	 *
	 * @param string $path_to_config
	 */
	function __construct($path_to_config = '')
	{
		$this->path_to_config = $path_to_config;
		$this->init();
	}

	/**
	 * initializer
	 * expand app_env section to constants
	 *
	 * @return void
	 */
	protected function init()
	{
		$this->default_config = parse_ini_file(dirname($this->path_to_config) . '/default.ini', true);

		if (file_exists($this->path_to_config)) {
			$this->config = parse_ini_file($this->path_to_config, true);
		}

		foreach ($this->getSection('app_env', array()) as $env_key => $env_value)
		{
			$constant = 'APP_ENV_' . strtoupper($env_key);
			if (! \defined($constant))
			{
				\define($constant, $env_value);
			}
		}
	}

	/**
	 * get config section
	 *
	 * @param string $config_name
	 * @param mixed $default
	 * @return mixed
	 */
	function getSection($config_name, $default = null, $force_default = false)
	{
		if (! $force_default && array_key_exists($config_name, $this->config))
		{
			return $this->config[$config_name];
		}
		else if (array_key_exists($config_name, $this->default_config))
		{
			return $this->default_config[$config_name];
		}
		return $default;
	}

	/**
	 * get subentry from config section
	 *
	 * @param string $config_name
	 * @param string $sub_name
	 * @param mixed $default
	 * @return mixe
	 */
	function getSectionEntry($config_name, $sub_name, $default = null)
	{
		$config = $this->getSection($config_name);
		if (array_key_exists($sub_name, $config))
		{
			return $config[$sub_name];
		}
		else
		{
			$config = $this->getSection($config_name, null, true);
			if (array_key_exists($sub_name, $config))
			{
				return $config[$sub_name];
			}
		}
		return $default;
	}
}
