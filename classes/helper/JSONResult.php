<?php

namespace helper;

class JSONResult extends RequestResult
{
	/*
	 * (non-PHPdoc) @see Result::getResult()
	 */
	public function getResult()
	{
		return json_encode($this->result);
	}
}
