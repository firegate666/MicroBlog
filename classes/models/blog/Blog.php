<?php

namespace models\blog;

use models\Model;

class Blog extends Model
{

	/**
	 *
	 * @var string
	 */
	public $title;

	/**
	 *
	 * @var array
	 */
	public $posts = array();
}
