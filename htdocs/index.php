<?php

use app\RouterInterface;
use DI\Container;
use helper\RequestResult;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'setup.php';

/** @var Container $container */

/*
 * create request object
 */
$request = $container->make('request', array(
	'serverVars' => $_SERVER,
	'getParams' => $_GET,
	'postParams' => $_POST
));

/** @var RouterInterface $app_router */
$app_router = $container->get('app_router');

/** @var RequestResult $result */
$result = $app_router->run($request);

if ($config->getSectionEntry('output', 'gzip', false)) {
	ob_start('ob_gzhandler');
}

foreach ($result->getHeaders() as $header) {
	header($header, true, $result->getHttpStatus());
}

print $result->getResult();
