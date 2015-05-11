<?php
namespace controller;

use helper\JSONResult;
use models\blog\Comment;

class CommentController extends AbstractActionController {

	/**
	 * @return JSONResult
	 */
	public function actionAjaxList() {
		$list = $this->getStorage()->findAll(new Comment());
		return new JSONResult($list);
	}

	/**
	 * @param string $postModel
	 * @return JSONResult
	 */
	public function actionAjaxUpdate($postModel) {
		$commentModelData = json_decode($postModel, true);
		$comment = new Comment($commentModelData);

		$this->getStorage()->save($comment);

		return new JSONResult($comment);
	}
}
