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
$sites = $fla_theme->sites->get_sites();
wp_interactivity_state(
	'fuellogic-app',
	array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('site-nonce'),
		'sites' => $sites,
		'selectedSiteId' => '',
		'selectedSite' => '',
		'sorted' => false,
		'action' => ''
	),
);

$context = array('new_site' => site_url('add-new-site'),);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	data-wp-run="callbacks.adjustSiteHeight"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div class="controls">
		<i class="fa-solid fa-plus" data-wp-on--click="callbacks.addNewSiteRedirect" data-action="add-site"></i>
		<p>New Site</p>
		<i class="fa-solid fa-arrows-up-down" data-wp-on--click="callbacks.sortSites"></i>
		<i class="fa-solid fa-trash" data-wp-on--click="actions.deleteSite"></i>
	</div>

	<ul id="sites-list">

		<template data-wp-each--site="state.sites">
			<li class="item" data-wp-key="context.site.id" data-wp-on--click="callbacks.selectSite" data-wp-bind--id="context.site.id">
				<i class="fa-solid fa-location-dot"></i>
				<div>
					<h3 data-wp-text="context.site.name"></h3>
					<p data-wp-text="context.site.address"></p>
				</div>
				<i class="fa-solid fa-angle-right"></i>
			</li>
		</template>
		<li id="empty-site" data-wp-run="callbacks.hideIfNotEmpty">
			<i class="fa-solid fa-location-dot"></i>
			<p>A Site is a location where you will receive fuel deliveries. C'mon, let's get your first site set up!</p>
			<a href="<?php echo $context['new_site'] ?>"><i class="fa-solid fa-plus"></i> SET UP YOUR SITE</a>
		</li>
		<!-- <li>
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
		</li> -->
	</ul>

	<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<span class="close" data-wp-on--click="callbacks.closeModal">&times;</span>

			<form data-wp-on--submit="actions.submitForm">
				<h2 data-wp-text="state.modalHeading"></h2>
				<div>
					<label for="siteName">Site Name: </label>
					<input type="text" id="siteName" name="siteName" required data-wp-bind--value="state.siteName">
				</div>
				<div>
					<label for="siteAddress">Site Address: </label>
					<input type="text" id="siteAddress" name="siteAddress" required data-wp-bind--value="state.siteAddress">
				</div>
				<div>
					<label for="siteDeliverySchedule">Delivery Schedule: </label>
					<input type="text" id="siteDeliverySchedule" name="siteDeliverySchedule" required data-wp-bind--value="state.siteDeliverySchedule">
				</div>
				<div>
					<label for="siteDeliveryNotes">Delivery Notes: </label>
					<input type="text" id="siteDeliveryNotes" name="siteDeliveryNotes" required data-wp-bind--value="state.siteDeliveryNotes">
				</div>
				<div>
					<label for="siteImages">Site Images: </label>
					<input type="text" id="siteImages" name="siteImages" required>
				</div>
				<div>
					<button type="submit">Submit</button>
				</div>

			</form>
		</div>

	</div>
</div>