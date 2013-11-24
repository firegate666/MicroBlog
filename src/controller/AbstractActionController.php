<?php

namespace controller;

use helper\Request;

abstract class AbstractActionController extends Controller {

	/**
	 * Default implementation for access control
	 *
	 * @param string $actionName
	 * @param Request $request
	 * @throws \LogicException
	 * @return boolean true
	 */
	public function isAllowed($actionName, Request $request) {
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

	/**
	 * @param Request $request
	 * @return string
	 */
	protected function determineActionName(Request $request) {
		$actionName = 'action' . ucfirst($request->getParam('action', 'index'));
		if ($request->isAjax()) {
			// dispatch to ajax action
			$actionName = 'actionAjax' . ucfirst($request->getParam('action', 'index'));
		}

		return $actionName;
	}

	/**
	 * @param string $actionName
	 * @param Request $request
	 * @return array
	 */
	protected function determineActionArgs($actionName, Request $request) {
		$mth = new \ReflectionMethod($this, $actionName);
		$funcArgs = array();
		$isPost = $request->isPost();

		foreach ($mth->getParameters() as $parameter) {
			$name = $parameter->getName();

			$value = null;
			if ($isPost && substr($name, 0, 4) === 'post') {
				$value = $request->postParam(lcfirst(substr($name, 4)), null);
			} else if (substr($name, 0, 3) === 'get') {
				$value = $request->getParam(lcfirst(substr($name, 3)), null);
			} else {
				$value = $request->getOrPostParam($name, null);
			}
			$funcArgs[] = $value !== null ? $value : $parameter->getDefaultValue();
		}

		return $funcArgs;
	}

	/**
	 * @param string $actionName
	 * @param array $funcArgs
	 * @param Request $request
	 * @return mixed
	 * @throws \LogicException
	 */
	protected function executeAction($actionName, $funcArgs, Request $request) {
		$beforeAction = 'before' . ucfirst($actionName);
		$afterAction = 'after' . ucfirst($actionName);

		if (!call_user_func_array(array($this, 'beforeAction'), array($request))) {
			throw new \LogicException('before action call failed', 500);
		}

		if (method_exists($this, $beforeAction)) {
			call_user_func_array(array($this, $beforeAction), array_merge(array($request), $funcArgs));
		}

		$actionResult = call_user_func_array(array($this, $actionName), $funcArgs);

		if (method_exists($this, $afterAction)) {
			call_user_func_array(array($this, $afterAction), array_merge(array($request), $funcArgs));
		}

		if (!call_user_func_array(array($this, 'afterAction'), array($request))) {
			throw new \LogicException('after action call failed', 500);
		}

		return $actionResult;
	}

	/**
	 * @inheritdoc
	 */
	public function handle(Request $request) {
		$actionName = $this->determineActionName($request);

		$this->getLogger()->debug($actionName);

		if (is_callable(array($this, $actionName))) {
			if (!$this->isAllowed($actionName, $request)) {
				throw new \LogicException('Forbidden', 403);
			}

			$funcArgs = $this->determineActionArgs($actionName, $request);

			return $this->executeAction($actionName, $funcArgs, $request);
		}
		throw new \LogicException(sprintf('invalid action "%s" requested', $actionName), 404);
	}
}
