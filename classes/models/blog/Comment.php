<?php

namespace models\blog;

use models\Model;

/**
 * @tableName Comment
 */
class Comment extends Model implements Persistable
{

	/**
	 *
	 * @var integer
	 */
	public $post_id;

	/**
	 *
	 * @var string
	 */
	public $content;
}
