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
global $fla_theme;
wp_interactivity_state(
	'fuellogic-app',
	array(),
);

$context = array();
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<a href="<?php echo isset($attributes['backPage']) && !empty($attributes['backPage']) ? get_permalink($attributes['backPage']) : site_url();  ?>"><i class="fa-solid fa-angle-left" style="background: #1C1C1C;
    padding: 10px 15px;
    border-radius: 10px; color: #fff;"></i></a>
</div>