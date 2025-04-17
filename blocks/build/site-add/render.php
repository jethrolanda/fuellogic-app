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

wp_enqueue_script('fla-react-calendar-js');
wp_enqueue_script('fla-file-uploader-js');
wp_enqueue_script('fla-search-location-js');

$site_id = !empty($_GET['site_id']) ? $_GET['site_id'] : 0;
$site_data = get_post_meta($site_id, '_site_data', true);
$images = get_post_meta($site_id, '_site_images', true);
$gas_type = get_post_meta($site_id, '_site_gas_type', true);
$machines = get_post_meta($site_id, '_site_machines', true);
// error_log(print_r($site_data, true));
// error_log(print_r($images, true));
// error_log(print_r($gas_type, true));
// error_log(print_r($machines, true));

global $fla_theme;
wp_interactivity_state(
	'fuellogic-app',
	array(),
);

$context = array(
	'currentStep' => 1,
	'formData'	=> '',
	'ref' => '',
	'submitBtnStatus' => array(),
	'current_user' => array(
		'first_name' => get_user_meta(get_current_user_id(), 'first_name', true),
		'last_name' => get_user_meta(get_current_user_id(), 'last_name', true),
		'phone' => get_user_meta(get_current_user_id(), 'mobile_number', true),
		'email' => wp_get_current_user()->user_email,
	),
	'thank_you_page' => site_url('order-status'),
	'inventory_tracker' => FLA_BLOCKS_ROOT_URL . 'assets/inventory_tracker.png',
	'site_data' => $site_data,
	'images' => $images,
	'gas_type' => $gas_type,
	'machines' => $machines,
	'site_id' => $site_id
);

