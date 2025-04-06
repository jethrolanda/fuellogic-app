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

$context = array(
	'order_id' => isset($_GET['order_id']) ? $_GET['order_id'] : 0,
);

$showModal = get_post_meta($context['order_id'], '_order_thank_you_modal', true);

if ($showModal == 'closed') {
	return;
}

$data = get_post_meta($_GET['order_id'], '_order_data', true);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div class="modal">
		<div class="modal-content">
			<i class="fa-solid fa-xmark" data-wp-on--click="actions.closeThankyouModal"></i>
			<i class="fa-regular fa-circle-check green"></i>

			<h1>Thank you <?php echo $data->site_contact_first_name; ?>!</h1>
			<p class="green text-medium" style="width: 70%;">Your Order Is Confirmed And Your Site Is Set Up</p>
			<div class="gap-10"></div>
			<p>If you have created a delivery schedule, then you are all set! Or to make a new order next time, just click the “Re-Order” button to make another order for your site. </p>
			<div class="gap-10"></div>
			<button class="submit-button green" data-wp-on--click="actions.closeThankyouModal">VIEW ORDER</button>
			<p class="color-orange">Create Your Delivery Schedule</p>
		</div>
	</div>
</div>