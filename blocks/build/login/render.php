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

wp_interactivity_state(
	'fuellogic-app',
	array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('login_nonce'),
	),
);

$context = array(
	'uname' => '',
	'pword' => '',
	'remember' => false,
	'login_status' => '',
	'login_msg' => ''
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div class="login-message" data-wp-watch="callbacks.renderLoginMsg"></div>
	<form action="#">
		<input data-wp-on--input="callbacks.setUserName" name="uname" type="text" placeholder="Email" />
		<input data-wp-on--input="callbacks.setPassword" name="pword" type="password" placeholder="Password" />
		<div class="remember">
			<label for="remember">
				<input data-wp-on--click="callbacks.setRemember" type="checkbox" id="remember" /> Remember me</label>
			<a href="#">Forgot password?</a>
		</div>
		<button data-wp-on--click="actions.login">LOG IN</button>
	</form>

</div>