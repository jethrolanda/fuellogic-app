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

$context = array();
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>

	<div class="account-setup-checklist">
		<div><i class="fa-regular fa-circle-check"></i>MAKE FIRST ORDER <i class="fa-solid fa-angle-right"></i></div>
		<div><i class="fa-regular fa-circle"></i>PAYMENT DETAILS <i class="fa-solid fa-angle-right"></i></div>
		<div><i class="fa-regular fa-circle"></i>ADD NEW SITES <i class="fa-solid fa-angle-right"></i></div>
	</div>
</div>