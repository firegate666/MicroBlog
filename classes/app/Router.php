<?php
namespace app;

use helper\Request;
use helper\ApplicationConfig;

class Router {

	private $config;

	public function __construct(ApplicationConfig $config) {
		$this->config = $config;
	}

	public function run(Request $request) {
		$controller_name = $this->config->getSectionEntry('general', 'default_controller'); // default
		if (! empty($_GET['controller']))
		{
			$controller_name = ucfirst($request->getOrPostParam('controller')) . 'Controller';
			$controller_name = $this->config->getSectionEntry('general', 'default_controller_namespace').$controller_name;
		}

		if (!class_exists($controller_name))
		{
			throw new \LogicException('requested controller is invalid', 404);
		}

		$rendering_class = $this->config->getSectionEntry('rendering', 'class');
		$controller = new $controller_name($this->config, new $rendering_class($this->config->getSection('rendering')));
		return $controller->handle($request);
	}
}
