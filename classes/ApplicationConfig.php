<?php

class ApplicationConfig {

	private $config = array();

	function __construct($path_to_config) {
		$this->config = parse_ini_file($path_to_config, true);
	}
}
