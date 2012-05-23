<?php

namespace controller;


use helper\JSONResult;

use \helper\HTMLResult;
use \helper\Request;

use \models\Blog;
use \models\Post;
use \models\Comment;

class BlogController extends Controller
{

	/**
	 * render list with blog entries
	 *
	 * @return HTMLResult
	 */
	public function actionList()
	{
		$list = $this->getStorage()->find(new Blog());

		$result = $this->getView()
			->render('bloglist', array('blogs' => $list));

		return new HTMLResult($result);
	}

	public function actionShow($id)
	{
		$blog = new Blog();
		$blog->id = $id;

		$blog = $this->getStorage()->load($blog);
		if (empty($blog->id)) {
			throw new \InvalidArgumentException('Blog not found', 404);
		}

		$blog->posts = $this->getStorage()->find(new Post(), array('blog_id' => $blog->id));
		foreach($blog->posts as $post) {
			$post->comments = $this->getStorage()->find(new Comment(), array('post_id' => $post->id));
		}

		$result = $this->getView()
			->render('blog', array('blog' => $blog));

		return new HTMLResult($result);
	}

	public function actionPost($post_contents)
	{
		return new JSONResult($post_contents);
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
			$mth = new \ReflectionMethod($this, $action_name);
			$func_args = array();
			foreach ($mth->getParameters() as $parameter) {
				$name = $parameter->getName();
				$value = null;
				if (substr($name, 0, 5) === 'post_')
				{
					$value = $request->postParam(substr($name, 5), null);
				}
				else if (substr($name, 0, 4) === 'get_')
				{
					$value = $request->getParam(substr($name, 4), null);
				}
				else
				{
					$value = $request->getOrPostParam($name, null);
				}
				$func_args[] = $value !== null ? $value : $mth->getDefaultValue();
			}
			return call_user_func_array(array($this, $action_name), $func_args);
		}
		throw new \LogicException('invalid action requested', 404);
	}
}
