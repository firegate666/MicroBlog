<?php

namespace helper;

class ExceptionHandler
{

	/**
	 * custom exception handler
	 *
	 * @param Exception $exception
	 * @return void
	 */
	function handle(\Exception $exception)
	{
		ob_clean();
		header('Content-type: text/html; charset=UTF-8', true, 500);
		header('X-Error-Code: ' . $exception->getCode());
		header('X-Exception-Message: ' . $exception->getMessage());
		print "<html><body><h1>Exception " . $exception->getCode() . "</h1>";
		print "<p>" . $exception->getMessage() . "</p>";
		print "<pre>";
		print $exception->getTraceAsString();
		print "</pre></body></html>";
		exit($exception->getCode());
	}
}
