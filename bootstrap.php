<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('APP_ROOT', __DIR__);
define('RUNTIME_DEFAULT', APP_ROOT . '/runtime/');
define('TEMPLATES_DEFAULT', APP_ROOT . '/templates/');

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

/*
 * load application config
 */

$config = new \helper\ApplicationConfig(__DIR__ . '/configuration/base.ini');

/*
 * install error and exception handler
 */

$error_handler = $config->getSectionEntry('general', 'error_handler', false);
if ($error_handler !== false)
{
	set_error_handler(array(new $error_handler, 'handle'));
}

$exception_handler = $config->getSectionEntry('general', 'exception_handler', false);
if ($exception_handler !== false)
{
	set_exception_handler(array(new $exception_handler, 'handle'));
}

/*
 * create request object
 */

$request = new \helper\Request($_SERVER, $_GET, $_POST);
