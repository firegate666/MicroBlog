<?php

namespace helper;

class ErrorHandler
{

	/**
	 *
	 * @param integer $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param integer $errline
	 * @param array $errcontext
	 * @return void
	 */
	function handle($errno, $errstr, $errfile, $errline, $errcontext)
	{
		throw new \RuntimeException($errstr, $errno);
	}
}
