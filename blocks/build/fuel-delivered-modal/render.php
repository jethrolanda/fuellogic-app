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
$showModal = get_user_meta($user_id, '_order_fuel_delivered_modal', true);
// if (empty($showModal) || $showModal !== 'open') {
// 	return;
// }
$time = date('g:i a');
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div class="modal" style="display: <?php echo empty($showModal) || $showModal !== 'open' ? "none" : "grid"; ?>">
		<div class="modal-content">
			<i class="fa-solid fa-xmark" data-wp-on--click="actions.closeDeliveredModal"></i>
			<i class="fa-regular fa-circle-check green"></i>

			<h1>Fuel Delivered</h1>
			<p class="green text-medium" style="width: 70%;">Today @ <?php echo $time; ?></p>
			<div class="gap-10"></div>
			<button class="submit-button green small" data-wp-on--click="actions.closeThankyouModal"><i class="fa-solid fa-calendar-days"></i> CREATE SCHEDULE</button>
			<button class="submit-button small" data-wp-on--click="actions.closeThankyouModal"><i class="fa-solid fa-repeat"></i> RE-ORDER</button>
			<button class="submit-button small" data-wp-on--click="actions.closeThankyouModal">HOW DID WE DO</button>
			<p class="done-btn" data-wp-on--click="actions.closeDeliveredModal">DONE</p>
		</div>
	</div>
</div>