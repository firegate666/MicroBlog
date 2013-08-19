<?php

namespace models\blog;

use models\Model;

class Comment extends Model
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
