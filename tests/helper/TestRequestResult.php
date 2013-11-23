<?php
/**
 * Created by PhpStorm.
 * User: marcobehnke
 * Date: 24.11.13
 * Time: 00:44
 */

namespace test\helper;

use helper\RequestResult;

class TestRequestResult extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RequestResult
	 */
	private $result;

	public function setUp() {
		$this->result = $this->getMockBuilder('helper\RequestResult')
			->setConstructorArgs(array('foo', 666))
			->getMockForAbstractClass();
	}

	public function testCode() {
		$this->assertEquals(666, $this->result->getHttpStatus());
	}

	public function testValidUntil() {
		$this->assertFalse($this->result->validUntil());
	}

}
