<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

/*
 * register autoloader
 */
spl_autoload_register(function ($class_name)
{
	$file_name = __DIR__ . '/classes/' . str_replace('\\', '/', $class_name) . '.php';
	if (file_exists($file_name))
	{
		require_once $file_name;
	}
});

/**
 *
 * @param integer $errno
 * @param string $errstr
 * @param string $errfile
 * @param integer $errline
 * @param array $errcontext
 * @return void
 */
function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
{
	ob_clean();
	header('Content-type: text/html; charset=UTF-8', true, 500);
	header('X-Error-Code: ' . $errno);
	header('X-Error-Message: ' . $errstr);
	print "<html><body><h1>Error " . $errno . "</h1>";
	print "<p>" . $errstr . "</p>";
	print "<pre>";
	debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	print "</pre></body></html>";
	exit($errno);
}

/**
 * custom exception handler
 *
 * @param Exception $exception
 * @return void
 */
function exceptionHandler(Exception $exception)
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

set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');

$config = new \helper\ApplicationConfig(__DIR__ . '/configuration/base.ini');
$request = new \helper\Request($_SERVER, $_GET, $_POST);
