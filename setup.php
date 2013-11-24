<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('MicroBlog');
$logger->pushHandler(new StreamHandler(__DIR__ . '/log/all.txt'));

/*
 * load application config
 */
$base_config_string = file_get_contents(CONFIGURATION_DEFAULT . '/base.ini');
$default_config_string = file_get_contents(CONFIGURATION_DEFAULT . '/default.ini');
$config = new \helper\ApplicationConfig($base_config_string, $default_config_string);

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
