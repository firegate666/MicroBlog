<?php

namespace helper;

class ErrorHandler
{

	/**
	 * convert php error to RuntimeException
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
