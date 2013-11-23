<?php

namespace app;

use controller\Controller;
use helper\ApplicationConfig;
use helper\FileReader;
use helper\HTMLResult;
use helper\RequestResult;
use helper\Request;
use Psr\Log\LoggerInterface;
use rendering\RenderingInterface;
use rendering\InvalidRendererClassException;

/**
 * handle routing for application in regards of controller and action
 */
class Router {

	/**
	 *
	 * @var ApplicationConfig
	 */
	private $config;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @param ApplicationConfig $config
	 * @param LoggerInterface $logger
	 */
	public function __construct(ApplicationConfig $config, LoggerInterface $logger) {
		$this->config = $config;
		$this->logger = $logger;
	}

	/**
	 * use view renderer to display error page
	 * if view is null, exception is dispatched to registered exception handler
	 *
	 * @param \Exception $exception
	 * @param RenderingInterface $renderer
	 * @throws \Exception thrown if renderer is null
	 * @return RequestResult
	 */
	public function renderError(\Exception $exception, RenderingInterface $renderer = null) {
		$this->logger->error($exception->getMessage(), debug_backtrace(0, 10));
		if ($renderer !== null) {
			$result = $renderer->render($this->config->getSectionEntry('rendering', 'error_layout'),
				array(
					'exception' => $exception,
				)
			);
			return new HTMLResult($result, $exception->getCode());
		} else {
			// dispatch to registered exception handler
			throw $exception;
		}
	}

	/**
	 *
	 * @param Request $request
	 * @throws \LogicException
	 * @return mixed
	 */
	public function run(Request $request) {
		try {
			return $this->createController($request)
				->handle($request);
		} catch (InvalidRendererClassException $e) {
			return $this->renderError($e, null);
		} catch (\Exception $e) {
			return $this->renderError($e, $this->createRenderer());
		}
	}

	/**
	 * @return FileReader
	 */
	protected function createFileReader() {
		return new FileReader();
	}

	/**
	 * @throws InvalidRendererClassException if renderer is an not existing class
	 * @return RenderingInterface
	 */
	protected function createRenderer() {
		$rendering_class_name = $this->config->getSectionEntry('rendering', 'class');

		if (!class_exists($rendering_class_name)) {
			$rendering_class = null;
			throw new InvalidRendererClassException('configured renderer is invalid', 404);
		}

		return new $rendering_class_name($this->config->getSection('rendering'), $this->createFileReader());
	}

	/**
	 * @param Request $request
	 * @throws \LogicException if controller is an not existing class
	 * @return Controller
	 */
	protected function createController(Request $request) {
		$controller_name = $this->determineControllerName($request);
		if (!class_exists($controller_name)) {
			throw new \LogicException('requested controller is invalid', 404);
		}

		/** @var Controller $controller */
		$controller = new $controller_name($this->config, $this->createRenderer());
		$controller->setLogger($this->logger);

		return $controller;
	}

	/**
	 * Determine controller name from request
	 *
	 * @param Request $request
	 * @return string
	 */
	protected function determineControllerName(Request $request) {
		$controller_name = $this->config->getSectionEntry('general', 'default_controller'); // default
		if ($request->hasGetOrPostParam('controller')) {
			$controller_name = ucfirst($request->getOrPostParam('controller')) . 'Controller';
			$controller_name = $this->config->getSectionEntry('general', 'default_controller_namespace') . $controller_name;
		}

		return $controller_name;
	}
}
