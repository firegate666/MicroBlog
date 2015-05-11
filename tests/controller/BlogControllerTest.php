<?php
namespace test\controller;

use controller\BlogController;
use models\blog\Blog;
use PHPUnit_Framework_TestCase;
use storage\Storage;

class BlogControllerTest extends PHPUnit_Framework_TestCase {

	public function testActionAjaxList() {
		$blog = new Blog();
		$blog->setAttributes(array(
			'id' => 1,
			'title' => 'Titel'
		));
		$blogs = array($blog);

		$storagemock = $this->getMockBuilder(Storage::class)
			->disableOriginalConstructor()
			->setMethods(array('findAll'))
			->getMockForAbstractClass();

		$blog_controller = $this->getMockBuilder(BlogController::class)
			->disableOriginalConstructor()
			->setMethods(array('getStorage'))
			->getMock();

		$blog_controller->expects($this->any())
			->method('getStorage')
			->will($this->returnValue($storagemock));

		$storagemock->expects($this->any())
			->method('findAll')
			->will($this->returnValue($blogs));

		/** @var BlogController $blog_controller */
		$result = $blog_controller->actionAjaxList();
		$this->assertInstanceOf('helper\JSONResult', $result);
		$this->assertEquals('[{"title":"Titel","posts":[],"id":1}]', $result->getResult());
	}
}
