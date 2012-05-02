<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

spl_autoload_register(function ($class_name)
{
	$file_name = __DIR__ . '/classes/' . $class_name . '.php';
	if (file_exists($file_name))
	{
		require_once $file_name;
	}
});

$controller_name = 'BlogController'; // default
if (!empty($_GET['controller'])) {
	$controller_name = ucfirst($_GET['controller']) . 'Controller';
}

$action_name = 'actionList';
if (!empty($_GET['action'])) {
	$action_name = 'action'.ucfirst($_GET['action']);
}

if (!is_callable(array($controller_name, $action_name))) {
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
