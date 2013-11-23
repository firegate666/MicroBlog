<?php

namespace test\helper;

use helper\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {

	public function testGetPostOrder() {
		$request = new Request(array('server' => 'baz'), array('foo' => 'get'), array('foo' => 'post'));

		$this->assertEquals('get', $request->getOrPostParam('foo'));
		$this->assertEquals('post', $request->postOrGetParam('foo'));
	}

	public function testRequestParameter() {
		$request = new Request(array('server' => 'baz'), array('get' => 'foo'), array('post' => 'bar'));

		$this->assertEquals('foo', $request->getOrPostParam('get'));
		$this->assertEquals('bar', $request->getOrPostParam('post'));
		$this->assertEquals(null, $request->getOrPostParam('nopost'));
		$this->assertEquals('null', $request->getOrPostParam('nopost', 'null'));

		$this->assertEquals('foo', $request->postOrGetParam('get'));
		$this->assertEquals('bar', $request->postOrGetParam('post'));
		$this->assertEquals(null, $request->postOrGetParam('nopost'));
		$this->assertEquals('null', $request->postOrGetParam('nopost', 'null'));

		$this->assertEquals('foo', $request->getParam('get'));
		$this->assertEquals(null, $request->getParam('post'));
		$this->assertEquals('null', $request->getParam('post', 'null'));

		$this->assertEquals(null, $request->postParam('get'));
		$this->assertEquals('null', $request->postParam('get', 'null'));
		$this->assertEquals('bar', $request->postParam('post'));

		$this->assertTrue($request->hasGetOrPostParam('get'));
		$this->assertTrue($request->hasGetOrPostParam('post'));

		$this->assertTrue($request->hasGetParam('get'));
		$this->assertFalse($request->hasGetParam('post'));

		$this->assertFalse($request->hasPostParam('get'));
		$this->assertTrue($request->hasPostParam('post'));
	}

	public function testIsAjax() {
		$request = new Request(array('server' => 'baz'), array('get' => 'foo'), array('post' => 'bar'));
		$this->assertFalse($request->isAjax());

		$request = new Request(array('HTTP_X_REQUESTED_WITH' => 'baz'), array('get' => 'foo'), array('post' => 'bar'));
		$this->assertTrue($request->isAjax());
	}

	public function testRequestMethod() {
		$request = new Request(array('REQUEST_METHOD' => 'baz'), array('get' => 'foo'), array('post' => 'bar'));
		$this->assertFalse($request->isGet());
		$this->assertFalse($request->isPost());

		$request = new Request(array('REQUEST_METHOD' => 'GET'), array('get' => 'foo'), array('post' => 'bar'));
		$this->assertTrue($request->isGet());
		$this->assertFalse($request->isPost());

		$request = new Request(array('REQUEST_METHOD' => 'POST'), array('get' => 'foo'), array('post' => 'bar'));
		$this->assertFalse($request->isGet());
		$this->assertTrue($request->isPost());
	}

	public function testServerVars() {
		$request = new Request(array('server' => 'baz'), array('get' => 'foo'), array('post' => 'bar'));

		$this->assertEquals('baz', $request->serverVar('server'));
		$this->assertEquals(null, $request->serverVar('noserver'));
		$this->assertEquals('default', $request->serverVar('noserver', 'default'));
	}

}
