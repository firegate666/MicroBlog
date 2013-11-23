<?php

namespace controller;

use helper\HTMLResult;

use helper\JSONResult;
use models\blog\Blog;
use models\blog\Comment;
use models\blog\Post;

class BlogController extends AbstractActionController {

	public function actionIndex() {
		$result = $this->getView()
			->render('blog/index');

		return new HTMLResult($result);
	}

	/**
	 * render list with blog entries
	 *
	 * @return HTMLResult
	 */
	public function actionList() {
		$result = $this->getView()
			->render('bloglist');

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

	public function actionShow($id) {
		$blog = $this->getStorage()->load(new Blog(array('id' => $id)));
		if (empty($blog->id)) {
			throw new \InvalidArgumentException('Blog not found', 404);
		}

		$blog->posts = $this->getStorage()
			->find(new Post(), array('blog_id' => $blog->id));

		foreach ($blog->posts as $post) {
			$post->comments = $this->getStorage()
				->find(new Comment(), array('post_id' => $post->id));
		}

		$result = $this->getView()
			->render('blog', array('blog' => $blog));

		return new HTMLResult($result);
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
		// TODO check privs
		$post->blog_id = $post_blog_id;
		$post->content = $post_contents;
		$response = $this->getStorage()->save($post);

		return new JSONResult(array($response, $post_blog_id, $post_contents));
	}

	public function actionAjaxComment($post_post_id, $post_contents) {
		$comment = new Comment();
		$comment->post_id = $post_post_id;
		$comment->content = $post_contents;
		$response = $this->getStorage()->save($comment);

		return new JSONResult(array($response, $post_post_id, $post_contents));
	}

}
