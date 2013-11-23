<?php

namespace helper;

final class ApplicationConfig {

	/**
	 *
	 * @var string content base ini
	 */
	private $base_config_string = '';

	/**
	 *
	 * @var string content of default ini
	 */
	private $default_config_string = '';

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
	 * @param string $base_config
	 * @param string $default_config
	 */
	function __construct($base_config = '', $default_config = '') {
		$this->base_config_string = $base_config;
		$this->default_config_string = $default_config;
		$this->init();
	}

	/**
	 * initializer
	 * expand app_env section to constants
	 *
	 * @return void
	 */
	protected function init() {
		$this->default_config = parse_ini_string($this->default_config_string, true);

		if ($this->base_config_string) {
			$this->config = parse_ini_string($this->base_config_string, true);
		}

		foreach ($this->getSection('app_env', array()) as $env_key => $env_value) {
			$constant = 'APP_ENV_' . strtoupper($env_key);
			if (!\defined($constant)) {
				\define($constant, $env_value);
			}
		}
	}

	/**
	 * get config section
	 *
	 * @param string $config_name
	 * @param mixed $default
	 * @param boolean $force_default
	 * @return mixed
	 */
	function getSection($config_name, $default = array(), $force_default = false) {
		if (!$force_default && array_key_exists($config_name, $this->config)) {
			return $this->config[$config_name];
		} else if (array_key_exists($config_name, $this->default_config)) {
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
	 * @return mixed
	 */
	function getSectionEntry($config_name, $sub_name, $default = null) {
		$config = $this->getSection($config_name);
		if (array_key_exists($sub_name, $config)) {
			return $config[$sub_name];
		} else {
			$config = $this->getSection($config_name, array(), true);
			if (array_key_exists($sub_name, $config)) {
				return $config[$sub_name];
			}
		}
		return $default;
	}
}
