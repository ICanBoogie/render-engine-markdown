<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\Render;

/**
 * Renders PHP templates.
 */
class MarkdownEngine implements Engine
{
	/**
	 * @inheritdoc
	 */
	public function __invoke($template_pathname, $thisArg, array $variables, array $options = [])
	{
		$text = file_get_contents($template_pathname);

		return \Parsedown::instance()->parse($text);
	}
}
