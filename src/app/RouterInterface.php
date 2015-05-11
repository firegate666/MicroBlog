<?php

namespace app;

use helper\Request;
use helper\RequestResult;
use rendering\RenderingInterface;

interface RouterInterface {

	/**
	 *
	 * @param Request $request
	 * @throws \LogicException
	 * @return RequestResult
	 */
	public function run(Request $request);

	/**
	 * use view renderer to display error page
	 * if view is null, exception is dispatched to registered exception handler
	 *
	 * @param \Exception $exception
	 * @param RenderingInterface $renderer
	 * @throws \Exception thrown if renderer is null
	 * @return RequestResult
	 */
	public function renderError(\Exception $exception, RenderingInterface $renderer = null);
}
