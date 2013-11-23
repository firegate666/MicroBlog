<?php

namespace controller;

use helper\ApplicationConfig;
use helper\Request;
use Psr\Log\LoggerInterface;
use rendering\View;
use storage\Storage;

abstract class Controller {

	/**
	 *
	 * @var ApplicationConfig
	 */
	private $config;

	/**
	 *
	 * @var Storage
	 */
	private $storage;

	/**
	 *
	 * @var View
	 */
	private $view;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * get view renderer
	 *
	 * @return View
	 */
	protected function getView() {
		return $this->view;
	}

	/**
	 *
	 * @param ApplicationConfig $config
	 * @param View $view
	 */
	public function __construct(ApplicationConfig $config, View $view) {
		$this->config = $config;
		$this->view = $view;
	}

	/**
	 * @param LoggerInterface $logger
	 * @return void
	 */
	public function setLogger(LoggerInterface $logger) {
		$this->logger = $logger;
	}

	/**
	 * @return LoggerInterface
	 */
	public function getLogger() {
		return $this->logger;
	}

	/**
	 *
	 * @return Storage
	 */
	protected function getStorage() {
		if (isset($this->storage)) {
			return $this->storage;
		}
		$storage_config = $this->getConfig('storage');
		$this->storage = new $storage_config['class']($storage_config['identifier']);
		$this->storage->setLogger($this->getLogger());
		return $this->storage;
	}

	/**
	 *
	 * @param string $config_name
	 * @param mixed $default
	 * @return mixed
	 */
	protected function getConfig($config_name, $default = null) {
		return $this->config->getSection($config_name, $default);
	}

	/**
	 *
	 * @param Request $request
	 * @throws \LogicException
	 * @return mixed
	 */
	public abstract function handle(Request $request);
}
