<?php
namespace helper;

class ApplicationConfig
{

	private $config = array();

	/**
	 *
	 * @param string $path_to_config
	 */
	function __construct($path_to_config)
	{
		$this->config = parse_ini_file($path_to_config, true);
	}

	/**
	 * get config section
	 *
	 * @param string $config_name
	 * @param mixed $default
	 * @return mixed
	 */
	function getSection($config_name, $default = null)
	{
		if (array_key_exists($config_name, $this->config))
		{
			return $this->config[$config_name];
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
	function getSectionEntry($config_name, $sub_name, $default = null) {
		$config = $this->getSection($config_name);
		if (array_key_exists($sub_name, $config))
		{
			return $config[$sub_name];
		}
		return $default;

	}
}
