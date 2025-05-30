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

// Global State
wp_interactivity_state('fuellogic-app', array(
	'attributes' => $attributes,
));

$context = array();

$loadingScreenPattern = '';
if (isset($attributes['loadingScreenPattern']) && $attributes['loadingScreenPattern'] > 0) {
	$loadingScreenPattern = $attributes['loadingScreenPattern'];
}
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	data-wp-init="callbacks.hideLoadingScreen"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<?php echo do_blocks(get_post_field('post_content', $loadingScreenPattern)); ?>
</div>