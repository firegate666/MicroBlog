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
	 * databse name
	 *
	 * @var string
	 */
	public $name;

	/**
	 * @var integer
	 */
	public $port;

	/**
	 * @param string $connection_string
	 */
	public function __construct($connection_string) {
		$system_url = explode('://', $connection_string);
		$connection_parts = explode('@', $system_url[1]);
		$user_pass = explode(':', $connection_parts[0]);
		$host_db = explode('/', $connection_parts[1]);
		$host_port = explode(':', $host_db[0]);

		$this->system = $system_url[0];
		$this->user = $user_pass[0];
		$this->pass = $user_pass[1];
		$this->host = $host_port[0];
		$this->port = $host_port[1];
		$this->name = $host_db[1];
	}

}
