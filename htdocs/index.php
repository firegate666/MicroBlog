<?php
require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../setup.php';

/*
 * create request object
 */
$request = new \helper\Request($_SERVER, $_GET, $_POST);

$app_router_class = $config->getSectionEntry('general', 'default_app_router');
$app_router = new $app_router_class($config, $logger);
$result = $app_router->run($request);

if ($result instanceof \helper\HTMLResult || $result instanceof \helper\JSONResult)
{
	if ($config->getSectionEntry('output', 'gzip', false))
	{
		ob_start('ob_gzhandler');
	}

foreach ($result->getHeaders() as $header) {
	header($header, true, $result->getHttpStatus());
}

print $result->getResult();
