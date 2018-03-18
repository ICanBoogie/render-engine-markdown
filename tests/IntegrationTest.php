<?php

namespace ICanBoogie;

use ICanBoogie\Render\Renderer;

class TestIntegration extends \PHPUnit\Framework\TestCase
{
	public function test_md_file_should_be_render()
	{
		$html = app()->render([], [

			Renderer::OPTION_TEMPLATE => 'sample'

		]);

		$this->assertSame('<h1 id="hello"><a class="anchor" href="#hello" aria-hidden="true"></a>Hello!</h1>', $html);
	}
}
