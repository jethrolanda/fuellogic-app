<?php

namespace FLA\Theme;

/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * WP Settings Class.
 */
class Blocks
{
  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;

  /**
   * Class constructor.
   *
   * @since 1.0.0
   */
  public function __construct()
  {
    add_action('init', array($this, 'create_block_blocks_block_init'));

    add_filter('block_categories_all', array($this, 'register_new_category'));

    add_action('enqueue_block_editor_assets', array($this, 'my_block_editor_styles'));
  }

  /**
   * Main Instance.
   * 
   * @since 1.0
   */
  public static function instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }
  /**
   * Registers the block using the metadata loaded from the `block.json` file.
   * Behind the scenes, it registers also all assets so they can be enqueued
   * through the block editor in the corresponding context.
   *
   * @see https://developer.wordpress.org/reference/functions/register_block_type/
   */
  public function create_block_blocks_block_init()
  {
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/login');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/signup');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/introduction');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/onboarding');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/orders');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/invoices');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/loading');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/mobile-menu');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/desktop-menu');

    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/site-edit');

    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/sites');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/sites-address');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/sites-delivery-images');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/sites-delivery-notes');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/sites-delivery-schedule');
    register_block_type_from_metadata(FLA_BLOCKS_ROOT_DIR . 'build/sites-name');
  }

  public function register_new_category($categories)
  {

    // Adding a new category.
    $categories[] = array(
      'slug'  => 'fuel-logic-service-area-blocks',
      'title' => 'Fuel Logic Service Area'
    );

    return $categories;
  }
  public function my_block_editor_styles() {}
}
