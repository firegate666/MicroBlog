<?php

class BlogController
{

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
}
