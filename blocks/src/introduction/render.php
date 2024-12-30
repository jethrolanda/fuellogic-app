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


$context = array(
	'current' => 0,
	'data' => array(
		array(
			'id' => 0,
			'selected' => true,
			'icon' => '<i class="icon fa-solid fa-map-location-dot"></i>',
			// 'icon' => get_template_directory_uri() . '/assets/map-location-dot-solid.svg',
			'title' => 'A Nationwide Footprint',
			'content' => 'We can manage any location in the United States, whether you require fuel for one site or multiple sites across several states – and everything in between.',
			'image' => get_template_directory_uri() . '/assets/truck.png' //'http://localhost:8004/wp-content/uploads/2024/12/20240113_120910_cleanup.png'
		),
		array(
			'id' => 1,
			'selected' => false,
			'icon' => '<i class="icon fa-regular fa-lightbulb"></i>',
			// 'icon' => get_template_directory_uri() . '/assets/lightbulb-regular.svg',
			'title' => 'Custom, Creative Solutions',
			'content' => 'We are a full-service mobile fuel provider. This means we strive to assess and understand the nuances of your unique business operation and fuel needs.',
			'image' => get_template_directory_uri() . '/assets/young-worker.png' //'http://localhost:8004/wp-content/uploads/2024/12/Capture.png'
		),
		array(
			'id' => 2,
			'selected' => false,
			'icon' => '<i class="icon fa-solid fa-arrows-rotate"></i>',
			// 'icon' => get_template_directory_uri() . '/assets/arrows-rotate-solid.svg',
			'title' => 'Evergreen Customer Care',
			'content' => 'Our account managers own a customer account for the life of the account. From the first call we receive, we actively listen, assess your fuel needs, and determine how our strategic fuel solutions can be customized to meet your needs.',
			'image' => get_template_directory_uri() . '/assets/young-worker-2.png' //'http://localhost:8004/wp-content/uploads/2024/12/Capture.png'
		)
	),
	'next' => 'Next'
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="fuellogic-app"
	data-wp-watch="callbacks.bgImage"
	data-wp-init="callbacks.bgImage"
	data-wp-on-document--keydown="actions.onKeyDown"
	<?php echo wp_interactivity_data_wp_context($context); ?>>
	<div>
		<?php
		foreach ($context['data'] as $item) {  ?>
			<div class="slider slide-<?php echo $item['id']; ?> <?php echo $item['selected'] ? 'active' : '' ?>">
				<?php echo $item['icon']; ?>
				<h1><?php echo $item['title']; ?></h1>
				<p><?php echo $item['content']; ?></p>
			</div>

		<?php } ?>
		<!-- <template data-wp-each="context.data">
			<div data-wp-bind--hidden="!context.item.selected">
				<div id="icon"></div>
				<h1 data-wp-text="context.item.title"></h1>
				<p data-wp-text="context.item.content"></p>
			</div>
		</template> -->
	</div>
	<div>
		<ul class="indicators">
			<?php
			foreach ($context['data'] as $item) {  ?>
				<li <?php echo isset($item['selected']) && $item['selected'] === true ? 'class="active"' : ""; ?> data-wp-on--click="actions.onChange" <?php echo wp_interactivity_data_wp_context($item); ?>></li>
			<?php } ?>
		</ul>
		<!-- <ul class="indicators">
			<template data-wp-each="context.data">
				<li data-wp-class--active="context.item.selected" data-wp-on--click="actions.onChange" data-wp-context="context.item"></li>
			</template>
		</ul> -->
	</div>
	<a data-wp-on--click="actions.next" href="<?php echo site_url() . "/login"; ?>" class="submit-btn"><span data-wp-text="context.next"></span> <i class="fa-solid fa-arrow-right"></i></a>
</div>