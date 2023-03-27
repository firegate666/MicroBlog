<?php

use app\RouterInterface;

/** @var \helper\ApplicationConfig $config */
/** @var \Monolog\Logger $logger */

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'setup.php';

/*
 * create request object
 */
$request = new \helper\Request($_SERVER, $_GET, $_POST);

/** @var RouterInterface $app_router */
$app_router = new \app\Router($logger);

$result = $app_router->run($request);

if ($config->getSectionEntry('output', 'gzip', false)) {
	ob_start('ob_gzhandler');
}

foreach ($result->getHeaders() as $header) {
	header($header, true, $result->getHttpStatus());
}

print $result->getResult();
