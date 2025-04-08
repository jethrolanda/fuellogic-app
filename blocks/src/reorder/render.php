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

$gas_type_list = array(
	'diesel' => 'On-Road Clear Diesel (trucks)',
	'gas' => 'GAS – Unleaded Gasoline',
	'dyed_diesel' => 'Off-Road – Dyed Diesel (Generators etc)',
	'def' => 'DEF – Diesel Exhaust Fluid'
);
$machines_list = array(
	'vehicles' => 'Vehicles (Day Cabs, Box Trucks, Small Trucks)',
	'bulk_tank' => 'Bulk Tank (Jobsite Tanks, Big Tanks, etc.)',
	'construction_equipment' => 'Construction Equipment (Yellow Iron, Generators)',
	'generators' => 'Building Generators',
	'reefer' => 'Reefer (Refrigerated Trailers)',
	'other' => 'Other'
);

$context = array(
	'sites' => $sites,
	'selectedSiteId' => 0,
	'siteDetails' => array(
		'images'	=> array(),
		'machines'	=> array(),
		'gas_type'	=> array(),
	),
	'isReviewed' => false,
	'isButtonDisabled' => true,
	'gas_type_list' => $gas_type_list,
	'machines_list' => $machines_list,
	'thank_you_page' => site_url('order-status')
);
// error_log(print_r($context, true));
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
					<input data-wp-on--click="callbacks.toggleReviewed" type="checkbox" id="official_site_contact" name="official_site_contact"><span class="checkmark"></span>I reviewed the new order details below.
				</span>
			</label>
			<button
				disabled
				class="submit-button green disabled"
				data-wp-on--click="actions.submitNewOrder"
				data-wp-run="callbacks.disableButton">SUBMIT ORDER</button>

			<div class="order-details" data-wp-bind--hidden="!context.isReviewed">
				<h2>New Order Details</h2>
				<p class="text-small">BASED ON YOUR SITE SETTINGS</p>
				<div class="site-info">
					<hr>

					<div class="section">
						<h2><i class="fa-solid fa-location-dot color-gray"></i> Site Details</h2>
						<p data-wp-text="context.siteDetails.name"></p>
						<label>Site Delivery Address</label>
						<p data-wp-text="context.siteDetails.address"></p>

						<label>Site Contact</label>
						<p><span data-wp-text="context.siteDetails.data.site_contact_first_name"></span> <span data-wp-text="context.siteDetails.data.site_contact_last_name"></span></p>
						<p data-wp-text="context.siteDetails.data.site_contact_phone"></p>
						<p data-wp-text="context.siteDetails.data.site_contact_email"></p>
					</div>
					<hr>
					<div class="section">
						<h2><i class="fa-solid fa-gas-pump color-gray"></i> Fuel Type & Quantity</h2>
						<table>
							<template data-wp-each="context.siteDetails.gas_type">
								<tr>
									<td data-wp-text="state.gas_type_text"></td>
									<td data-wp-text="state.gas_type_qty"></td>
							</template>
						</table>
					</div>
					<hr>
					<div class="section">
						<h2><i class="fa-solid fa-truck-front color-gray"></i> Site Equipment</h2>
						<table>
							<template data-wp-each="context.siteDetails.machines">
								<tr>
									<td data-wp-text="state.machines_text"></td>
									<td data-wp-text="state.machines_qty"></td>
							</template>
						</table>
					</div>
					<hr>
					<div class="section">
						<h2><i class="fa-solid fa-file color-gray"></i> Site Delivery Notes</h2>
						<p data-wp-text="context.siteDetails.data.notes"></p>
						<template data-wp-each="context.siteDetails.images">
							<img data-wp-bind--src="context.item" width="150" />
						</template>
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