<?php
require_once __DIR__.'/../bootstrap.php';

$controller_name = 'BlogController'; // default
if (! empty($_GET['controller']))
{
	$controller_name = ucfirst($_GET['controller']) . 'Controller';
}

$action_name = 'actionList';
if (! empty($_GET['action']))
{
	$action_name = 'action' . ucfirst($_GET['action']);
}

if (! is_callable(array($controller_name, $action_name)))
{
	throw new LogicException('requested controller or action is invalid', 404);
}

$controller = new $controller_name();
$result = $controller->$action_name();

if ($result instanceof HTMLResult)
{
	header('Content-type: text/html; charset=UTF-8');
	print $result->result;
	exit(0);
}
