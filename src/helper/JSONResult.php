<?php

namespace helper;

/**
 * Json request result
 *
 * @package helper
 */
class JSONResult extends RequestResult {

	/**
	 * @return string json encoded result
	 */
	public function getResult() {
		return json_encode($this->result);
	}

	/**
	 * @return array
	 */
	public function getHeaders() {
		return array(
			'Content-type: application/json; charset=UTF-8',
			'Content-length: ' . strlen($this->getResult())
		);
	}
}
