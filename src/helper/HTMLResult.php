<?php

namespace helper;

/**
 * Standard HTML result
 *
 * @package helper
 */
class HTMLResult extends RequestResult {

	/**
	 * @return string html string
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @return array
	 */
	public function getHeaders() {
		return array(
			'Content-type: text/html; charset=UTF-8', true, $this->getHttpStatus(),
			'Content-length: ' . strlen($this->getResult())
		);
	}
}
