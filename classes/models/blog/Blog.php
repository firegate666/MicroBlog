<?php

namespace models\blog;

use models\Model;
use storage\Persistable;

/**
 * Class Blog
 *
 * @tableName Blog
 */
class Blog extends Model implements Persistable
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
