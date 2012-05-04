<?php
require_once __DIR__ . '/../bootstrap.php';

$controller_name = 'BlogController'; // default
if (! empty($_GET['controller']))
{
	$controller_name = ucfirst($_GET['controller']) . 'Controller';
}
$controller_name = '\\controller\\'.$controller_name;

if (! class_exists($controller_name))
{
	throw new LogicException('requested controller is invalid', 404);
}

$controller = new $controller_name($config, new \rendering\View($config->getConfig('rendering')));
$result = $controller->handle($request);

if ($result instanceof \helper\HTMLResult)
{
	header('Content-type: text/html; charset=UTF-8');
	print $result->getResult();
	exit(0);
}
