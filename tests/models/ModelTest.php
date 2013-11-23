<?php

namespace test\models;

use models\Model;

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
	 * @todo Implement testGetValidationMessages().
	 */
	public function testGetValidationMessages() {
		$this->assertEmpty($this->object->getValidationMessages());
	}

	/**
	 * @todo Implement testIsValid().
	 */
	public function testIsValid() {
		$this->assertTrue($this->object->isValid());
	}

	/**
	 * @todo Implement testSetAttributes().
	 */
	public function testSetAttributes() {
		$this->object->setAttributes(array(
			'id' => 1
		));

		$this->assertEquals(1, $this->object->id);
	}

}
