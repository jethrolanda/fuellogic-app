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

$context = array('showMenu' => false);

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
	<i class="fa-solid fa-bars" data-wp-on--click="callbacks.showHideMenu"></i>
	<?php //echo do_blocks(get_post_field('post_content', $loadingScreenPattern)); 
	?>
	<div class="menu-list" data-wp-class--show="context.showMenu">
		<div class="wrapper">
			<i class="fa-solid fa-close" data-wp-on--click="callbacks.showHideMenu"></i>
			<div class="user-profile">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/user_profile.png" alt="Tom Richards" />
				<div>
					<h4>Tom Richards</h4>
					<p>t.richards@abcsupply.com</p>
				</div>
			</div>

			<ul>
				<li><i class="fa-solid fa-plus"></i> <a href="<?php echo site_url('new-order'); ?>">New Order</a></li>
				<li class="orders"><i class="fa-solid fa-truck-fast"></i> <a href="<?php echo site_url('orders'); ?>">Orders</a></li>
				<li><i class="fa-solid fa-location-dot"></i> <a href="<?php echo site_url('sites'); ?>">Site Locations</a></li>
				<li><i class="fa-solid fa-circle-check"></i> <a href="<?php echo site_url('invoices'); ?>">Invoices</a></li>
				<li><i class="fa-solid fa-credit-card"></i> <a href="<?php echo site_url('payment-details'); ?>">Payment Details</a></li>
				<li><i class="fa-solid fa-comment"></i> <a href="<?php echo site_url('chat'); ?>">Chat</a></li>
				<li><i class="fa-solid fa-phone"></i> <a href="<?php echo site_url('contact-us'); ?>">Contact Us</a></li>
				<li><i class="fa-solid fa-arrow-left"></i> <a href="<?php echo site_url('logout'); ?>">Log Out</a></li>
			</ul>
		</div>
	</div>
</div>