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
	)
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
			<h1 data-wp-text="state.siteName">My Site</h1>
			<small><i class="fa-solid fa-gear"></i> &nbsp;SITE SETTINGS</small>
		</div>
	</div>
	<div class="steps-wrapper">
		<ul id="steps-nav">
			<li class="active" data-wp-on--click="callbacks.navigate" data-step="1"><i class="fa-solid fa-location-dot"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="2"><i class="fa-solid fa-gas-pump"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="3"><i class="fa-solid fa-truck-front"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="4"><i class="fa-solid fa-calendar-days"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="5"><i class="fa-solid fa-file"></i></li>
			<li data-wp-on--click="callbacks.navigate" data-step="6"><i class="fa-solid fa-credit-card"></i></li>
		</ul>

		<form id="site-form" name="site-form" data-wp-on--change="callbacks.onFormUpdate">
			<div class="form-wrapper">
				<!-- SITE DETAILS -->
				<div class="step-content step-1" data-step="1">
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
						<span class="search-address">
							<input type="text" id="site_delivery_address" name="site_delivery_address" placeholder="Search Address">
							<i class="fa-solid fa-search"></i>
						</span>

					</div>
					<hr>
					<div>
						<label>Site Contact</label>
						<label class="checkbox small" for="official_site_contact">
							<span class="label">
								<input data-wp-on--click="callbacks.toggleSiteContact" type="checkbox" id="official_site_contact" name="official_site_contact"><span class="checkmark"></span>I am the official site contact
							</span>
						</label>

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
				<!-- END SITE DETAILS -->
				<!-- FUEL TYPE -->
				<div class="step-content step-2" data-step="2" hidden="true">
					<div>
						<h3>Site Fuel Type</h3>
						<small>SITE FUEL TYPE & QUANTITY</small>
					</div>
					<div>
						<label>What kind of fuel are you needing?</label>
						<div>
							<label for="diesel" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="diesel" name="diesel"><span class="checkmark"></span> On-Road Clear Diesel (trucks)
								</span>
								<input type="number" class="input-number" name="diesel_qty" disabled>
							</label>
							<label for="gas" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="gas" name="gas"><span class="checkmark"></span> GAS - Unleaded Gasoline
								</span>
								<input type="number" class="input-number" name="gas_qty" disabled>
							</label>
							<label for="dyed_diesel" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="dyed_diesel" name="dyed_diesel"><span class="checkmark"></span> Off-Road - Dyed Diesel (Generators etc)
								</span>
								<input type="number" class="input-number space-between" name="dyed_diesel_qty" disabled>
							</label>
							<label for="def" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="def" name="def"><span class="checkmark"></span> DEF - Diesel Exhaust Fluid
								</span>
								<input type="number" class="input-number" name="def_qty" disabled>
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
						<label>What kind of equipment are we fueling?</label>
						<div>
							<label for="vehicles" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="vehicles" name="vehicles"><span class="checkmark"></span> Vehicles (Day Cabs, Box Trucks, Small Trucks)
								</span>
								<input type="number" class="input-number" name="vehicles_qty" disabled>
							</label>
							<label for="bulk_tank" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="bulk_tank" name="bulk_tank"><span class="checkmark"></span> Bulk Tank (Jobsite Tanks, Big Tanks, etc.)
								</span>
								<input type="number" class="input-number" name="bulk_tank_qty" disabled>
							</label>
							<label for="construction_equipment" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="construction_equipment" name="construction_equipment"><span class="checkmark"></span> Construction Equipment (Yellow Iron, Generators)
								</span>
								<input type="number" class="input-number" name="construction_equipment_qty" disabled>
							</label>
							<label for="generators" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="generators" name="generators"><span class="checkmark"></span> Building Generators
								</span>
								<input type="number" class="input-number" name="generators_qty" disabled>
							</label>
							<label for="reefer" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="reefer" name="reefer"><span class="checkmark"></span> Reefer (Refrigerated Trailers)
								</span>
								<input type="number" class="input-number" name="reefer_qty" disabled>
							</label>
							<label for="other" class="checkbox small space-between">
								<span class="label">
									<input type="checkbox" id="other" name="other"><span class="checkmark"></span> Other
								</span>
								<input type="number" class="input-number" name="other_qty" disabled>
							</label>
						</div>

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
						<label class="text-center">Is this a one time delivery?</label>
						<div class="custom-radio-wrapper">
							<label class="custom-radio" for="yes">Yes
								<input type="radio" id="yes" name="one_time_delivery" value="yes">
								<span class="checkmark"></span>
							</label>
							<label class="custom-radio" for="no">No
								<input type="radio" id="no" name="one_time_delivery" value="no">
								<span class="checkmark"></span>
							</label>
						</div>
					</div>
					<div class="delivery-schedule-wrapper" style="display: none;">
						<div class="option2">
							<label>What is your preferred delivery days?</label>
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
							<label for="delivery_date">Delivery date</label>
							<span class="input-text" data-wp-text="state.deliveryDate">&nbsp;</span>
							<input type="hidden" id="delivery_date" name="delivery_date">
						</div>
						<div id="react-calendar" class="option1 option2"></div>
						<div class="option1 option2">
							<label for="delivery_window">Delivery window(4-hour minimum)</label>
							<input type="text" id="delivery_window" name="delivery_window" placeholder="10am-2pm">
							<small class="description">When are we able to access the equipment?</small>
						</div>
					</div>

				</div>
				<!-- END SCHEDULE-->
				<!-- SITE NOTES -->
				<div class="step-content step-5" data-step="5" hidden="true">
					<div>
						<h3>Site Notes</h3>
						<small>NOTES</small>
					</div>
					<div>
						<label>What do we need to know about this site? Is the yard locked? Is there a combination? Where is the equipment parked, etc…</label>
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
						<label class="custom-radio" for="payment_on_file">Use payment on file
							<input type="radio" id="payment_on_file" name="payment_method" value="payment_on_file">
							<span class="checkmark"></span>
							<br /><small class="description">Select this method if you want to use the card on file</small>
						</label>
						<label class="custom-radio" for="pre_authorization">Send a pre-authorization form via email
							<input type="radio" id="pre_authorization" name="payment_method" value="pre_authorization">
							<span class="checkmark"></span>
							<br /><small class="description">Select this method to use a new credit card.</small>
						</label>
					</div>
					<div>
						<label for="pre_authorization_email">Send Pre-authorization form to this email</label>
						<input type="email" id="pre_authorization_email" name="pre_authorization_email">
					</div>
				</div>
				<!-- END PAYMENT DETAILS -->
			</div>

			<button id="submit-button" data-wp-class--next="state.next" data-wp-on--click="actions.submitButton">
				<span data-wp-style--display="state.isIncomplete">INCOMPLETE</span>
				<span data-wp-style--display="state.isNextStep" class="hidden">NEXT <i class="fa-solid fa-arrow-right"></i></span>
				<span data-wp-style--display="state.isSubmitOrder" class="hidden">SUBMIT ORDER <i class="fa-solid fa-arrow-right"></i></span>
			</button>
		</form>
	</div>


</div>