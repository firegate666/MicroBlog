<?php

namespace test\helper;

use helper\JSONResult;

class JSONResultTest extends \PHPUnit_Framework_TestCase {

	public function testResult() {
		$result = new JSONResult(array('test' => 'test'));
		$this->assertEquals('{"test":"test"}', $result->getResult());
		$this->assertEquals(array(
			'Content-type: application/json; charset=UTF-8',
			'Content-length: 15'
		), $result->getHeaders());
	}
}
