<?php

namespace controller;

use \helper\HTMLResult;
use \helper\Request;

class BlogController extends Controller
{

	/**
	 * render list with blog entries
	 *
	 * @return HTMLResult
	 */
	public function actionList()
	{
		$result = $this->getView()
			->render('blog', array('title' => 'Dummy'));
		$this->getStorage();
		return new HTMLResult($result);
	}

	public function actionPost()
	{
	}

	public function actionComment()
	{
	}

	/*
	 * (non-PHPdoc) @see Controller::handle()
	 */
	public function handle(Request $request)
	{
		$action_name = 'action' . ucfirst($request->getParam('action', 'list'));
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
			return call_user_func_array(array($this, $action_name), $func_args);
		}
		throw new \LogicException('invalid action requested', 404);
	}
}
