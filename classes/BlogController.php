<?php

class BlogController
{

	private $config;

	public function __construct(ApplicationConfig $config) {
		$this->config = $config;
	}

	public function actionList()
	{
		$view = new View();

		$result = new HTMLResult();
		$result->result = $view->render('blog', array('title' => 'Dummy'));
		return $result;
	}

	public function actionPost()
	{
	}

	public function actionComment()
	{
	}

	public function handle(Request $request) {
		$action_name = 'action'.ucfirst($request->getParam('action', 'list'));
		if (is_callable(array($this, $action_name))) {
			return call_user_func_array(array($this, $action_name), array());
		}
		throw new LogicException('invalid action requested', 404);
	}
}
