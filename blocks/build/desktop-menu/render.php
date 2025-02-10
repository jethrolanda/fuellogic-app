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

// Global State
wp_interactivity_state('fuellogic-app', array(
	'attributes' => $attributes,
	'ajaxUrl' => admin_url('admin-ajax.php'),
	'nonce'   => wp_create_nonce('logout_nonce'),
	'logout_redirect' => isset($attributes['logoutRedirect']) ? get_permalink($attributes['logoutRedirect']) : '',
));

$context = array('showMenu' => false);


?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	data-wp-init="callbacks.hideLoadingScreen"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<?php //echo do_blocks(get_post_field('post_content', $loadingScreenPattern)); 
	?>
	<div class="menu-list minimized" data-wp-class--minimized="!context.showMenu">
		<div class="wrapper">
			<div class="logo">
				<a href="<?php echo site_url() ?>">
					<img class="large" src="<?php echo get_template_directory_uri(); ?>/assets/Company Logo.png" alt="Company Logo">
					<img class="small" src="<?php echo get_template_directory_uri(); ?>/assets/logo-small.png" alt="Logo Small">
				</a>
			</div>
			<?php
			if (!empty($attributes['data'])) {
			?>
				<ul>
					<?php foreach ($attributes['data'] as $key => $menu) {
						if (isset($menu['page'])) {
							$wp_post = get_post($menu['page']); ?>
							<li class="<?php echo get_post_field('post_name') === $wp_post->post_name ? 'selected' : '' ?>">
								<a href="<?php echo get_permalink($menu['page']); ?>"><i class="<?php echo $menu['fa_class']; ?>"></i><span><?php echo $wp_post->post_title; ?></span></a>
							</li>
					<?php }
					} ?>
				</ul>
			<?php } ?>

			<div class="user-profile">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/user_profile.png" alt="Tom Richards" />
				<div>
					<h4>Tom Richards</h4>
					<p>t.richards@abcsupply.com</p>
				</div>
			</div>
			<div class="logout">
				<span><i class="fa-solid fa-arrow-left"></i> <a href="" data-wp-on--click="actions.logout">Log Out</a></span><i class="fa-solid fa-angle-left" data-wp-on--click="callbacks.showHideMenu"></i>
				<i class="fa-solid fa-angle-right" data-wp-on--click="callbacks.showHideMenu"></i>
			</div>

		</div>
	</div>
</div>