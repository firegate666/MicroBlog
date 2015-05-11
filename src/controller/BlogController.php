<?php

namespace controller;

use helper\HTMLResult;

use helper\JSONResult;
use models\blog\Blog;
use models\blog\Post;

class BlogController extends AbstractActionController {

	/**
	 * @return HTMLResult
	 */
	public function actionIndex() {
		$result = $this->getView()
			->render('blog/index');

		return new HTMLResult($result);
	}

	/**
	 * render list data from blog entries
	 *
	 * @return JSONResult
	 */
	public function actionAjaxList() {
		$list = $this->getStorage()
			->findAll(new Blog(), array('title' => 'ASC'));

		return new JSONResult($list);

	}

	/**
	 * insert new post for blog
	 *
	 * @param integer $postBlogId
	 * @param string $postContents
	 * @return \helper\JSONResult
	 */
	public function actionAjaxPost($postBlogId, $postContents) {
		$post = new Post();
		// TODO check privileges
		$post->blogId = $postBlogId;
		$post->content = $postContents;
		$response = $this->getStorage()->save($post);

		return new JSONResult(array($response, $postBlogId, $postContents));
	}
}
