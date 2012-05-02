<?php

class BlogController
{

	public function actionList()
	{
		$view = new View();
		
		$result = new HTMLResult();
		$result->result = $view->render('main', array('title' => 'Dummy'));
		return $result;
	}

	public function actionPost()
	{
	}

	public function actionComment()
	{
	}
}

?>