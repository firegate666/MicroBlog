<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('APP_ROOT', __DIR__);
define('RUNTIME_DEFAULT', APP_ROOT . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR);
define('TEMPLATES_DEFAULT', APP_ROOT . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR);
define('CONFIGURATION_DEFAULT', APP_ROOT . DIRECTORY_SEPARATOR . 'configuration' . DIRECTORY_SEPARATOR);

/*
 * register autoloader
 */
$composer_autoload = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($composer_autoload)) {
	require_once $composer_autoload;
}
