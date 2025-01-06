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

$context = array('isOpen' => false);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<ul>
		<li>
			<i class="fa-solid fa-phone"></i>
			<p>Contact Us</p>
			<i class="fa-solid fa-arrows-up-down"></i>
			<i class="fa-solid fa-filter"></i>
		</li>
		<li>
			<i class="fa-regular fa-circle"></i>
			<div>
				<h3>ABC Supply - Freeport</h3>
				<p>Delivery Nov 13 # FL-1424823</p>
				<div class="status ordered">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<p class="status-text">ORDERED</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
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
		</li>
	</ul>

</div>