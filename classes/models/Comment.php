<?php

namespace models;

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
