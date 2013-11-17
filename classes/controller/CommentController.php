<?php
namespace controller;

use \helper\JSONResult;

use models\blog\Comment;

class CommentController extends \controller\AbstractActionController
{
	public function actionAjaxList()
    {
	    $list = $this->getStorage()->find(new Comment());
        return new JSONResult($list);
    }
}
