<?php

namespace models\blog;

use models\Model;
use storage\Persistable;

/**
 * @tableName Post
 */
class Post extends Model implements Persistable {

	/**
	 * @column blogId
	 * @var integer
	 */
	public $blogId;

	/**
	 * @column content
	 * @var string
	 */
	public $content;

	/**
	 * @var array
	 */
	public $comments = array();
}
