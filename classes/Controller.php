<?php

abstract class Controller
{
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
	
	protected function getView() {
		return $this->view;
	}
	
	public function __construct(ApplicationConfig $config, View $view) {
		$this->config = $config;
		$this->view = $view;
	}
	
	protected function getStorage() {
		if (isset($this->storage)) {
			return $this->storage;
		}
		$storage_config = $this->getConfig('storage');
		$this->storage = new $storage_config['class']($storage_config['identifier']);
		return $this->storage;
	}
	
	protected function getConfig($config_name, $default = null) {
		return $this->config->getConfig($config_name, $default);
	}
	
	/**
	 * 
	 * @param Request $request
	 * @throws LogicException
	 * @return mixed
	 */
	public abstract function handle(Request $request);
}
