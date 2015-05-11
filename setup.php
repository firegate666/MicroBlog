<?php

use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;

use Monolog\Handler\StreamHandler;

$builder = new ContainerBuilder();
$builder->addDefinitions(APP_ROOT . DIRECTORY_SEPARATOR . 'configuration' . DIRECTORY_SEPARATOR . 'config.php');
$builder->setDefinitionCache(new ArrayCache());
$container = $builder->build();

$logger = $container->get('logger');
$logger->pushHandler(new StreamHandler(__DIR__ . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'all.txt'));

/*
 * load application config
 */
$config = $container->get('config');

/*
 * install error and exception handler
 */
set_error_handler(array($container->get('error_handler'), 'handle'));
set_exception_handler(array($container->get('exception_handler'), 'handle'));
