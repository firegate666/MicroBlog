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
