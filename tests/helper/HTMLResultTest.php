<?php

namespace test\helper;

use helper\HTMLResult;
use PHPUnit_Framework_TestCase;

class HTMLResultTest extends PHPUnit_Framework_TestCase {

	public function testResult() {
		$result = new HTMLResult('test');
		$this->assertEquals('test', $result->getResult());
		$this->assertEquals(array(
            'Content-type: text/html; charset=UTF-8',
            'Content-length: 4'
        ), $result->getHeaders());
	}
}
