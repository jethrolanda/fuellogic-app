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

$loadingScreenPattern = '';
if (isset($attributes['loadingScreenPattern']) && $attributes['loadingScreenPattern'] > 0) {
	$loadingScreenPattern = $attributes['loadingScreenPattern'];
}
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	data-wp-init="callbacks.hideLoadingScreen"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<i class="fa-solid fa-bars" data-wp-on--click="callbacks.showHideMenu"></i>
	<?php //echo do_blocks(get_post_field('post_content', $loadingScreenPattern)); 
	?>
	<div class="menu-list" data-wp-class--show="context.showMenu">
		<div class="wrapper">
			<i class="fa-solid fa-close" data-wp-on--click="callbacks.showHideMenu"></i>
			<div class="user-profile">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/user_profile.png" alt="Tom Richards" />
				<div>
					<h4>Tom Richards</h4>
					<p>t.richards@abcsupply.com</p>
				</div>
			</div>

			<ul>
				<?php foreach ($attributes['data'] as $key => $menu) {
					$wp_post = get_post($menu['page']); ?>
					<li class="<?php echo get_post_field('post_name') === $wp_post->post_name ? 'selected' : '' ?>">
						<i class="<?php echo $menu['fa_class']; ?>"></i><a href="<?php echo get_permalink($menu['page']); ?>"> <?php echo $wp_post->post_title; ?> </a>
					</li>
				<?php	} ?>
				<li class="<?php echo get_post_field('post_name') === 'logout' ? 'selected' : '' ?>"><i class="fa-solid fa-arrow-left"></i> <a href="#" data-wp-on--click="actions.logout">Log Out</a></li>
			</ul>
		</div>
	</div>
</div>