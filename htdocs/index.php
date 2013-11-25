<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'setup.php';

/*
 * create request object
 */
$request = new \helper\Request($_SERVER, $_GET, $_POST);

$app_router_class = $config->getSectionEntry('general', 'default_app_router');

/** @var \app\RouterInterface $app_router */
$app_router = new $app_router_class($config, $logger);

/** @var \helper\RequestResult $result */
$result = $app_router->run($request);

if ($config->getSectionEntry('output', 'gzip', false)) {
	ob_start('ob_gzhandler');
}

foreach ($result->getHeaders() as $header) {
	header($header, true, $result->getHttpStatus());
}

print $result->getResult();
