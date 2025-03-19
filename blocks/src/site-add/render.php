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
	'currentStep' => 1,
);

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>
	data-wp-init="callbacks.init">

	<div class="heading">
		<div>
			<i class="fa-solid fa-location-dot"></i>
		</div>
		<div>
			<h1>My Site</h1>
			<small><i class="fa-solid fa-gear"></i> &nbsp;SITE SETTINGS</small>
		</div>
	</div>
	<div class="steps-wrapper">
		<ul>
			<li class="active" data-wp-on--click="callbacks.navigate" data-step="1"><i class="fa-solid fa-location-dot"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="2"><i class="fa-solid fa-gas-pump"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="3"><i class="fa-solid fa-truck-front"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="4"><i class="fa-solid fa-calendar-days"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="5"><i class="fa-solid fa-file"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="6"><i class="fa-solid fa-credit-card"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="7"><i class="fa-solid fa-list-check"></i></li>
		</ul>

		<form action="">
			<div class="form-wrapper">
				<div class="step-content site-details" data-step="1">
					<div>
						<h3>Site Details</h3>
						<small>SITE NAME / ADDRESS / CONTACT</small>
					</div>
					<hr>
					<div>
						<label for="site_name">Site Name</label>
						<input type="text" id="site_name" name="site_name">
						<small class="description">Example: ABC Supply - Dallas Branch</small>
					</div>
					<hr>
					<div>
						<label for="site_delivery_address">Site Delivery Address</label>
						<input type="text" id="site_delivery_address" name="site_delivery_address" placeholder="Search Address">
					</div>
					<hr>
					<div>
						<label>Site Contact</label>
						<label class="checkbox small" for="official_site_contact"><input type="checkbox" id="official_site_contact" name="official_site_contact"><span class="checkmark"></span>I am the official site contact</label>

						<label class="small gray" for="site_contact_first_name">Site Contact First Name</label>
						<input type="text" id="site_contact_first_name" name="site_contact_first_name">
						<label class="small gray" for="site_contact_last_name">Site Contact Last Name</label>
						<input type="text" id="site_contact_last_name" name="site_contact_last_name">
						<label class="small gray" for="site_contact_phone">Site Contact Phone</label>
						<input type="tel" id="site_contact_phone" name="site_contact_phone">
						<label class="small gray" for="site_contact_email">Site Contact Email</label>
						<input type="email" id="site_contact_email" name="site_contact_email">
					</div>

				</div>
				<div class="step-content site-details" data-step="2">
					<div>
						<h3>Site Fuel Type</h3>
						<small>SITE FUEL TYPE & QUANTITY</small>
					</div>
					<div>
						<label for="">What kind of fuel are you needing?</label>
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> On-Road Clear Diesel (trucks)
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> GAS - Unleaded Gasoline
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Off-Road - Dyed Diesel (Generators etc)
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> DEF - Diesel Exhaust Fluid
					</div>
				</div>
				<div class="step-content site-details" data-step="3">
					<div>
						<h3>Equipment</h3>
						<small>SITE FUEL TYPE & QUANTITY</small>
					</div>
					<div>
						<label for="">What kind of equipment are we fueling?</label>
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Vehicles (Day Cabs, Box Trucks, Small Trucks)
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Bulk Tank (Jobsite Tanks, Big Tanks, etc.)
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Construction Equipment (Yellow Iron, Generators)
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Building Generators
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Reefer (Refrigerated Trailers)
						<input type="checkbox" id="site_fuel_type" name="site_fuel_type"> Other
					</div>
				</div>
				<div class="step-content site-details" data-step="4">
					<div>
						<h3>Schedule</h3>
						<small>SITE FUEL TYPE & QUANTITY</small>
					</div>
				</div>
				<div class="step-content site-details" data-step="5">
					step 5
				</div>
				<div class="step-content site-details" data-step="6">
					step 6
				</div>
				<div class="step-content site-details" data-step="7">
					step 7
				</div>
			</div>

			<button>INCOMPLETE</button>
		</form>
	</div>


</div>