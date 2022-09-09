<?php

namespace SayHello\PLUGIN_NAME_PASCAL_CASE\Blocks\MyFirstBlock;

use WP_Block;

class Block
{
	public function run()
	{
		add_action('init', [$this, 'register']);
	}

	public function register()
	{

		register_block_type(__DIR__, [
			'render_callback' => [$this, 'renderBlock']
		]);
	}

	public function renderBlock(array $attributes, string $content, WP_Block $block)
	{
		$classNameBase = wp_get_block_default_classname($block->name);

		if (empty($attributes['url'] ?? '') || filter_var($attributes['url'], FILTER_VALIDATE_URL) === false) {
			return '';
		}

		$align = $attributes['align'] ?? '';
		if (!empty($align)) {
			$align = " align{$align}";
		}

		ob_start();
?>

		<div class="<?php echo $classNameBase . $align; ?>">
			<iframe class="<?php echo "{$classNameBase}__iframe"; ?>" src="<?php echo $attributes['url']; ?>" allowtransparency="yes" frameborder="0" scrolling="no"></iframe>
		</div>

<?php
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}
