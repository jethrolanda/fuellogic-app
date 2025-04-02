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

	<div class="wrapper">
		<div class="heading">
			<div>
				<i class="fa-regular fa-circle-check"></i>
			</div>
			<div>
				<h2>Thank You [Tom]</h2>
				<p class="small">YOUR ORDER IS CONFIRMED</p>
			</div>
		</div>
		<hr>
		<div class="site-wrapper">
			<i class="fa-regular fa-circle"></i>
			<div>
				<h2>ABC Supply - Freeport</h2>
				<p class="small">Delivery Nov 13 # FL-1424823</p>
			</div>
		</div>
		<div class="status-wrapper">
			<div class="status ordered">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
			<p class="status-text small">ORDER PENDING</p>
		</div>
		<div class="site-info">
			<div>
				<h2>Order Details</h2>
				<p class="small"># FL-1424823</p>
			</div>
			<hr>

			<div class="section">
				<h2><i class="fa-solid fa-location-dot color-gray"></i> Site Details</h2>
				<p>ABC Supply - Dallas Branch</p>
				<label>Site Delivery Address</label>
				<p>4833 Singleton Blvd</p>
				<p>Dallas, TX 75212</p>
				<label>Site Contact</label>
				<p>Tom Richards</p>
				<p>817-867-5309</p>
				<p>tom.richards@abcsupply.com</p>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-gas-pump color-gray"></i> Fuel Type & Quantity</h2>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-truck-front color-gray"></i> Site Equipment</h2>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-file color-gray"></i> Site Delivery Notes</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla gravida, eros ut luctus placerat, magna mi posuere tortor, non scelerisque risus libero et urna.</p>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-credit-card color-gray"></i> Payment Method</h2>
				<p>VISA ending with 5309 - $629.23</p>
				<p>Billing Address:</p>
				<p>123 Fake St</p>
				<p>Dallas, TX 76248</p>
			</div>
		</div>

	</div>
	<button id="submit-button" class="green">CREATE SCHEDULE</button>
</div>