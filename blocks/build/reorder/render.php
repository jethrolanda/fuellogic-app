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


wp_enqueue_script('fla-custom-select-js');

global $fla_theme;
$sites = $fla_theme->sites->get_sites();
wp_interactivity_state(
	'fuellogic-app',
	array(),
);

$context = array(
	'sites' => $sites,
	'selectedSiteId' => 0,
	'siteDetails' => ''
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<button class="green reorder-button" data-wp-on--click="actions.showModal"><i class="fa-solid fa-repeat"></i> RE-ORDER</button>
	<div class="modal" style="display: none;">
		<div class="modal-content">
			<i class="fa-solid fa-xmark" data-wp-on--click="actions.closeReorderModal"></i>
			<i class="fa-solid fa-repeat gray"></i>

			<h1>Re-Order Fuel</h1>
			<p class="green text-small color-gray">BASED ON YOUR SITE SETTINGS</p>
			<div class="gap-10"></div>
			<p class="green text-medium">Confirm Your Site & Order Details</p>
			<p>Or leave it to us instead and set a delivery schedule and never worry about it again.</p>
			<div class="gap-10"></div>
			<p>Re-Order For This Site:</p>

			<select data-wp-on--change="actions.selectSite">
				<button>
					<selectedcontent></selectedcontent>
				</button>

				<option value="">Please select a site</option>
				<?php foreach ($sites as $site) { ?>
					<option value="<?php echo $site['id']; ?>"><?php echo $site['name']; ?></option>
				<?php } ?>
			</select>
			<!-- <div class="custom-select">
				<select name="sites" data-wp-on--change="actions.selectSite">

				</select>
			</div> -->
			<label class="checkbox text-small" for="official_site_contact">
				<span class="label">
					<input data-wp-on--click="callbacks.toggleSiteContact" type="checkbox" id="official_site_contact" name="official_site_contact"><span class="checkmark"></span>I reviewed the new order details below.
				</span>
			</label>
			<button class="submit-button green" data-wp-on--click="">SUBMIT ORDER</button>

			<div class="order-details">
				<h2>New Order Details</h2>
				<p class="text-small">BASED ON YOUR SITE SETTINGS</p>
				<div class="site-info">
					<hr>

					<div class="section">
						<h2><i class="fa-solid fa-location-dot color-gray"></i> Site Details</h2>
						<p data-wp-text="context.siteDetails.name"></p>
						<label>Site Delivery Address</label>
						<p data-wp-text="context.siteDetails.address"><?php echo $data->site_delivery_address; ?></p>

						<label>Site Contact</label>
						<p><span data-wp-text="context.siteDetails.data.site_contact_first_name"></span> <span data-wp-text="context.siteDetails.data.site_contact_last_name"></span></p>
						<p data-wp-text="context.siteDetails.data.site_contact_phone"></p>
						<p data-wp-text="context.siteDetails.data.site_contact_email"></p>
					</div>
					<hr>
					<div class="section">
						<h2><i class="fa-solid fa-gas-pump color-gray"></i> Fuel Type & Quantity</h2>
						<table>
							<?php
							// if (!empty($gas_type)) {
							// 	foreach ($gas_type as $type) {
							// 		echo "<tr>";
							// 		echo "<td>" . $gas_type_list[$type] . "</td>";
							// 		echo "<td>" . $data->{$type . '_qty'} . "</td>";
							// 		echo "</tr>";
							// 	}
							// }
							?>
						</table>
					</div>
					<hr>
					<div class="section">
						<h2><i class="fa-solid fa-truck-front color-gray"></i> Site Equipment</h2>
						<table>
							<?php
							// if (!empty($machines)) {
							// 	foreach ($machines as $machine) {
							// 		echo "<tr>";
							// 		echo "<td>" . $machines_list[$machine] . "</td>";
							// 		echo "<td>" . $data->{$machine . '_qty'} . "</td>";
							// 		echo "</tr>";
							// 	}
							// }
							?>
						</table>
					</div>
					<hr>
					<div class="section">
						<h2><i class="fa-solid fa-file color-gray"></i> Site Delivery Notes</h2>
						<p data-wp-text="context.siteDetails.data.notes"></p>
						<?php
						// foreach ($images as $image) {
						// 	echo '<img src="' . $image . '" width="150"/>';
						// }
						?>
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
		</div>
	</div>
</div>