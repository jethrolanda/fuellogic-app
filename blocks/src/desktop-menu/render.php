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
	<?php //echo do_blocks(get_post_field('post_content', $loadingScreenPattern)); 
	?>
	<div class="menu-list minimized" data-wp-class--minimized="!context.showMenu">
		<div class="wrapper">
			<div class="logo">
				<a href="<?php echo site_url() ?>">
					<img class="large" src="<?php echo get_template_directory_uri(); ?>/assets/Company Logo.png" alt="Company Logo">
					<img class="small" src="<?php echo get_template_directory_uri(); ?>/assets/logo-small.png" alt="Logo Small">
				</a>
			</div>
			<ul>
				<li class="<?php echo get_post_field('post_name') === 'new-order' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('new-order'); ?>"><i class="fa-solid fa-plus"></i><span>New Order</span></a>
				</li>
				<li class="<?php echo get_post_field('post_name') === 'orders' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('orders'); ?>"><i class="fa-solid fa-truck-fast"></i><span>Orders</span></a>
				</li>
				<li class="<?php echo get_post_field('post_name') === 'sites-locations' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('sites-locations'); ?>"><i class="fa-solid fa-location-dot"></i><span>Site Locations</span></a>
				</li>
				<li class="<?php echo get_post_field('post_name') === 'invoices' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('invoices'); ?>"><i class="fa-solid fa-circle-check"></i><span>Invoices</span></a>
				</li>
				<li class="<?php echo get_post_field('post_name') === 'payment-details' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('payment-details'); ?>"><i class="fa-solid fa-credit-card"></i><span>Payment Details</span></a>
				</li>
				<li class="<?php echo get_post_field('post_name') === 'chat' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('chat'); ?>"><i class="fa-solid fa-comment"></i><span>Chat</span></a>
				</li>
				<li class="<?php echo get_post_field('post_name') === 'contact-us' ? 'selected' : '' ?>">
					<a href="<?php echo site_url('contact-us'); ?>"><i class="fa-solid fa-phone"></i><span>Contact Us</span></a>
				</li>
			</ul>
			<div class="user-profile">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/user_profile.png" alt="Tom Richards" />
				<div>
					<h4>Tom Richards</h4>
					<p>t.richards@abcsupply.com</p>
				</div>
			</div>
			<div class="logout">
				<span><i class="fa-solid fa-arrow-left"></i> <a href="<?php echo site_url('logout'); ?>">Log Out</a></span><i class="fa-solid fa-angle-left" data-wp-on--click="callbacks.showHideMenu"></i>
				<i class="fa-solid fa-angle-right" data-wp-on--click="callbacks.showHideMenu"></i>
			</div>

		</div>
	</div>
</div>