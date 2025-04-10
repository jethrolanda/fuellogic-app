<?php

namespace FLA\Theme;

/**
 * Scripts class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Scripts
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

    // Load Backend CSS and JS
    add_action('admin_enqueue_scripts', array($this, 'backend_script_loader'));

    // Load Frontend CSS and JS
    add_action('wp_enqueue_scripts', array($this, 'frontend_script_loader'));

    // Load style.css in the editor
    add_action('after_setup_theme', array($this, 'my_theme_editor_styles'));
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
   * Load wp admin backend scripts
   *
   * @since 1.0
   * @return bool
   */
  public function backend_script_loader() {}

  /**
   * Load wp frontend scripts
   *
   * @since 1.0
   * @return bool
   */
  public function frontend_script_loader()
  {
    wp_enqueue_style('dashicons');
    wp_enqueue_style('fuellogic-app', get_template_directory_uri() . '/style.css', array());

    // Antd Calendar
    $asset_file = FLA_JS_ROOT_DIR . 'react-calendar/build/index.asset.php';

    if (file_exists($asset_file)) {
      $asset = include $asset_file;
      wp_register_script('fla-react-calendar-js', FLA_JS_ROOT_URL . 'react-calendar/build/index.js', $asset['dependencies'], $asset['version'], true);
      // wp_enqueue_style('fla-react-calendar-css', FLA_JS_ROOT_URL . 'react-calendar/build/index.css');
    }

    // Antd File uploader
    $asset_file = FLA_JS_ROOT_DIR . 'file-uploader/build/index.asset.php';

    if (file_exists($asset_file)) {
      $asset = include $asset_file;
      wp_register_script('fla-file-uploader-js', FLA_JS_ROOT_URL . 'file-uploader/build/index.js', $asset['dependencies'], $asset['version'], true);
      wp_localize_script('fla-file-uploader-js', 'fuel_logic_app', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wp_rest'),
      ));
    }

    // Search Autocomplete
    $asset_file = FLA_JS_ROOT_DIR . 'search-location/build/index.asset.php';

    if (file_exists($asset_file)) {
      $asset = include $asset_file;
      wp_register_script('fla-search-location-js', FLA_JS_ROOT_URL . 'search-location/build/index.js', $asset['dependencies'], $asset['version'], true);
      // wp_enqueue_style('fla-search-location-css', FLA_JS_ROOT_URL . 'search-location/build/index.css');
    }
    wp_register_script('fla-custom-select-js', FLA_JS_ROOT_URL . 'custom-select.js', array(), array(), true);
  }

  function my_theme_editor_styles()
  {
    add_editor_style(get_template_directory_uri() . '/style.css');
  }
}
