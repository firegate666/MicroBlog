<?php

namespace models\blog;

use models\Model;
use storage\Persistable;

/**
 * @tableName Comment
 */
class Comment extends Model implements Persistable {

	/**
	 * @column postId
	 * @var integer
	 */
	public $postId;

	/**
	 * @column content
	 * @var string
	 */
	public $content;
}
