<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie;

use ICanBoogie\Render\Renderer;
use PHPUnit\Framework\TestCase;

class TestIntegration extends TestCase
{
	public function test_md_file_should_be_render()
	{
		$html = app()->render([], [

			Renderer::OPTION_TEMPLATE => 'sample'

		]);

		$this->assertSame('<h1 id="hello"><a class="anchor" href="#hello" aria-hidden="true"></a>Hello!</h1>', $html);
	}
}