?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>
	data-wp-run="callbacks.adjustFormContentHeight"
	data-wp-init="callbacks.init">

	<div class="heading">
		<div>
			<i class="fa-solid fa-location-dot"></i>
		</div>
		<div>
			<h1 data-wp-text="state.siteName">My Site</h1>
			<small><i class="fa-solid fa-gear"></i> &nbsp;SITE SETTINGS</small>
		</div>
	</div>
	<div class="steps-wrapper" id="steps-container">
		<ul id="steps-nav">
			<li class="active" data-wp-on--click="callbacks.navigate" data-step="1"><i class="fa-solid fa-location-dot"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="2"><i class="fa-solid fa-gas-pump"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="3"><i class="fa-solid fa-truck-front"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="4"><i class="fa-solid fa-calendar-days"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="5"><i class="fa-solid fa-file"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="6"><i class="fa-solid fa-credit-card"></i></li>
		</ul>

		<form id="site-form" name="site-form" data-wp-on--change="callbacks.onFormUpdate" data-wp-init="callbacks.setSiteDetails">
			<div id="form-wrapper" class="form-wrapper">
				<!-- SITE DETAILS -->
				<div class="step-content step-1" data-step="1">
					<div>
						<h3>Site Details</h3>
						<small>SITE NAME / ADDRESS / CONTACT</small>
					</div>
					<hr>
					<div>
						<label for="site_name">Site Name<span class="required">*</span></label>
						<input type="text" id="site_name" name="site_name">
						<small class="description">Example: ABC Supply - Dallas Branch</small>
					</div>
					<hr>
					<div>
						<label for="site_delivery_address">Site Delivery Address<span class="required">*</span></label>
						<!-- <span class="search-address">
							<input type="text" id="site_delivery_address" name="site_delivery_address" placeholder="Search Address">
							<i class="fa-solid fa-search"></i>
						</span> -->
						<div id="search-location" class="search-address"></div>
					</div>
					<hr>
					<div>
						<label>Site Contact</label>
						<label class="checkbox small" for="official_site_contact">
							<span class="label">
								<input data-wp-on--click="callbacks.toggleSiteContact" type="checkbox" id="official_site_contact" name="official_site_contact"><span class="checkmark"></span>I am the official site contact
							</span>
						</label>

						<label class="small gray" for="site_contact_first_name">Site Contact First Name<span class="required">*</span></label>
						<input type="text" id="site_contact_first_name" name="site_contact_first_name">
						<label class="small gray" for="site_contact_last_name">Site Contact Last Name<span class="required">*</span></label>
						<input type="text" id="site_contact_last_name" name="site_contact_last_name">
						<label class="small gray" for="site_contact_phone">Site Contact Phone<span class="required">*</span></label>
						<input type="tel" id="site_contact_phone" name="site_contact_phone">
						<label class="small gray" for="site_contact_email">Site Contact Email<span class="required">*</span></label>
						<input type="email" id="site_contact_email" name="site_contact_email">
					</div>

				</div>
				<!-- END SITE DETAILS -->
				<!-- FUEL TYPE -->
				<div class="step-content step-2" data-step="2" hidden="true">
					<div>
						<h3>Site Fuel Type</h3>
						<small>SITE FUEL TYPE & QUANTITY</small>
					</div>
					<div>
						<label>What kind of fuel are you needing?<span class="required">*</span></label>
						<div>
							<label for="diesel" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="diesel" name="gas_type" value="diesel"><span class="checkmark"></span> On-Road Clear Diesel (trucks)
								</span>
								<input type="number" class="input-number" name="diesel_qty" readonly>
							</label>
							<label for="gas" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="gas" name="gas_type" value="gas"><span class="checkmark"></span> GAS - Unleaded Gasoline
								</span>
								<input type="number" class="input-number" name="gas_qty" readonly>
							</label>
							<label for="dyed_diesel" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="dyed_diesel" name="gas_type" value="dyed_diesel"><span class="checkmark"></span> Off-Road - Dyed Diesel (Generators etc)
								</span>
								<input type="number" class="input-number space-between" name="dyed_diesel_qty" readonly>
							</label>
							<label for="def" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="def" name="gas_type" value="def"><span class="checkmark"></span> DEF - Diesel Exhaust Fluid
								</span>
								<input type="number" class="input-number" name="def_qty" readonly>
							</label>
						</div>

					</div>
				</div>
				<!-- END FUEL TYPE -->
				<!-- EQUIPMENT TYPE -->
				<div class="step-content step-3" data-step="3" hidden="true">
					<div>
						<h3>Site Equipment</h3>
						<small>EQUIPMENT TYPE & QUANTITY</small>
					</div>
					<div>
						<label>What kind of equipment are we fueling?<span class="required">*</span></label>
						<div>
							<label for="vehicles" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="vehicles" name="machines" value="vehicles"><span class="checkmark"></span> Vehicles (Day Cabs, Box Trucks, Small Trucks)
								</span>
								<input type="number" class="input-number" name="vehicles_qty" readonly>
							</label>
							<label for="bulk_tank" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="bulk_tank" name="machines" value="bulk_tank"><span class="checkmark"></span> Bulk Tank (Jobsite Tanks, Big Tanks, etc.)
								</span>
								<input type="number" class="input-number" name="bulk_tank_qty" readonly>
							</label>
							<label for="construction_equipment" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="construction_equipment" name="machines" value="construction_equipment"><span class="checkmark"></span> Construction Equipment (Yellow Iron, Generators)
								</span>
								<input type="number" class="input-number" name="construction_equipment_qty" readonly>
							</label>
							<label for="generators" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="generators" name="machines" value="generators"><span class="checkmark"></span> Building Generators
								</span>
								<input type="number" class="input-number" name="generators_qty" readonly>
							</label>
							<label for="reefer" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="reefer" name="machines" value="reefer"><span class="checkmark"></span> Reefer (Refrigerated Trailers)
								</span>
								<input type="number" class="input-number" name="reefer_qty" readonly>
							</label>
							<label for="other" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="other" name="machines" value="other"><span class="checkmark"></span> Other
								</span>
								<input type="number" class="input-number" name="other_qty" readonly>
							</label>
						</div>
						<?php if (!empty($site_id)) { ?>
							<hr>
							<div>
								<img src="<?php echo $context['inventory_tracker']; ?>" alt="Inventory Tracker">
							</div>
						<?php } ?>
					</div>
				</div>
				<!-- END EQUIPMENT TYPE -->
				<!-- SCHEDULE -->
				<div class="step-content step-4" data-step="4" hidden="true">
					<div>
						<h3>Site Schedule</h3>
						<small>SCHEDULE</small>
					</div>
					<div>
						<label class="checkbox" for="one_time_delivery">
							<span class="label">
								<input data-wp-on--click="callbacks.toggleSiteContact" type="checkbox" id="one_time_delivery" name="one_time_delivery"><span class="checkmark"></span>This is a one-time delivery
							</span>
						</label>
						<!-- <label class="text-center">This is a one-time delivery</label>
						<div class="custom-radio-wrapper">
							<label class="custom-radio" for="yes">Yes
								<input type="radio" id="yes" name="one_time_delivery" value="yes">
								<span class="checkmark"></span>
							</label>
							<label class="custom-radio" for="no">No
								<input type="radio" id="no" name="one_time_delivery" value="no">
								<span class="checkmark"></span>
							</label>
						</div> -->
					</div>
					<!-- <div class="delivery-schedule-wrapper"> -->
					<div class="option1">
						<label for="delivery_start_date">Delivery start date<span class="required">*</span></label>
						<span class="input-text" data-wp-text="state.deliveryDate">&nbsp;</span>
						<input type="hidden" id="delivery_start_date" name="delivery_start_date">
					</div>
					<div class="option2">
						<label for="delivery_date">Delivery date<span class="required">*</span></label>
						<span class="input-text" data-wp-text="state.deliveryDate">&nbsp;</span>
						<input type="hidden" id="delivery_date" name="delivery_date">
					</div>
					<div class="react-calendar" class="option1 option2"></div>

					<div class="option1">
						<label>What is your preferred delivery days?<span class="required">*</span></label>
						<div class="delivery-days-wrapper">
							<label class="checkbox small" for="mon">
								<span class="label">
									<input type="checkbox" id="mon" name="day" value="mon"><span class="checkmark"></span>Mon
								</span>
							</label>
							<label class="checkbox small" for="tues">
								<span class="label">
									<input type="checkbox" id="tues" name="day" value="tues"><span class="checkmark"></span>Tues
								</span>
							</label>
							<label class="checkbox small" for="wed">
								<span class="label">
									<input type="checkbox" id="wed" name="day" value="wed"><span class="checkmark"></span>Wed
								</span>
							</label>
							<label class="checkbox small" for="thu">
								<span class="label">
									<input type="checkbox" id="thu" name="day" value="thu"><span class="checkmark"></span>Thu
								</span>
							</label>
							<label class="checkbox small" for="fri">
								<span class="label">
									<input type="checkbox" id="fri" name="day" value="fri"><span class="checkmark"></span>Fri
								</span>
							</label>
							<label class="checkbox small" for="sat">
								<span class="label">
									<input type="checkbox" id="sat" name="day" value="sat"><span class="checkmark"></span>Sat
								</span>
							</label>
							<label class="checkbox small" for="sun">
								<span class="label">
									<input type="checkbox" id="sun" name="day" value="sun"><span class="checkmark"></span>Sun
								</span>
							</label>
						</div>
					</div>
					<div class="option1 option2">
						<label for="delivery_window">Delivery window(4-hour minimum)</label>
						<input type="text" id="delivery_window" name="delivery_window" placeholder="10am-2pm">
						<small class="description">When are we able to access the equipment?</small>
					</div>
					<!-- </div> -->

				</div>
				<!-- END SCHEDULE-->
				<!-- SITE NOTES -->
				<div class="step-content step-5" data-step="5" hidden="true">
					<div>
						<h3>Site Notes</h3>
						<small>NOTES</small>
					</div>
					<div>
						<label>What do we need to know about this site? Is the yard locked? Is there a combination? Where is the equipment parked, etc…<span class="required">*</span></label>
					</div>
					<div>
						<textarea name="notes" id="" rows="4"></textarea>
					</div>
					<div id="file-uploader"></div>
					<div id="note-images">

					</div>
				</div>
				<!-- END SITE NOTES-->
				<!-- PAYMENT DETAILS -->
				<div class="step-content step-6" data-step="6" hidden="true">
					<div>
						<h3>Site Payment</h3>
						<small>PAYMENT</small>
					</div>
					<div>
						<label class="custom-radio" for="payment_on_file">Use payment on file<span class="required">*</span>
							<input type="radio" id="payment_on_file" name="payment_method" value="payment_on_file">
							<span class="checkmark"></span>
							<br /><small class="description">Select this method if you want to use the card on file</small>
						</label>
						<label class="custom-radio" for="pre_authorization">Send a pre-authorization form via email<span class="required">*</span>
							<input type="radio" id="pre_authorization" name="payment_method" value="pre_authorization">
							<span class="checkmark"></span>
							<br /><small class="description">Select this method to use a new credit card.</small>
						</label>
					</div>
					<div id="pre_authorization_email" style="display:none;">
						<label for="pre_authorization_email">Send Pre-authorization form to this email</label>
						<input type="email" id="pre_authorization_email" name="pre_authorization_email">
					</div>
				</div>
				<!-- END PAYMENT DETAILS -->
			</div>

			<?php if (empty($site_id)) { ?>
				<button class="submit-button" data-wp-class--next="state.next" data-wp-on--click="actions.submitButton">
					<span data-wp-style--display="state.isIncomplete">INCOMPLETE</span>
					<span data-wp-style--display="state.isNextStep" class="hidden">NEXT <i class="fa-solid fa-arrow-right"></i></span>
					<span data-wp-style--display="state.isSubmitOrder" class="hidden">SUBMIT ORDER <i class="fa-solid fa-arrow-right"></i></span>
				</button>
			<?php } ?>

		</form>
	</div>


</div>