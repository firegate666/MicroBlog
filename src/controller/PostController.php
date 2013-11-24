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

	/**
	 * @param string $postModel json encoded post model
	 * @return JSONResult
	 */
	public function actionAjaxUpdate($postModel) {
		$postModelData = json_decode($postModel, true);
		$post = new Post($postModelData);

		$this->getStorage()->save($post);

		return new JSONResult($post);
	}
}
