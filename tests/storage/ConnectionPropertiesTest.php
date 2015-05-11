<?php
namespace test\storage;

use PHPUnit_Framework_TestCase;
use storage\ConnectionProperties;

class ConnectionPropertiesTest extends PHPUnit_Framework_TestCase {

	/**
	 * Test if connection string is properly split up
	 *
	 * @return void
	 */
	public function testSplit() {
		$props = new ConnectionProperties('mysql://username:password@hostname:3306/database');

		$this->assertEquals('mysql', $props->system);
		$this->assertEquals('username', $props->user);
		$this->assertEquals('password', $props->pass);
		$this->assertEquals('hostname', $props->host);
		$this->assertEquals(3306, $props->port);
		$this->assertEquals('database', $props->name);
	}
}
