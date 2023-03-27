<?php

namespace app;

use controller\BlogController;
use controller\Controller;
use Exception;
use helper\ApplicationConfig;
use helper\FileReader;
use helper\HTMLResult;
use helper\RequestResult;
use helper\Request;
use LogicException;
use Psr\Log\LoggerInterface;
use rendering\RenderingInterface;
use rendering\InvalidRendererClassException;
use rendering\View;
use storage\SqliteStorage;

/**
 * handle routing for application in regards of controller and action
 */
class Router implements RouterInterface {

	/**
	 *
	 * @var ApplicationConfig
	 */
	private $config;

    private $renderer;
    private $file_renderer;
    private $storage;
    private $default_controller;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	/**
	 * @param LoggerInterface $logger
	 */
	public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;

        $this->config = new ApplicationConfig(CONFIGURATION_DEFAULT . '/base.ini', CONFIGURATION_DEFAULT . '/default.ini');
        $this->file_renderer = new FileReader();
        $this->renderer = new View($this->config, $this->file_renderer);
        $this->storage = new SqliteStorage('microblog.db');
        $this->storage->setLogger($this->logger);
        $this->default_controller = new BlogController($this->config, $this->renderer, $this->storage);
	}

	/**
	 * use view renderer to display error page
	 * if view is null, exception is dispatched to registered exception handler
	 *
	 * @param Exception $exception
	 * @param RenderingInterface $renderer
	 * @throws Exception thrown if renderer is null
	 * @return RequestResult
	 */
	public function renderError(Exception $exception, RenderingInterface $renderer = null) {
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
	 * @throws LogicException
	 * @return RequestResult
	 */
	public function run(Request $request) {
		try {
			return $this->createController($request)
				->handle($request);
		} catch (InvalidRendererClassException $e) {
			return $this->renderError($e, null);
		} catch (Exception $e) {
			return $this->renderError($e, $this->renderer);
		}
	}

	/**
	 * @param Request $request
	 * @throws LogicException if controller is an not existing class
	 * @return Controller
	 */
	protected function createController(Request $request) {
		$controllerName = $this->determineControllerName($request);
		if ($controllerName && class_exists($controllerName)) {
			/** @var Controller $controller */
			$controller = new $controllerName(
				$this->config,
				$this->renderer,
				$this->storage
			);
		} else if (!$controllerName) {
			$controller = $this->default_controller;
		} else {
			throw new LogicException('requested controller ' . $controllerName . ' is invalid', 404);
		}

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
		$controllerName = null;

		if ($request->hasGetOrPostParam('controller')) {
			$controllerName = ucfirst($request->getOrPostParam('controller')) . 'Controller';
			$controllerName = $this->config->getSectionEntry('general', 'default_controller_namespace') . $controllerName;
		}

		return $controllerName;
	}
}
