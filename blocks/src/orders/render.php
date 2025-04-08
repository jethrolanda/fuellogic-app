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
$orders = $fla_theme->orders->get_orders();
wp_interactivity_state(
	'fuellogic-app',
	array('orders' => $orders),
);
$context = array('orders_page' => site_url('order-status'));

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
	data-wp-run="callbacks.adjustSiteHeight"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div class="controls">
		<i class="fa-solid fa-plus"></i>
		<p>New Order</p>
		<i class="fa-solid fa-arrows-up-down"></i>
		<i class="fa-solid fa-filter"></i>
	</div>
	<ul id="orders-list">
		<!-- <li id="empty-site" data-wp-run="callbacks.hideIfNotEmpty">
			<i class="fa-solid fa-truck-fast"></i>
			<p>No orders yet. Let’s get moving!</p>
			<a href="http://localhost:8004/add-new-site/"><i class="fa-solid fa-plus"></i> MAKE YOUR FIRST ORDER</a>
		</li> -->

		<?php
		foreach ($orders as $order) {
		?>
			<li class="item" <?php echo wp_interactivity_data_wp_context(array('order_id' => $order['id'])); ?> data-wp-on--click="actions.openOrderStatus">
				<i class="fa-regular fa-circle"></i>
				<div>
					<h3><?php echo $order['data']->site_name; ?></h3>
					<span class="details">
						<span>Delivery <?php echo $order['data']->delivery_date; ?></span>
						<span><?php echo $order['name']; ?></span>
					</span>
					<div class="status <?php echo !empty($order['status']) ? $order['status'] : 'pending'; ?>">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</div>
					<p class=" status-text"><?php echo $status_text[!empty($order['status']) ? $order['status'] : 'pending'] ?></p>
				</div>
				<i class="fa-solid fa-angle-right"></i>
			</li>
		<?php
		}
		?>

		<!-- <li>
			<i class="fa-solid fa-arrow-rotate-right"></i>
			<div>
				<h3>ABC Supply - Houston</h3>
				<p>Delivery Nov 10 # FL-1424822</p>
				<div class="status processing">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<p class="status-text">PROCESSING</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-truck-fast"></i>
			<div>
				<h3>ABC Supply - Cheyenne</h3>
				<p>Delivery Today Nov 9 # FL-1424821</p>
				<div class="status out-for-delivery">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<p class="status-text">OUT FOR DELIVERY</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Dallas</h3>
				<p>Delivered Today Nov 13 # FL-1424820</p>
				<div class="status delivered">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<p class="status-text">DELIVERED</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li class="selected">
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Emerald Isle</h3>
				<p>Delivered Nov 8 # FL-1424823</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Houston</h3>
				<p>Delivered Nov 6 # FL-1424823</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Freeport</h3>
				<p>Delivered Nov 4 # FL-1424823</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li> -->
	</ul>

</div>