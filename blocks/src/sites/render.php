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
			<i class="fa-solid fa-plus"></i>
			<p>New Site</p>
			<i class="fa-solid fa-arrows-up-down"></i>
			<i class="fa-solid fa-trash"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Houston Branch</h3>
				<p>49 ABC Parkway Beloit, WI 53511 ...</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Dallas Branch</h3>
				<p>4833 Singleton Boulevard, Eagle Ford, Dallas ...</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Portland Branch</h3>
				<p>1810 Southeast 10th Avenue, Portland, OR ...</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Chico Branch</h3>
				<p>1205 West 7th Street, Chico, CA 95928</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li class="selected">
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Freeport Branch</h3>
				<p>247 East Park Street, Freeport, IL 61032</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Emerald Isle Branch</h3>
				<p>300 West, Murray, UT 84107</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Caledonia Branch</h3>
				<p>7195 Greenlee Road, Caledonia, IL 61011</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
		<li>
			<i class="fa-solid fa-location-dot"></i>
			<div>
				<h3>Benwood Branch</h3>
				<p>49 ABC Parkway Beloit, WI 53511...</p>
			</div>
			<i class="fa-solid fa-angle-right"></i>
		</li>
	</ul>

</div>