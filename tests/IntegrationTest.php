<?php

namespace ICanBoogie;

use ICanBoogie\Render\Renderer;

class TestIntegration extends \PHPUnit_Framework_TestCase
{
	public function test_md_file_should_be_render()
	{
		$html = app()->render([], [

			Renderer::OPTION_TEMPLATE => 'sample'

		]);

		$this->assertSame("<h1>Hello!</h1>", $html);
	}
}
