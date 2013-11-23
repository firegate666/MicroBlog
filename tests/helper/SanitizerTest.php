<?php

namespace test\helper;

use helper\Sanitizer;

class SanitizerTest extends \PHPUnit_Framework_TestCase {

	public function testAllInt() {
		$this->assertFalse(Sanitizer::validateAllInt(array('Foo')));
		$this->assertTrue(Sanitizer::validateAllInt(array('1')));
		$this->assertTrue(Sanitizer::validateAllInt(array(1)));
		$this->assertFalse(Sanitizer::validateAllInt(array(1.2)));
		$this->assertFalse(Sanitizer::validateAllInt(array(true)));
		$this->assertFalse(Sanitizer::validateAllInt(array(false)));
		$this->assertFalse(Sanitizer::validateAllInt(array(array())));
		$this->assertTrue(Sanitizer::validateAllInt(array()));
	}

}
