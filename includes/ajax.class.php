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

    add_action("wp_ajax_pwfw_add_to_wishlist", array($this, 'pwfw_add_to_wishlist'));

    add_action("wp_ajax_pwfw_remove_to_wishlist", array($this, 'pwfw_remove_to_wishlist'));
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
   * Add to wishlist
   * 
   * @since 1.0
   */
  public function pwfw_add_to_wishlist()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wishlist_nonce')) {
      wp_die();
    }

    try {
      $wishlist = get_user_meta(get_current_user_id(), '_pwfw_wishlist', true);
      $wishlist = empty($wishlist) ? array() : $wishlist;
      $product_id = isset($_POST['productId']) ?  $_POST['productId']  : 0;

      if ($product_id > 0 && !in_array($product_id, $wishlist)) {
        array_push($wishlist, $product_id);
        update_user_meta(get_current_user_id(), '_pwfw_wishlist', $wishlist);
        wp_send_json(array(
          'status' => 'success',
          'wishlist' => $wishlist
        ));
      } else {
        wp_send_json(array(
          'status' => 'error',
          'wishlist' => $wishlist
        ));
      }
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  /**
   * Remove from wishlist
   * 
   * @since 1.0
   */
  public function pwfw_remove_to_wishlist()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wishlist_nonce')) {
      wp_die();
    }

    try {
      $wishlist = get_user_meta(get_current_user_id(), '_pwfw_wishlist', true);
      $wishlist = empty($wishlist) ? array() : $wishlist;
      $product_id = isset($_POST['productId']) ?  $_POST['productId']  : 0;

      $key = array_search($product_id, $wishlist);

      if ($product_id > 0 && $key >= 0) {
        unset($wishlist[$key]);
        update_user_meta(get_current_user_id(), '_pwfw_wishlist', $wishlist);
        wp_send_json(array(
          'status' => 'success',
          'wishlist' => $wishlist
        ));
      } else {
        wp_send_json(array(
          'status' => 'error',
          'wishlist' => $wishlist
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
