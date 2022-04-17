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
final class MarkdownEngine implements Engine
{
	/**
	 * @inheritdoc
	 */
	public function render(string $template_pathname, mixed $content, array $variables): string
	{
		$markdown = file_get_contents($template_pathname);
		$html = Parsedown::instance()->parse($markdown);

		return $this->create_anchors($html);
	}

	private function create_anchors(string $html): string
	{
		return preg_replace_callback('#<h(\d)>(.+)</h#', function (array $matches) {
			[ , $level, $title] = $matches;

			$id = normalize(strip_tags($title));

			return <<<EOT
<h$level id="{$id}"><a class="anchor" href="#$id" aria-hidden="true"></a>$title</h
EOT;

		}, $html);
	}
}
