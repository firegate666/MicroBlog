<?php

namespace controller;

use \helper\Request;

abstract class AbstractActionController extends Controller
{

	/**
	 * Default implementation for access control
	 *
	 * @param string $action_name
	 * @param Request $request
	 * @throws LogicException
	 * @return boolean true
	 */
	public function isAllowed($action_name, Request $request) {
		return true;
	}

	/**
	 * method invoked before any action is called
	 *
	 * @param Request $request
	 * @return boolean
	 */
	public function beforeAction(Request $request) {
		return true;
	}

	/**
	 * method invoked after any action is called
	 *
	 * @param Request $request
	 * @return boolean
	 */
	public function afterAction(Request $request) {
		return true;
	}

	/*
	 * (non-PHPdoc) @see Controller::handle()
	 */
	public function handle(Request $request)
	{
		$action_name = 'action' . ucfirst($request->getParam('action', 'list'));
		$beforeAction = 'before' . ucfirst($action_name);
		$afterAction = 'after' . ucfirst($action_name);

		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			// dispatch to ajax action
			$action_name = 'actionAjax' . ucfirst($request->getParam('action', 'list'));
		}

		if (is_callable(array($this, $action_name)))
		{
			$mth = new \ReflectionMethod($this, $action_name);
			$func_args = array();
			foreach ($mth->getParameters() as $parameter) {
				$name = $parameter->getName();
				$value = null;
				if (substr($name, 0, 5) === 'post_')
				{
					$value = $request->postParam(substr($name, 5), null);
				}
				else if (substr($name, 0, 4) === 'get_')
				{
					$value = $request->getParam(substr($name, 4), null);
				}
				else
				{
					$value = $request->getOrPostParam($name, null);
				}
				$func_args[] = $value !== null ? $value : $mth->getDefaultValue();
			}

			if (!$this->isAllowed($action_name, $request)) {
				throw new \LogicException('Forbidden', 403);
			}

			if (!call_user_func_array(array($this, 'beforeAction'), array($request))) {
				throw new \LogicException('before action call failed', 500);
			}

			if (method_exists($this, $beforeAction))
			{
				call_user_func_array(array($this, $beforeAction), array_merge(array($request), $func_args));
			}

			$action_result = call_user_func_array(array($this, $action_name), $func_args);

			if (method_exists($this, $afterAction))
			{
				call_user_func_array(array($this, $afterAction), array_merge(array($request), $func_args));
			}

			if (!call_user_func_array(array($this, 'afterAction'), array($request))) {
				throw new \LogicException('after action call failed', 500);
			}

			return $action_result;
		}
		throw new \LogicException('invalid action requested', 404);
	}
}
