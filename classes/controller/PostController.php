<?php
/**
 * Created by PhpStorm.
 * User: marcobehnke
 * Date: 29.10.13
 * Time: 21:39
 */

namespace controller;

use \helper\JSONResult;

use \models\blog\Post;

/**
 * Handle all posts
 *
 * @package controller
 */
class PostController extends AbstractActionController
{

	/**
	 * @return JSONResult
	 */
	public function actionAjaxList()
    {
	    $list = $this->getStorage()->findAll(new Post());
        return new JSONResult($list);
    }

}
