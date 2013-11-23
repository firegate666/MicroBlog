<?php

namespace controller;

use helper\ApplicationConfig;
use helper\Request;
use Psr\Log\LoggerInterface;
use rendering\RenderingInterface;
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
	 * @var RenderingInterface
	 */
	private $view;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * get view renderer
	 *
	 * @return RenderingInterface
	 */
	protected function getView() {
		return $this->view;
	}

	/**
	 *
	 * @param ApplicationConfig $config
	 * @param RenderingInterface $view
	 */
	public function __construct(ApplicationConfig $config, RenderingInterface $view) {
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
		$storageConfig = $this->getConfig('storage');
		$this->storage = new $storageConfig['class']($storageConfig['identifier']);
		$this->storage->setLogger($this->getLogger());
		return $this->storage;
	}

	/**
	 *
	 * @param string $configName
	 * @param mixed $default
	 * @return mixed
	 */
	protected function getConfig($configName, $default = null) {
		return $this->config->getSection($configName, $default);
	}

	/**
	 *
	 * @param Request $request
	 * @throws \LogicException
	 * @return mixed
	 */
	public abstract function handle(Request $request);
}
