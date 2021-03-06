<?php

namespace helper;

use ErrorException;

/**
 * Default error handler
 *
 * @package helper
 */
class ErrorHandler {

	/**
	 * convert php error to ErrorException
	 *
	 * @param integer $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param integer $errline
	 * @throws ErrorException
	 * @return void
	 */
	function handle($errno, $errstr, $errfile, $errline) {
		throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
}
