<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('APP_ROOT', __DIR__);
define('RUNTIME_DEFAULT', APP_ROOT . '/runtime/');
define('TEMPLATES_DEFAULT', APP_ROOT . '/templates/');
define('CONFIGURATION_DEFAULT', APP_ROOT . '/configuration/');

/*
 * register autoloader
 */
spl_autoload_register(function ($class_name)
{
	$file_name = APP_ROOT . '/src/' . str_replace('\\', '/', $class_name) . '.php';
	if (file_exists($file_name))
	{
		require_once $file_name;
	}
});

$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
}
