<?php

namespace controller;

use \helper\HTMLResult;
use \helper\JSONResult;

use \models\Blog;
use \models\Post;
use \models\Comment;

class BlogController extends AbstractActionController
{

	/**
	 * render list with blog entries
	 *
	 * @return HTMLResult
	 */
	public function actionList()
	{
		$result = $this->getView()
			->render('bloglist');

		return new HTMLResult($result);
	}

	/**
	 * render list data from blog entries
	 *
	 * @return JSONResult
	 */
	public function actionAjaxList()
	{
		$list = $this->getStorage()
			->find(new Blog(), array(), array('title' => 'ASC'));

		return new JSONResult($list);

	}

	public function actionShow($id)
	{
		$blog = new Blog();
		$blog->id = $id;

		$blog = $this->getStorage()->load($blog);
		if (empty($blog->id)) {
			throw new \InvalidArgumentException('Blog not found', 404);
		}

		$blog->posts = $this->getStorage()
			->find(new Post(), array('blog_id' => $blog->id));

		foreach($blog->posts as $post) {
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
	public function actionAjaxPost($post_blog_id, $post_contents)
	{
		$post = new Post();
		// TODO check privs
		$post->blog_id = $post_blog_id;
		$post->content = $post_contents;
		$response = $this->getStorage()->save($post);

		return new JSONResult(array($response, $post_blog_id,$post_contents));
	}

	public function actionComment()
	{
	}

}
