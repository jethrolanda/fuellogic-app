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
		<input type="text" placeholder="Email" />
		<input type="password" placeholder="Password" />
		<div class="remember">

			<label for="remember"><input type="checkbox" id="remember" /> Remember me</label>
			<a href="#">Forgot password?</a>
		</div>
		<button>LOG IN</button>
	</form>

</div>