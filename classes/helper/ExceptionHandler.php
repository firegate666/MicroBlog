<?php

namespace helper;

/**
 * Default exception handler
 *
 * @package helper
 */
class ExceptionHandler
{

	/**
	 * custom exception handler
	 * display html page and add exception message and code to http headers
	 *
	 * @param \Exception $exception
	 * @return void
	 */
	function handle(\Exception $exception)
	{
		header('Content-type: text/html; charset=UTF-8', true, 500);
		header('X-Error-Code: ' . $exception->getCode());
		header('X-Exception-Message: ' . $exception->getMessage());
		print "<html><body><h1>" . get_class($exception) . " " . $exception->getCode() . "</h1>";
		print "<p>" . $exception->getMessage() . "</p>";
		print "<pre>";
		print $exception->getTraceAsString();
		print "</pre></body></html>";
		exit($exception->getCode());
	}
}
