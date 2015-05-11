<?php

use app\Router;
use controller\BlogController;
use helper\ApplicationConfig;
use helper\ErrorHandler;
use helper\ExceptionHandler;
use helper\FileReader;
use helper\Request;
use Monolog\Logger;
use rendering\View;
use storage\SqliteStorage;

return [
	'error_handler' => \DI\Object(ErrorHandler::class)
		->lazy(),

	'exception_handler' => \DI\Object(ExceptionHandler::class)
		->lazy(),

	'app_router' => \DI\Object(Router::class)
		->lazy()
		->scope(\DI\Scope::SINGLETON())
		->constructor(\DI\Link('DI\Container'), \DI\Link('logger')),

	'default_controller' => \DI\Object(BlogController::class)
		->lazy()
		->constructor(\DI\Link('config'), \DI\Link('renderer'), \DI\Link('storage')),

	'config' => \DI\Object(ApplicationConfig::class)
		->lazy()
		->scope(\DI\Scope::SINGLETON())
		->constructor(
			file_get_contents(CONFIGURATION_DEFAULT . '/base.ini'),
			file_get_contents(CONFIGURATION_DEFAULT . '/default.ini')
		),

	'storage' => \DI\Object(SqliteStorage::class)
		->lazy()
		->constructor('microblog.db'),

	'request' => \DI\Object(Request::class)
		->scope(\DI\Scope::PROTOTYPE()),

	'file_reader' => \DI\Object(FileReader::class)
		->lazy()
		->scope(\DI\Scope::SINGLETON()),

	'renderer' => \DI\Object(View::class)
		->lazy()
		->scope(\DI\Scope::SINGLETON())
		->constructor(\DI\Link('config'), \DI\Link('file_reader')),

	'logger' => \DI\Object(Logger::class)
		->lazy()
		->scope(\DI\Scope::SINGLETON())
		->constructor('MicroBlog')
];
