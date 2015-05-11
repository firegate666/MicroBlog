<?php
use helper\Request;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'setup.php';

/** @var \DI\Container $container */

/*
 * create request object
 */
$request = $container->make('request', array(
	'serverVars' => $_SERVER,
	'getParams' => $_GET,
	'postParams' => $_POST
));

/** @var \app\RouterInterface $app_router */
$app_router = $container->get('app_router');

/** @var \helper\RequestResult $result */
$result = $app_router->run($request);

if ($config->getSectionEntry('output', 'gzip', false)) {
	ob_start('ob_gzhandler');
}

foreach ($result->getHeaders() as $header) {
	header($header, true, $result->getHttpStatus());
}

print $result->getResult();
