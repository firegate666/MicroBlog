<?php

namespace test\storage;

use models\blog\Blog;
use PHPUnit_Framework_TestCase;
use storage\OrderByBuilder;


class OrderByBuilderTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var OrderByBuilder
	 */
	private $builder;

	public function setUp() {
		parent::setUp();

		$this->builder = new OrderByBuilder();
	}

	public function testOrders() {
		$blog = new Blog();

		$orderBy = $this->builder->build(array(
			'id' => 'ASC',
			'title' => 'DESC'
		), $blog);

		$this->assertEquals(' ORDER BY id ASC, title DESC', $orderBy);
	}

	public function testOrdersEmpty() {
		$blog = new Blog();

		$orderBy = $this->builder->build(array(), $blog);

		$this->assertEquals(' ORDER BY id DESC', $orderBy);
	}

}
