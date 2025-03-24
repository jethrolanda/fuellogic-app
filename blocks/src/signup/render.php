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
	array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('signup-nonce'),
		'signup_redirect' => isset($attributes['loginRedirect']) ? get_permalink($attributes['loginRedirect']) : '',
	),
);

$context = array('signup_msg' => '', 'status' => '');
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div
		class="signup-message"
		data-wp-watch="callbacks.renderSignupMsg"
		data-wp-class--error="state.isError"
		data-wp-class--success="state.isSuccess"
		data-wp-bind--hidden="!state.hasMessage"></div>
	<form data-wp-on--submit="actions.submitForm">
		<label class="checkbox small" for="has_account">
			<span class="label">
				<input type="checkbox" id="has_account" name="has_account"><span class="checkmark"></span> My company currently has an account
			</span>
		</label>

		<input type="text" placeholder="Company Name" name="company_name" required />
		<input type="text" placeholder="First Name" name="first_name" required />
		<input type="text" placeholder="Last Name" name="last_name" required />
		<input type="email" placeholder="Email Address" name="email_address" required />
		<input type="text" placeholder="Mobile Number" name="mobile_number" required />
		<input type="password" placeholder="Password" name="password" required />
		<div class="remember">
			<label class="checkbox small" for="terms_conditions_agreement">
				<span class="label">
					<input type="checkbox" id="terms_conditions_agreement" name="terms_conditions_agreement"><span class="checkmark"></span> I agree with <a href="#">Terms of Service</a>
				</span>
			</label>
		</div>
		<button>SIGN UP</button>
	</form>

</div>