<?php

namespace helper;

/**
 * Standard HTML result
 *
 * @package helper
 */
class HTMLResult extends RequestResult
{
	/**
	 * @return string html string
	 */
	public function getResult()
	{
		return $this->result;
	}
}
