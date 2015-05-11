<?php

use models\blog\Blog;
use models\blog\Comment;
use models\blog\Post;
use storage\Storage;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'setup.php';

switch ($_SERVER['argv'][1]) {
	case 'kickstart':
		// TODO
		// tear down all tables
		// recreate everything from sql
		break;

	case 'post:truncate':
		$container->get(('storage'))->truncate(new Post());
		break;

	case 'blog:create':
		$new_name = $_SERVER['argv'][2];
		$blog = new Blog(array('title' => $new_name));
		$container->get('storage')->save($blog);
		break;

	case 'blog:rename':
		$id = $_SERVER['argv'][2];
		$new_name = $_SERVER['argv'][3];
		/** @var Storage $storage */
		$storage = $container->get('storage');
		/** @var Blog $blog */
		$blog = $storage->load(new Blog(array('id' => $id)));
		$blog->title = $new_name;
		$storage->save($blog);
		break;

	case 'blog:truncate':
		$container->get(('storage'))->truncate(new Blog());
		break;

	case 'comment:truncate':
		$container->get(('storage'))->truncate(new Comment());
		break;
}
