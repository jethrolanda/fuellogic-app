<?php

/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$context = array(
	'current' => 0,
	'data' => $attributes['data'],
	'next' => 'Next'
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	data-wp-watch="callbacks.bgImage"
	data-wp-init="callbacks.bgImage"
	data-wp-on-document--keydown="actions.onKeyDown"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div>
		<?php
		foreach ($attributes['data'] as $index => $item) {  ?>
			<div class="slider slide-<?php echo $index; ?> <?php echo $index === 0 ? 'active' : '' ?>">
				<i class="icon <?php echo $item['fa_class']; ?>"></i>
				<h1><?php echo $item['heading']; ?></h1>
				<p><?php echo $item['excerpt']; ?></p>
			</div>

		<?php } ?>
		<!-- <template data-wp-each="context.data">
			<div data-wp-bind--hidden="!context.item.selected">
				<div id="icon"></div>
				<h1 data-wp-text="context.item.title"></h1>
				<p data-wp-text="context.item.content"></p>
			</div>
		</template> -->
	</div>
	<div>
		<ul class="indicators">
			<?php
			foreach ($attributes['data'] as $index => $item) {  ?>
				<li <?php echo $index === 0 ? 'class="active"' : ""; ?> data-wp-on--click="actions.onChange" <?php echo wp_interactivity_data_wp_context(array('id' => $index)); ?>></li>
			<?php } ?>
		</ul>
		<!-- <ul class="indicators">
			<template data-wp-each="context.data">
				<li data-wp-class--active="context.item.selected" data-wp-on--click="actions.onChange" data-wp-context="context.item"></li>
			</template>
		</ul> -->
	</div>
	<button data-wp-on--click="actions.next"><span data-wp-text="context.next"></span> <i class="fa-solid fa-arrow-right"></i></button>
</div>