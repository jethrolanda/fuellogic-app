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
	<form action="#">
		<label for="has_account"><input type="checkbox" id="has_account" /> My company currently has an account</label>
		<input type="text" placeholder="Company Name" />
		<input type="text" placeholder="First Name" />
		<input type="text" placeholder="Last Name" />
		<input type="email" placeholder="Email Address" />
		<input type="text" placeholder="Mobile Number" />
		<input type="password" placeholder="Password" />
		<div class="remember">

			<label for="terms_conditions_agreement"><input type="checkbox" id="terms_conditions_agreement" /> I agree with Terms of Service</label>
		</div>
		<button>SIGN UP</button>
	</form>

</div>