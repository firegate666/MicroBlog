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
	 * @param integer $postBlogId
	 * @param string $postContents
	 * @return JSONResult
	 */
	public function actionAjaxPost($postBlogId, $postContents) {
		$post = new Post();
		$post->blogId = $postBlogId;
		$post->content = $postContents;
		$response = $this->getStorage()->save($post);

		return new JSONResult(array($response, $postBlogId, $postContents));
	}
}
