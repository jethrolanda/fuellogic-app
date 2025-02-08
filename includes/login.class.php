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
class Login
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
    add_action("wp_ajax_nopriv_fla_login", array($this, 'fla_login'));
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
   * Login
   * 
   * @since 1.0
   */
  public function fla_login()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['_ajax_nonce']) && !wp_verify_nonce($_POST['_ajax_nonce'], 'login_nonce')) {
      wp_die();
    }

    try {

      $username = isset($_POST['uname']) ?  $_POST['uname']  : '';
      $password = isset($_POST['pword']) ?  $_POST['pword']  : '';

      $creds = array();
      $creds['user_login'] = $username;
      $creds['user_password'] = $password;
      $creds['remember'] = true;
      $user = wp_signon($creds, false);

      error_log(print_r($user, true));

      if (is_wp_error($user)) {
        wp_send_json(array(
          'status' => 'error',
          'code' => $user->get_error_code(),
          'message' => $user->get_error_message()
        ));
      } else {
        wp_set_auth_cookie($user, 0, 0);
        wp_send_json(array(
          'status' => 'success',
          'code' => $user->get_error_code(),
          'message' => $user->get_error_message()
        ));
      }
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }
}
