<?php

class ApplicationConfig {

	private $config = array();

	function __construct($path_to_config) {
		$this->config = parse_ini_file($path_to_config, true);
	}

	function getConfig($config_name, $default = null) {
		if (array_key_exists($config_name, $this->config)) {
			return $this->config[$config_name];
		}
		return $default;
	}
}
