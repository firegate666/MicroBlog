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


class PostController extends AbstractActionController
{

    public function actionAjaxList()
    {
	    $list = $this->getStorage()->findAll(new Post());
        return new JSONResult($list);
    }

}
