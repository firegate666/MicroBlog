<?php
namespace test\controller;

use controller\BlogController;
use models\blog\Blog;

class BlogControllerTest extends \PHPUnit_Framework_TestCase {

	public function testActionAjaxList() {
		$blog = new Blog();
		$blog->setAttributes(array(
			'id' => 1,
			'title' => 'Titel'
		));
		$blogs = array($blog);

		$storagemock = $this->getMockBuilder('storage\Storage')
			->disableOriginalConstructor()
			->setMethods(array('findAll'))
			->getMockForAbstractClass();

		$blog_controller = $this->getMockBuilder('controller\BlogController')
			->disableOriginalConstructor()
			->setMethods(array('getStorage'))
			->getMock();

		$blog_controller->expects($this->any())
			->method('getStorage')
			->will($this->returnValue($storagemock));

		$storagemock->expects($this->any())
			->method('findAll')
			->will($this->returnValue($blogs));

		$result = $blog_controller->actionAjaxList();
		$this->assertInstanceOf('helper\JSONResult', $result);
		$this->assertEquals('[{"title":"Titel","posts":[],"id":1}]', $result->getResult());
	}
}
