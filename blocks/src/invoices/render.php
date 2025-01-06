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
			<i class="fa-solid fa-credit-card"></i>
			<p>Manage Cards</p>
			<i class="fa-solid fa-arrows-up-down"></i>
			<i class="fa-solid fa-filter"></i>
		</li>
		<li>
			<i class="fa-regular fa-circle"></i>
			<div>
				<h3>ABC Supply - Freeport</h3>
				<p>11.25.2024 # FL-1424823</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-regular fa-circle"></i>
			<div>
				<h3>ABC Supply - Houston</h3>
				<p>11.18.2024 # FL-1424822</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-regular fa-circle red"></i>
			<div>
				<h3>ABC Supply - Cheyenne</h3>
				<p>11.12.2024 # FL-1424821</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-regular fa-circle red"></i>
			<div>
				<h3>ABC Supply - Dallas</h3>
				<p>11.07.2024 # FL-1424820</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li class="selected">
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Emerald Isle</h3>
				<p>11.01.2024 # FL-1424819</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Benwood</h3>
				<p>10.25.2024 # FL-1424818</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Chico</h3>
				<p>10.21.2024 # FL-1424817</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Houston</h3>
				<p>49 ABC Parkway Beloit, WI 53511...10.18.2024 # FL-1424816</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-circle-check"></i>
			<div>
				<h3>ABC Supply - Freeport</h3>
				<p>10.11.2024 # FL-1424817</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
	</ul>

</div>