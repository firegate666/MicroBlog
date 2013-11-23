<?php
/**
 * Created by PhpStorm.
 * User: marcobehnke
 * Date: 23.11.13
 * Time: 22:10
 */

namespace test\storage;

use storage\WhereBuilder;

class WhereBuilderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var WhereBuilder
	 */
	private $builder;

	public function setUp() {
		parent::setUp();
		$this->builder = new WhereBuilder();
	}

	public function testWhere() {
		$where = $this->builder->build(array(
			'id' => 17
		));

		$this->assertEquals(' WHERE id = :id', $where);
	}

	public function testWhereIn() {
		$where = $this->builder->build(array(
			'id' => array(1, 2, 3, 4, 5)
		));

		$this->assertEquals(' WHERE id IN (1, 2, 3, 4, 5)', $where);
	}

	public function testWhereInString() {
		$this->setExpectedException('InvalidArgumentException', 'IN statement with strings is not supported yet');
		$this->builder->build(array(
			'id' => array(1, 'foo', 3, 4, 5)
		));
	}

	public function testWhereNot() {
		$where = $this->builder->build(array(
			array(
				'__NOT__' => array('id' => 17)
			),
			'title' => 'foo'
		));

		$this->assertEquals(' WHERE (NOT(id = :id)) AND title = :title', $where);
	}

	public function testWhereAnd() {
		$where = $this->builder->build(array(
			'id' => 17,
			'title' => 'foo'
		));

		$this->assertEquals(' WHERE id = :id AND title = :title', $where);
	}

	public function testWhereBrackets() {
		$where = $this->builder->build(array(
			array(
				'id' => 17,
				'title' => 'foo'
			)
		));

		$this->assertEquals(' WHERE (id = :id AND title = :title)', $where);
	}

	public function testWhereAndOr() {
		$where = $this->builder->build(array(
			'title' => 'foo',
			'__OR__' => array(
				'id' => 17,
				'title' => 'foo'
			)
		));

		$this->assertEquals(' WHERE title = :title AND (id = :id OR title = :title)', $where);
	}

	public function testWhereOr() {
		$where = $this->builder->build(array(
			'__OR__' => array(
				'id' => 17,
				'title' => 'foo'
			)
		));

		$this->assertEquals(' WHERE (id = :id OR title = :title)', $where);
	}

	public function testWhereAll() {
		$where = $this->builder->build(array(
			array(
				'__NOT__' => array(
					'__OR__' => array(
						'id' => 17,
						'title' => 'foo',
						array(
							'bar' => 'bar',
							'baz' => 'baz'
						)
					),
					array('foo' => 'bar')
				)
			)
		));

		$this->assertEquals(' WHERE (NOT((id = :id OR title = :title OR (bar = :bar AND baz = :baz)) AND (foo = :foo)))', $where);
	}

	public function testWhereNull() {
		$where = $this->builder->build(array(
			'id' => null
		));

		$this->assertEquals(' WHERE id IS NULL', $where);
	}

}
