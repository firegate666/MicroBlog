<?php
require_once __DIR__ . '/../bootstrap.php';

/*
 * create request object
 */
$request = new \helper\Request($_SERVER, $_GET, $_POST);

$app_router_class = $config->getSectionEntry('general', 'default_app_router');
$app_router = new $app_router_class($config);
$result = $app_router->run($request);

if ($result instanceof \helper\HTMLResult || $result instanceof \helper\JSONResult)
{
	if ($config->getSectionEntry('output', 'gzip', false))
	{
		ob_start('ob_gzhandler');
	}

	header('Content-type: text/html; charset=UTF-8', true, $result->getHttpStatus());
	print $result->getResult();
	exit(0);
}
