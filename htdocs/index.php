<?php
require_once __DIR__ . '/../bootstrap.php';

$app = new \app\Router($config);
$result = $app->run($request);

if ($result instanceof \helper\HTMLResult)
{
	header('Content-type: text/html; charset=UTF-8');
	print $result->getResult();
	exit(0);
}
