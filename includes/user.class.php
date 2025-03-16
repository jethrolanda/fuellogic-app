<?php

namespace FLA\Theme;

class User
{


  /**
   * User constructor
   *  
   * @param object $dependencies Array of object dependencies
   * @access public
   * @since 1.0
   */
  public function __construct()
  {

    // Custom login
    // add_filter('login_url', array($this, 'custom_login_url'), 10, 3);

    // If user is not login then they can only access the login page
    // If user is login then they should not see the login and signup page
    // add_action('template_redirect', array($this, 'redirect_users'));

    // If user is not admin then redirect to home page
    // add_action('init', array($this, 'redirect_non_admin_from_wpadmin_to_home'));

    // Display fuel logic extra data to the edit user screen
    // add_action('edit_user_profile', array($this, 'display_extra_data'));
    // add_action('personal_options_update', array($this, 'save_extra_data'));
    // add_action('edit_user_profile_update', array($this, 'save_extra_data'));

    // Create new "customer" role
    // Triggers on plugin theme switch
    add_action('after_switch_theme', array($this, 'add_customer_role_on_plugin_switch'));

    // PROFILE
    // add_action('wp_ajax_fuel_logic_app_get_user_data', array($this, 'get_user_data'));

    // SAVE PROFILE
    // add_action('wp_ajax_fuel_logic_app_update_user_profile', array($this, 'update_user_profile'));

    // TOUR
    // add_action('wp_ajax_fuel_logic_app_finish_tour', array($this, 'finish_tour'));
  }

  /**
   * Custom login url
   *  
   * @param string $login_url Default login url
   * @param string $redirect URL redirect
   * @param bool $force_reauth
   * @return string New Login Url
   * @access public
   * @since 1.0
   */
  function custom_login_url($login_url, $redirect, $force_reauth)
  {
    return home_url('/login');
  }

  /**
   * Redirect non admin to homepage when accessing wp admin
   *   
   * @access public
   * @since 1.0
   */
  public function redirect_non_admin_from_wpadmin_to_home()
  {
    if (
      is_admin() && !current_user_can('administrator') &&
      !(defined('DOING_AJAX') && DOING_AJAX)
    ) {
      wp_redirect(home_url());
      exit;
    }
  }

  /**
   * Prevent user from accessing urls.
   *   
   * @access public
   * @since 1.0
   */
  public function redirect_users()
  {

    global $wp;

    $url = home_url($wp->request);

    if (!is_user_logged_in()) {
      // Redirect to login if not login
      if (!in_array($url, array(site_url() . '/login', site_url() . '/signup', site_url() . '/forgot-password'))) {
        wp_redirect(site_url() . '/login');
        exit;
      }
    } else {
      // Redirect to home if accessing login, signup, forgot password screens
      if (in_array($url, array(site_url() . '/login', site_url() . '/signup', site_url() . '/forgot-password'))) {
        wp_redirect(site_url());
        exit;
      }
    }
  }

  /**
   * Display extra information in the edit profile screen in wp admin
   *  
   * @param object $profile_user WP User data
   * @access public
   * @since 1.0
   */
  public function display_extra_data($profile_user)
  {
    // require_once APP_MAIN_THEME_PATH_DIR . '/templates/edit-user.php';
  }

  /**
   * Save custom field data in the wp admin profile screen
   *  
   * @param int $userid WP User ID
   * @access public
   * @since 1.0
   */
  public function save_extra_data($user_id)
  {
    if (!current_user_can('edit_user', $user_id))
      return false;

    if (isset($_POST['tour']) && $_POST['tour'] == 'on') {
      update_user_meta($user_id, 'tour', 'done');
    } else {
      update_user_meta($user_id, 'tour', '');
    }
  }

  /**
   * Add custom role called 'customer'. Customer = Editor role
   *  
   * @return object WP JSON
   * @access public
   * @since 1.0
   */
  public function add_customer_role_on_plugin_switch()
  {
    remove_role('customer');
    $editor_cap = get_role('editor')->capabilities; // subscriber, contributor
    add_role('customer', 'Customer', $editor_cap);
  }

  /**
   * Get user data
   *  
   * @return object WP JSON
   * @access public
   * @since 1.0
   */
  public function get_user_data()
  {
    $user = wp_get_current_user();
    if (!$user) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    try {

      $data = array(
        'first_name' => get_user_meta($user->ID, 'first_name', true),
        'last_name' => get_user_meta($user->ID, 'last_name', true),
        'email' => $user->user_email,
        'mobile_number' => get_user_meta($user->ID, 'mobile_number', true),
        'company_name' => get_user_meta($user->ID, 'company_name', true),
        // 'hubspot_contact_id' => $this->hubspot->get_contact_id_by_email($user->ID, $user->user_email),
        'is_admin' => current_user_can('administrator')
      );

      wp_send_json(array(
        'status' => 'success',
        'data' => $data
      ));
    } catch (\Exception $e) {
      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  /**
   * Update user profile data
   *  
   * @return object WP JSON
   * @access public
   * @since 1.0
   */
  public function update_user_profile()
  {
    $user = wp_get_current_user();
    if (!$user) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    try {

      $data = isset($_POST['data']) && !empty($_POST['data']) ? $_POST['data'] : array();
      $fname = isset($data['first_name']) ? $data['first_name'] : '';
      if (!empty($fname)) {
        update_user_meta($user->ID, 'first_name', $fname);
      }

      $lname = isset($data['last_name']) ? $data['last_name'] : '';
      if (!empty($lname)) {
        update_user_meta($user->ID, 'last_name', $lname);
      }

      $mobile_number = isset($data['mobile_number']) ? $data['mobile_number'] : '';
      if (!empty($mobile_number)) {
        update_user_meta($user->ID, 'mobile_number', $mobile_number);
      }

      $company_name = isset($data['company_name']) ? $data['company_name'] : '';
      if (!empty($company_name)) {
        update_user_meta($user->ID, 'company_name', $company_name);
      }

      $email = isset($data['email']) ? $data['email'] : '';
      if (!empty($email)) {
        wp_update_user(array(
          'ID' => $user->ID,
          'user_email' => $email
        ));
      }

      $data = array(
        'firstname' => $fname,
        'lastname' => $lname,
        'email' => $email,
        'phone' => $mobile_number,
        'company' => $company_name,
      );

      // Update hubspot properties
      $contact_id = get_user_meta($user->ID, 'hs_contact_id', true);
      if ($contact_id != "") {
        // $this->hubspot->update_contact_details_by_contact_id($contact_id, $data);
      }

      $data['hubspot_contact_id'] = isset($data['hubspot_contact_id']) ? $data['hubspot_contact_id'] : '';

      wp_send_json(array(
        'status' => 'success',
        'data' => $data
      ));
    } catch (\Exception $e) {
      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  /**
   * Finish tour
   *  
   * @return object WP JSON
   * @access public
   * @since 1.0
   */
  public function finish_tour()
  {
    $user = wp_get_current_user();
    if (!$user) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    try {

      update_user_meta($user->ID, 'tour', 'done');

      wp_send_json(array(
        'status' => 'success',
        'tour' => 'done'
      ));
    } catch (\Exception $e) {
      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }
}
