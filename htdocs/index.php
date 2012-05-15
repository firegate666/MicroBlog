<?php
require_once __DIR__ . '/../bootstrap.php';

$controller_name = $config->getConfigSub('general', 'default_controller'); // default
if (! empty($_GET['controller']))
{
	$controller_name = ucfirst($_GET['controller']) . 'Controller';
	$controller_name = $config->getConfigSub('general', 'default_controller_namespace').$controller_name;
}

if (! class_exists($controller_name))
{
	throw new LogicException('requested controller is invalid', 404);
}

$rendering_class = $config->getConfigSub('rendering', 'class');
$controller = new $controller_name($config, new $rendering_class($config->getConfig('rendering')));
$result = $controller->handle($request);

if ($result instanceof \helper\HTMLResult)
{
	header('Content-type: text/html; charset=UTF-8');
	print $result->getResult();
	exit(0);
}
