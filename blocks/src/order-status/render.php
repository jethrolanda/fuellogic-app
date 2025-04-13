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
	'orders_page' => site_url('orders'),
	'truck_delivery_png' => FLA_BLOCKS_ROOT_URL . 'assets/delivery_truck.png',
	'map' => FLA_BLOCKS_ROOT_URL . 'assets/map.png',
	'order_id' => !empty($_GET['order_id']) ? $_GET['order_id'] : 0,
);

// Dont allow a use to access if he is not the owner of the order
if (!is_admin() && isset($_GET['order_id']) && get_post_meta($_GET['order_id'], '_order_user_id', true) != get_current_user_id()) {
	wp_redirect($context['orders_page']);
	exit;
}
$order = get_post($_GET['order_id']);
$data = get_post_meta($_GET['order_id'], '_order_data', true);
$images = get_post_meta($_GET['order_id'], '_order_images', true);
$gas_type = get_post_meta($_GET['order_id'], '_order_gas_type', true);
$machines = get_post_meta($_GET['order_id'], '_order_machines', true);
$order_status = get_post_meta($_GET['order_id'], '_order_status', true);
// error_log(print_r($data, true));
// error_log(print_r($images, true));

$status_text = array(
	'pending' => 'ORDERED',
	'processing' => 'PROCESSING',
	'out-for-delivery' => 'OUT FOR DELIVERY',
	'delivered' => 'DELIVERED',
);
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
				<h2>Thank You <?php echo $data->site_contact_first_name; ?></h2>
				<p class="text-small">YOUR ORDER IS CONFIRMED</p>
			</div>
		</div>
		<hr class="divider">
		<div class="site-wrapper">
			<i class="fa-regular fa-circle"></i>
			<div>
				<h2><?php echo $data->site_name; ?></h2>
				<p class="text-small">Delivery <?php echo $data->delivery_date; ?> <?php echo $order->post_title; ?></p>
			</div>
		</div>
		<div class="status-wrapper">
			<div class="status <?php echo !empty($order_status) ? $order_status : 'pending'; ?>">
				<span <?php echo wp_interactivity_data_wp_context(array('status' => 'pending')); ?> data-wp-on--click="actions.changeStatus"></span>
				<span <?php echo wp_interactivity_data_wp_context(array('status' => 'processing')); ?> data-wp-on--click="actions.changeStatus"></span>
				<span <?php echo wp_interactivity_data_wp_context(array('status' => 'out-for-delivery')); ?> data-wp-on--click="actions.changeStatus"></span>
				<span <?php echo wp_interactivity_data_wp_context(array('status' => 'delivered')); ?> data-wp-on--click="actions.changeStatus"></span>
			</div>
			<p class="status-text text-small"><?php echo $status_text[!empty($order_status) ? $order_status : 'pending'] ?></p>
		</div>
		<div id="map1" style="display: <?php echo $order_status == 'out-for-delivery' ? "block" : "none"; ?>">
			<img class="realtime_tracker" src="<?php echo $context['truck_delivery_png']; ?>" alt="Truck" />
			<div class="tracker">
				<i class="fa-solid fa-truck-fast"></i>
				<span>
					<h2>Your Fuel Is On Its Way!</h2>
					<small class="text-small">REAL-TIME TRACKER</small>
				</span>
			</div>
		</div>
		<div id="map2" style="display: <?php echo $order_status == 'out-for-delivery' ? "none" : "block"; ?>">
			<img class="map" src="<?php echo $context['map']; ?>" alt="Map" />
		</div>

		<div class="site-info">
			<div>
				<h2>Order Details</h2>
				<p class="text-small"><?php echo $order->post_title; ?></p>
			</div>
			<hr>

			<div class="section">
				<h2><i class="fa-solid fa-location-dot color-gray"></i> Site Details</h2>
				<p><?php echo $data->site_name; ?></p>
				<label>Site Delivery Address</label>
				<p><?php echo $data->site_delivery_address; ?></p>

				<label>Site Contact</label>
				<p><?php echo $data->site_contact_first_name . ' ' . $data->site_contact_last_name; ?></p>
				<p><?php echo $data->site_contact_phone; ?></p>
				<p><?php echo $data->site_contact_email; ?></p>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-gas-pump color-gray"></i> Fuel Type & Quantity</h2>
				<table>
					<?php
					if (!empty($gas_type)) {
						foreach ($gas_type as $type) {
							echo "<tr>";
							echo "<td>" . $gas_type_list[$type] . "</td>";
							echo "<td>" . $data->{$type . '_qty'} . "</td>";
							echo "</tr>";
						}
					}
					?>
				</table>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-truck-front color-gray"></i> Site Equipment</h2>
				<table>
					<?php
					if (!empty($machines)) {
						foreach ($machines as $machine) {
							echo "<tr>";
							echo "<td>" . $machines_list[$machine] . "</td>";
							echo "<td>" . $data->{$machine . '_qty'} . "</td>";
							echo "</tr>";
						}
					}
					?>
				</table>
			</div>
			<hr>
			<div class="section">
				<h2><i class="fa-solid fa-file color-gray"></i> Site Delivery Notes</h2>
				<p><?php echo $data->notes; ?></p>
				<?php
				foreach ($images as $image) {
					echo '<img src="' . $image . '" width="150"/>';
				}
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
	<button class="green submit-button">CREATE SCHEDULE <i class="fa-regular fa-calendar-days"></i></button>
</div>