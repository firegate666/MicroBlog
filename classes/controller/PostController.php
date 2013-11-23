<?php

namespace controller;

use helper\JSONResult;
use models\blog\Post;

/**
 * Handle all posts
 *
 * @package controller
 */
class PostController extends AbstractActionController {

	/**
	 * @return JSONResult
	 */
	public function actionAjaxList() {
		$list = $this->getStorage()->findAll(new Post());
		return new JSONResult($list);
	}
}
