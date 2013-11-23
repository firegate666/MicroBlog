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
	 * @param integer $postPostId
	 * @param string $postContents
	 * @return JSONResult
	 */
	public function actionAjaxComment($postPostId, $postContents) {
		$comment = new Comment();
		$comment->postId = $postPostId;
		$comment->content = $postContents;
		$response = $this->getStorage()->save($comment);

		return new JSONResult(array($response, $postPostId, $postContents));
	}
}
