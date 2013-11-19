<?php

namespace app;

use helper\FileReader;
use \helper\HTMLResult;
use \helper\Request;
use \helper\ApplicationConfig;
use \rendering\View;
use Psr\Log\LoggerInterface;

/**
 * handle routing for application
 */
class Router
{

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
	 *
	 * @param ApplicationConfig $config
	 */
	public function __construct(ApplicationConfig $config, LoggerInterface $logger)
	{
		$this->config = $config;
		$this->logger = $logger;
	}

	/**
	 * use view renderer to display error page
	 * if view is null, exception is dispatched to registered exception handler
	 *
	 * @param \Exception $exception
	 * @param View $renderer
	 * @throws \Exception thrown if renderer is null
	 * @return \helper\RequestResult
	 */
	public function renderError(\Exception $exception, View $renderer = null)
	{
		$this->logger->error($exception->getMessage(), debug_backtrace(0, 10));
		if ($renderer !== null)
		{
			$result = $renderer->render($this->config->getSectionEntry('rendering', 'error_layout'),
				array(
					'exception' => $exception,
				)
			);
			return new HTMLResult($result, $exception->getCode());
		}
		else
		{
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
	public function run(Request $request)
	{
		$rendering_class = $this->config->getSectionEntry('rendering', 'class');
		try {
			if (! class_exists($rendering_class))
			{
				$rendering_class = null;
				throw new \LogicException('configured renderer is invalid', 404);
			}

			$controller_name = $this->config->getSectionEntry('general', 'default_controller'); // default
			if (! empty($_GET['controller']))
			{
				$controller_name = ucfirst($request->getOrPostParam('controller')) . 'Controller';
				$controller_name = $this->config->getSectionEntry('general', 'default_controller_namespace') . $controller_name;
			}

			if (! class_exists($controller_name))
			{
				throw new \LogicException('requested controller is invalid', 404);
			}

			$controller = new $controller_name($this->config, new $rendering_class($this->config->getSection('rendering'), new FileReader()));
			$controller->setLogger($this->logger);
			return $controller->handle($request);
		}
		catch (\Exception $e)
		{
			$renderer = $rendering_class !== null
				? new $rendering_class($this->config->getSection('rendering'), new FileReader())
				: null
			;
			return $this->renderError($e, $renderer);
		}
	}
}
