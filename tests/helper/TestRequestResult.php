<?php

namespace test\helper;

use helper\RequestResult;
use PHPUnit_Framework_TestCase;

class TestRequestResult extends PHPUnit_Framework_TestCase {

	/**
	 * @var RequestResult
	 */
	private $result;

	public function setUp() {
		$this->result = $this->getMockBuilder(RequestResult::class)
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
