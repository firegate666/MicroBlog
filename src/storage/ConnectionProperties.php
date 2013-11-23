<?php

namespace storage;

/**
 * Value object to split up and provide connection properties
 *
 * @package storage
 */
class ConnectionProperties {

	/**
	 * @var string e.g. mysql
	 */
	public $system;

	/**
	 * @var string
	 */
	public $host;

	/**
	 * @var string
	 */
	public $user;

	/**
	 * @var string
	 */
	public $pass;

	/**
	 * database name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * @var integer
	 */
	public $port;

	/**
	 * @param string $connectionString
	 */
	public function __construct($connectionString) {
		$systemUrl = explode('://', $connectionString);
		$connectionParts = explode('@', $systemUrl[1]);
		$userPass = explode(':', $connectionParts[0]);
		$hostDb = explode('/', $connectionParts[1]);
		$hostPort = explode(':', $hostDb[0]);

		$this->system = $systemUrl[0];
		$this->user = $userPass[0];
		$this->pass = $userPass[1];
		$this->host = $hostPort[0];
		$this->port = $hostPort[1];
		$this->name = $hostDb[1];
	}
}
