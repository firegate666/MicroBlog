<?php

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$builder = new ContainerBuilder();
$builder->addDefinitions(APP_ROOT . DIRECTORY_SEPARATOR . 'configuration' . DIRECTORY_SEPARATOR . 'di.php');
$builder->setDefinitionCache(new ArrayCache());
$container = $builder->build();

/** @var Logger $logger */
$logger = $container->get('logger');
$logger->pushHandler(new StreamHandler(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'all.txt'));
$logger->pushHandler(new StreamHandler(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'error.txt', Logger::ERROR));

/*
 * load application config
 */
$config = $container->get('config');

/*
 * install error and exception handler
 */
set_error_handler(array($container->get('error_handler'), 'handle'));
set_exception_handler(array($container->get('exception_handler'), 'handle'));
