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
class Orders
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
    add_action("wp_ajax_add_order", array($this, 'add_order'));

    add_action("wp_ajax_update_order", array($this, 'update_order'));

    add_action("wp_ajax_delete_order", array($this, 'delete_order'));

    add_action('add_meta_boxes', array($this, 'wpse_add_custom_meta_box_2'));

    add_filter('manage_orders_posts_columns', array($this, 'cpt_author_column'));

    add_action("wp_ajax_close_thank_you_modal", array($this, 'close_thank_you_modal'));

    add_action('save_post_orders', array($this, 'save_post'), 10, 3);
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
   * Add order
   * 
   * @since 1.0
   */
  public function add_order()
  {

    // if (get_current_user_id() == 0) {
    //   wp_die();
    // }

    // if (!defined('DOING_AJAX') || !DOING_AJAX) {
    //   wp_die();
    // }

    /**
     * Verify nonce
     */
    // if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'order-nonce')) {
    //   wp_die();
    // }

    try {

      // error_log(print_r($_POST, true));
      $data = json_decode(stripslashes($_POST['data']));
      $images = json_decode(stripslashes($_POST['images']));
      $gas_type = json_decode(stripslashes($_POST['gas_type']));
      $machines = json_decode(stripslashes($_POST['machines']));
      $sanitized_images = array_map('sanitize_text_field', $images);


      // Create order object
      $my_post = array(
        'post_status'   => 'publish',
        'post_type'     => 'orders'
      );

      // Insert the post into the database
      $order_id = wp_insert_post($my_post);

      if (!is_wp_error($order_id)) {

        // Update Title
        $post_update = array(
          'ID'         => $order_id,
          'post_title' => "# FL-" . $order_id
        );
        wp_update_post($post_update);

        update_post_meta($order_id, '_order_data', $data);
        update_post_meta($order_id, '_order_images', $sanitized_images);
        update_post_meta($order_id, '_order_gas_type', $gas_type);
        update_post_meta($order_id, '_order_machines', $machines);
        update_post_meta($order_id, '_order_status', 'pending');
        update_post_meta($order_id, '_order_user_id', get_current_user_id());

        return array(
          'status' => 'success',
          'order_id' => $order_id
        );
      } else {
        return array(
          'status' => 'error',
          'message' => $order_id->get_error_message()
        );
      }
    } catch (\Exception $e) {

      return array(
        'status' => 'error',
        'message' => $e->getMessage()
      );
    }
  }

  /**
   * Update order
   * 
   * @since 1.0
   */
  public function update_order()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'order-nonce')) {
      wp_die();
    }

    try {

      // Create post object
      $my_post = array(
        'post_title'    => sanitize_text_field($_POST['siteName']),
        'post_status'   => 'publish',
        'post_type'     => 'sites'
      );

      // Insert the post into the database
      $post_id = wp_insert_post($my_post);

      if (!is_wp_error($post_id)) {

        update_post_meta($post_id, '_site_address', sanitize_text_field($_POST['siteAddress']));
        update_post_meta($post_id, '_site_delivery_schedule', sanitize_text_field($_POST['siteDeliverySchedule']));
        update_post_meta($post_id, '_site_delivery_notes', sanitize_text_field($_POST['siteDeliveryNotes']));
        update_post_meta($post_id, '_site_images', sanitize_text_field($_POST['siteImages']));

        wp_send_json(array(
          'status' => 'success',
          'data' => $this->get_orders()
        ));
      } else {
        wp_send_json(array(
          'status' => 'error',
          'message' => $post_id->get_error_message()
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
   * Delete order
   * 
   * @since 1.0
   */
  public function delete_order()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'order-nonce')) {
      wp_die();
    }

    try {

      if ($_POST['id']) {
        wp_delete_post($_POST['id'], true);
        wp_send_json(array('status' => 'success', 'data' => $this->get_orders()));
      } else {
        wp_send_json(array('status' => 'success', 'message' => 'No id provided'));
      }
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  public function wpse_add_custom_meta_box_2()
  {
    add_meta_box(
      'custom_meta_box-2',
      'Order Information',
      array($this, 'show_custom_meta_box_2'),
      'orders',
      'normal',
      'high'
    );
  }

  public function show_custom_meta_box_2()
  {
    global $post;


    $order_address = get_post_meta($post->ID, '_order_address', true);
    $order_delivery_schedule = get_post_meta($post->ID, '_order_delivery_schedule', true);
    $order_delivery_notes = get_post_meta($post->ID, '_order_delivery_notes', true);
    $order_images = get_post_meta($post->ID, '_order_images', true);
    $order_status = get_post_meta($post->ID, '_order_status', true);

?>
    <table>
      <tr>
        <th>User</th>
        <td><?php echo get_the_author_meta('display_name', $post->post_author); ?></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><?php echo $order_address; ?></td>
      </tr>
      <tr>
        <th>Delivery Schedule</th>
        <td><?php echo $order_delivery_schedule; ?></td>
      </tr>
      <tr>
        <th>Delivery Notes</th>
        <td><?php echo $order_delivery_notes; ?></td>
      </tr>
      <tr>
        <th>Images</th>
        <td><?php
            if (!empty($order_images)) {
              foreach ($order_images as $img) {
                echo "<img src='$img' style='width: 100px; height: 100px; margin-right: 10px;'>";
              }
            } ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td>
          <select name="order_status" id="order_status">
            <option value="pending" <?php selected($order_status, 'pending'); ?>>Pending</option>
            <option value="processing" <?php selected($order_status, 'processing'); ?>>Processing</option>
            <option value="out-for-delivery" <?php selected($order_status, 'out-for-delivery'); ?>>Out for delivery</option>
            <option value="delivered" <?php selected($order_status, 'delivered'); ?>>Delivered</option>
          </select>
        </td>
      </tr>
    </table>
<?php
  }

  public function get_orders()
  {
    $posts = get_posts(array(
      'post_type' => 'orders',
      'post_status' => 'publish',
      'numberposts' => -1,
      'author' => get_current_user_id(),
      'fields' => 'ids',
      'order' => 'desc'
    ));
    $orders = array();
    if ($posts) {
      foreach ($posts as $key => $id) {
        $orders[$key]['id'] = $id;
        $orders[$key]['name'] = get_the_title($id);
        $orders[$key]['data'] = get_post_meta($id, '_order_data', true);
        $orders[$key]['images'] = get_post_meta($id, '_order_images', true);
        $orders[$key]['status'] = get_post_meta($id, '_order_status', true);
      }
    }
    return $orders;
  }

  public function cpt_author_column($columns)
  {
    return array_merge($columns, ['author' => __('Author', 'textdomain')]);
  }

  public function get_order($id) {}

  public function close_thank_you_modal()
  {
    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    global $fla_theme;

    /**
     * Verify nonce
     */
    // if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'site-nonce')) {
    //   wp_die();
    // }

    try {

      $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : 0;
      if ($order_id > 0) {
        update_post_meta($order_id, '_order_thank_you_modal', 'closed');
      }
      // error_log(print_r($order, true));
      wp_send_json(array('status' => 'success'));
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  public function save_post($post_id, $post, $update)
  {
    $parent_id = wp_is_post_revision($post_id);
    if (false !== $parent_id) {
      $post_id = $parent_id;
    }
    if (isset($_POST['order_status']) && !empty($_POST['order_status'])) {
      $order_status = sanitize_text_field($_POST['order_status']);
      update_post_meta($post_id, '_order_status', $order_status);
    }
  }
}
