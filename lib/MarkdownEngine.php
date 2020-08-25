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

use Parsedown;
use function file_get_contents;
use function ICanBoogie\normalize;
use function preg_replace_callback;
use function strip_tags;

/**
 * Renders Markdown.
 */
class MarkdownEngine implements Engine
{
	/**
	 * @inheritdoc
	 */
	public function __invoke($template_pathname, $thisArg, array $variables, array $options = []): string
	{
		$markdown = file_get_contents($template_pathname);
		$html = Parsedown::instance()->parse($markdown);
		$html = $this->create_anchors($html);

		return $html;
	}

	private function create_anchors(string $html): string
	{
		return preg_replace_callback('#<h(\d)>(.+)</h#', function (array $matches) {

			list( , $level, $title) = $matches;

			$id = normalize(strip_tags($title));

			return <<<EOT
<h$level id="{$id}"><a class="anchor" href="#$id" aria-hidden="true"></a>$title</h
EOT;

		}, $html);
	}
}
