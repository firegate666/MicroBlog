<?php

namespace models\blog;

use models\Model;
use storage\Persistable;

/**
 * @tableName Post
 */
class Post extends Model implements Persistable {

	/**
	 *
	 * @var integer
	 */
	public $blog_id;

	/**
	 *
	 * @var string
	 */
	public $content;

	/**
	 * @var array
	 */
	public $comments = array();
}
