<?php
require_once __DIR__.'/../bootstrap.php';

$controller_name = 'BlogController'; // default
if (! empty($_GET['controller']))
{
	$controller_name = ucfirst($_GET['controller']) . 'Controller';
}

if (! class_exists($controller_name))
{
	throw new LogicException('requested controller is invalid', 404);
}

$controller = new $controller_name($config);
$result = $controller->handle($request);

if ($result instanceof HTMLResult)
{
	header('Content-type: text/html; charset=UTF-8');
	print $result->result;
	exit(0);
}
