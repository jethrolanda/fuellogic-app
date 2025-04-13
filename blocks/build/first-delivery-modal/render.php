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

$user_id = get_current_user_id();
$showModal = get_user_meta($user_id, '_order_first_delivery_modal', true);

// if (empty($showModal) || $showModal !== 'open') {
// 	return;
// }

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div class="modal" style="display: <?php echo empty($showModal) || $showModal !== 'open' ? "none" : "grid"; ?>">
		<div class="modal-content">
			<i class="fa-solid fa-xmark" data-wp-on--click="actions.closeFirstDeliveryModal"></i>
			<i class="fa-solid fa-flag-checkered green"></i>

			<h1>First Delivery Complete!</h1>
			<p class="green text-medium">Way to go! Your first fueling is done!</p>
			<div class="gap-10"></div>
			<button class="submit-button green">HOW DID WE DO?</button>
			<div class="gap-10"></div>
			<button class="submit-button small"><i class="fa-solid fa-calendar-days"></i> CREATE SCHEDULE</button>
			<button class="submit-button small"><i class="fa-solid fa-repeat"></i> RE-ORDER</button>
			<p>DONE</p>
		</div>
	</div>
</div>