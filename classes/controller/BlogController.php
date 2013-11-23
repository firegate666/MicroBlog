<?php

namespace controller;

use helper\HTMLResult;

use helper\JSONResult;
use models\blog\Blog;
use models\blog\Comment;
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
	 * @param integer $post_blog_id
	 * @param string $post_contents
	 * @return \helper\JSONResult
	 */
	public function actionAjaxPost($post_blog_id, $post_contents) {
		$post = new Post();
		// TODO check privileges
		$post->blog_id = $post_blog_id;
		$post->content = $post_contents;
		$response = $this->getStorage()->save($post);

		return new JSONResult(array($response, $post_blog_id, $post_contents));
	}

	/**
	 * @param integer $post_post_id
	 * @param string $post_contents
	 * @return JSONResult
	 */
	public function actionAjaxComment($post_post_id, $post_contents) {
		$comment = new Comment();
		$comment->post_id = $post_post_id;
		$comment->content = $post_contents;
		$response = $this->getStorage()->save($comment);

		return new JSONResult(array($response, $post_post_id, $post_contents));
	}
}
