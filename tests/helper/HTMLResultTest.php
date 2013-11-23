<?php

namespace test\helper;

use helper\HTMLResult;

class HTMLResultTest extends \PHPUnit_Framework_TestCase {

	public function testResult() {
		$result = new HTMLResult('test');
		$this->assertEquals('test', $result->getResult());
	}
}
