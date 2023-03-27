<?php

namespace helper;

class ApplicationConfig {

	/**
	 *
	 * @var string content base ini
	 */
	private $baseConfigString = '';

	/**
	 *
	 * @var string content of default ini
	 */
	private $defaultConfigString = '';

	/**
	 *
	 * @var array
	 */
	private $config = array();

	/**
	 *
	 * @var array
	 */
	private $defaultConfig = array();

	/**
	 *
	 * @param string $baseConfig
	 * @param string $defaultConfig
	 */
	function __construct($baseConfig = '', $defaultConfig = '') {
		$this->baseConfigString = $baseConfig;
		$this->defaultConfigString = $defaultConfig;
		$this->init();
	}

	/**
	 * initializer
	 * expand app_env section to constants
	 *
	 * @return void
	 */
	protected function init() {
        $this->defaultConfig = parse_ini_file($this->defaultConfigString, true);

        if ($this->baseConfigString) {
			$this->config = parse_ini_file($this->baseConfigString, true);
		}

		foreach ($this->getSection('app_env', array()) as $envKey => $envValue) {
			$constant = 'APP_ENV_' . strtoupper($envKey);
			if (!defined($constant)) {
				define($constant, $envValue);
			}
		}
	}

	/**
	 * get config section
	 *
	 * @param string $configName
	 * @param mixed $default
	 * @param boolean $forceDefault
	 * @return mixed
	 */
	function getSection($configName, $default = array(), $forceDefault = false) {
		if (!$forceDefault && array_key_exists($configName, $this->config)) {
			return $this->config[$configName];
		} else if (array_key_exists($configName, $this->defaultConfig)) {
			return $this->defaultConfig[$configName];
		}
		return $default;
	}

	/**
	 * get subentry from config section
	 *
	 * @param string $configName
	 * @param string $subName
	 * @param mixed $default
	 * @return mixed
	 */
	function getSectionEntry($configName, $subName, $default = null) {
		$config = $this->getSection($configName);
		if (array_key_exists($subName, $config)) {
			return $config[$subName];
		} else {
			$config = $this->getSection($configName, array(), true);
			if (array_key_exists($subName, $config)) {
				return $config[$subName];
			}
		}
		return $default;
	}
}
