<?php

namespace models\blog;

use models\Model;

class Post extends Model
{

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
}
