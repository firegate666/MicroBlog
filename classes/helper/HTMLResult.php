<?php

namespace helper;

class HTMLResult extends RequestResult
{
	/*
	 * (non-PHPdoc) @see Result::getResult()
	 */
	public function getResult()
	{
		return $this->result;
	}
}
