<?php

namespace models\blog;

use models\Model;
use storage\Persistable;

/**
 * @tableName Comment
 */
class Comment extends Model implements Persistable {

	/**
	 *
	 * @var integer
	 */
	public $postId;

	/**
	 *
	 * @var string
	 */
	public $content;
}
