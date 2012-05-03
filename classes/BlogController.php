<?php

class BlogController extends Controller
{

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
			return call_user_func_array(array($this, $action_name), array());
		}
		throw new LogicException('invalid action requested', 404);
	}
}
