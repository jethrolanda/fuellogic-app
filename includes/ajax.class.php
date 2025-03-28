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
class Ajax
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
    add_action('wp_ajax_form_add_note_image', array($this, 'form_add_note_image'));

    add_action('wp_ajax_form_remove_note_image', array($this, 'form_remove_note_image'));

    add_action('wp_ajax_create_site', array($this, 'create_site'));
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
   * Upload images. STEP 5: DELIVERY NOTES
   *  
   * @return object WP JSON
   * @access public
   * @since 1.0
   */
  public function form_add_note_image()
  {

    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    if (!function_exists('wp_handle_upload'))
      require_once(ABSPATH . 'wp-admin/includes/file.php');

    $uploaded_file = $_FILES['file'];
    $temp = explode('.', $uploaded_file['name']);
    $ext = end($temp);

    // Generate unique number and add to filename
    $uploaded_file['name'] = str_replace('.' . $ext, '', $uploaded_file['name']) . '-' . time() . '.' . $ext;

    $upload_overrides = array(
      'test_form'   => false,   // Turn off to avoid 'Invalid form submission.'
      'test_type' => false   // Bypass mime type check so we can avoid doing upload_mimes filter.
    );

    // Perform file upload
    $file = wp_handle_upload($uploaded_file, $upload_overrides);

    if ($file && !isset($file['error'])) {
      wp_send_json(array(
        'status' => 'success',
        'file' => $file
      ));
    } else {
      wp_send_json(array(
        'status' => 'fail',
        'message' => $file['error'],
        'file' => $file,
      ));
    }
  }

  /**
   * Upload images. STEP 5: DELIVERY NOTES
   *  
   * @return object WP JSON
   * @access public
   * @since 1.0
   */
  public function form_remove_note_image()
  {
    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }
    error_log(print_r($_POST, true));
    error_log(print_r(json_decode($_POST['file'], true), true));
  }

  public function create_site()
  {
    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }
    // error_log(print_r($_POST, true));
    // error_log(print_r(json_decode(stripslashes($_POST['data']), true), true));
  }
}
