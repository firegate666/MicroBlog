<?php

namespace models;

require_once dirname(__FILE__) . '/../../../classes/models/Model.php';

/**
 * Test class for Model.
 * Generated by PHPUnit on 2013-08-19 at 21:40:00.
 */
class ModelTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Model
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new Model;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {

	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testGetValidationMessages().
	 */
	public function testGetValidationMessages() {
		$this->assertEmpty($this->object->getValidationMessages());
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testIsValid().
	 */
	public function testIsValid() {
		$this->assertTrue($this->object->isValid());
	}

	/**
	 * @covers {className}::{origMethodName}
	 * @todo Implement testSetAttributes().
	 */
	public function testSetAttributes() {
		$this->object->setAttributes(array(
			'id' => 1
		));

		$this->assertEquals(1, $this->object->id);
	}

}
