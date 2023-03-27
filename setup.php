<?php

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;

use helper\ApplicationConfig;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('MicroBlog');
$logger->pushHandler(new StreamHandler(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'all.txt'));
$logger->pushHandler(new StreamHandler(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'error.txt', Logger::ERROR));

/*
 * load application config
 */
$config = new ApplicationConfig(CONFIGURATION_DEFAULT . '/base.ini', CONFIGURATION_DEFAULT . '/default.ini');

/*
 * install error and exception handler
 */
set_error_handler(array(new \helper\ErrorHandler(), 'handle'));
set_exception_handler(array(new \helper\ExceptionHandler(), 'handle'));
