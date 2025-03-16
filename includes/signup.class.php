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
 * Signup Class.
 */
class Signup
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
    add_action("wp_ajax_nopriv_fla_signup", array($this, 'fla_signup'));
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
   * Signup
   * 
   * @since 1.0
   */
  public function fla_signup()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }


    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'signup-nonce')) {
      wp_die();
    }

    try {

      $data = $_POST;
      $email = isset($data['email_address']) ? sanitize_email($data['email_address']) : "";
      $user_id = wp_create_user($email, '12345', $email);

      // Error
      if (is_wp_error($user_id)) {
        wp_send_json(array(
          'status' => 'error',
          'message' => "Sorry, that email already exist!"
        ));
      } else { // Success

        // Change role
        $user = new \WP_User($user_id);
        $user->set_role('customer');

        // Save Extra Data
        foreach ($data as $k => $d) {
          switch ($k) {
            case 'first_name':
            case 'last_name':
            case 'have_account':
            case 'company_name':
            case 'mobile_number':
              $value = sanitize_text_field($d);
              update_user_meta($user_id, $k, $value);
              break;
            case 'terms_of_service':
              $value = rest_sanitize_boolean($d);
              update_user_meta($user_id, $k, $value);
              break;
            default:
          }
        }

        $info = array();
        $info['user_login'] = $email;
        $info['user_password'] = 12345;
        $info['remember'] = true;
        wp_signon($info, false);

        // Send email password to user email address
        // $this->fla_send_email($user, $info);

        wp_send_json(array(
          'status' => 'success',
          'message' => 'You are successfully registered. Logging in please wait...'
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
