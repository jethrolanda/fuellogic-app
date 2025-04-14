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
    add_action("wp_ajax_add_order_ajax", array($this, 'add_order_ajax'));
    add_action("wp_ajax_update_order", array($this, 'update_order'));
    add_action("wp_ajax_delete_order", array($this, 'delete_order'));
    add_action("wp_ajax_update_order_status", array($this, 'update_order_status'));

    add_action('add_meta_boxes', array($this, 'wpse_add_custom_meta_box_2'));

    add_filter('manage_orders_posts_columns', array($this, 'cpt_author_column'));

    // Modals
    add_action("wp_ajax_close_thank_you_modal", array($this, 'close_thank_you_modal'));
    add_action("wp_ajax_close_first_delivery_modal", array($this, 'close_first_delivery_modal'));
    add_action("wp_ajax_close_fuel_delivered_modal", array($this, 'close_fuel_delivered_modal'));


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
   * Add order AJAX
   * 
   * @since 1.0
   */
  public function add_order_ajax()
  {

    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    try {
      $order = $this->add_order();
      wp_send_json(array(
        'order' => $order,
        'status' => 'success',
      ));
    } catch (\Exception $e) {
      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  /**
   * Add order
   * 
   * @since 1.0
   */
  public function add_order()
  {

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
        update_post_meta($order_id, '_order_address', sanitize_text_field($data->site_delivery_address));
        update_post_meta($order_id, '_order_delivery_schedule', sanitize_text_field($data->delivery_date));
        update_post_meta($order_id, '_order_delivery_notes', sanitize_text_field($data->notes));
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


  /**
   * Update order status
   * 
   * @since 1.0
   */
  public function update_order_status()
  {

    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    try {

      $order_status = !empty($_POST['order_status']) ? $_POST['order_status'] : '';
      $order_id = !empty($_POST['order_id']) ? $_POST['order_id'] : '';

      if ($order_status == 'delivered') {
        $user_id = get_post_meta($order_id, '_order_user_id', true);
        $first_delivery_modal = get_user_meta($user_id, '_order_first_delivery_modal', true);
        if ($first_delivery_modal !== 'closed') {
          update_user_meta($user_id, '_order_first_delivery_modal', 'open');
        } else {
          update_user_meta($user_id, '_order_fuel_delivered_modal', 'open');
        }
      }

      if ($order_status != "" && $order_id !== "") {
        update_post_meta($order_id, '_order_status', $order_status);

        // First delivery modal
        $user_id = get_current_user_id();
        $first_delivery = get_user_meta($user_id, '_order_first_delivery_modal', true);

        // Fuel delivered modal
        $fuel_delivered = get_user_meta($user_id, '_order_fuel_delivered_modal', true);
        wp_send_json(array(
          'status' => 'success',
          'isFirstDelivery' => empty($first_delivery) || $first_delivery !== 'open' ? true : false,
          'isFuelDelivered' => empty($fuel_delivered) || $fuel_delivered !== 'open' ? true : false
        ));
      } else {
        wp_send_json(array('status' => 'error'));
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

    $gas_type_list = array(
      'diesel' => 'On-Road Clear Diesel (trucks)',
      'gas' => 'GAS – Unleaded Gasoline',
      'dyed_diesel' => 'Off-Road – Dyed Diesel (Generators etc)',
      'def' => 'DEF – Diesel Exhaust Fluid'
    );
    $machines_list = array(
      'vehicles' => 'Vehicles (Day Cabs, Box Trucks, Small Trucks)',
      'bulk_tank' => 'Bulk Tank (Jobsite Tanks, Big Tanks, etc.)',
      'construction_equipment' => 'Construction Equipment (Yellow Iron, Generators)',
      'generators' => 'Building Generators',
      'reefer' => 'Reefer (Refrigerated Trailers)',
      'other' => 'Other'
    );

    $order_address = get_post_meta($post->ID, '_order_address', true);
    $order_delivery_schedule = get_post_meta($post->ID, '_order_delivery_schedule', true);
    $order_delivery_notes = get_post_meta($post->ID, '_order_delivery_notes', true);
    $order_images = get_post_meta($post->ID, '_order_images', true);
    $order_status = get_post_meta($post->ID, '_order_status', true);
    $data = get_post_meta($post->ID, '_order_data', true);
    $gas_type = get_post_meta($post->ID, '_order_gas_type', true);
    $machines = get_post_meta($post->ID, '_order_machines', true);

    // error_log(print_r($gas_type, true));
?>
    <style>
      .fla-table th,
      .fla-table td {
        padding: 10px;
      }

      .fla-table th {
        text-align: right;
      }
    </style>
    <h1>Site Details:</h1>
    <table class="fla-table">
      <tr>
        <th>Site Name</th>
        <td><?php echo $data->site_name; ?></td>
      </tr>
      <tr>
        <th>Site Delivery Address</th>
        <td><?php echo $data->site_delivery_address; ?></td>
      </tr>
      <tr>
        <th>Site Contact First Name</th>
        <td><?php echo $data->site_contact_first_name; ?></td>
      </tr>
      <tr>
        <th>Site Contact Last Name</th>
        <td><?php echo $data->site_contact_last_name; ?></td>
      </tr>
      <tr>
        <th>Site Contact Phone</th>
        <td><?php echo $data->site_contact_last_name; ?></td>
      </tr>
      <tr>
        <th>Site Contact Email</th>
        <td><?php echo $data->site_contact_email; ?></td>
      </tr>
    </table>
    <h1>Fuel Type:</h1>
    <table class="fla-table">
      <?php foreach ($gas_type as $type) { ?>
        <tr>
          <th><?php echo $gas_type_list[$type]; ?></th>
          <td><?php echo $data->{$type . '_qty'}; ?></td>
        </tr>
      <?php } ?>
    </table>
    <h1>Equipment:</h1>
    <table class="fla-table">
      <?php foreach ($machines as $type) { ?>
        <tr>
          <th><?php echo $machines_list[$type]; ?></th>
          <td><?php echo $data->{$type . '_qty'}; ?></td>
        </tr>
      <?php } ?>
    </table>
    <h1>Schedule:</h1>
    <table class="fla-table">
      <tr>
        <th>Delivery Schedule</th>
        <td><?php echo $order_delivery_schedule; ?></td>
      </tr>
    </table>
    <h1>Notes:</h1>
    <table class="fla-table">
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
    </table>
    <h1>Payments:</h1>
    <h1>Status:</h1>
    <select name="order_status" id="order_status">
      <option value="pending" <?php selected($order_status, 'pending'); ?>>Pending</option>
      <option value="processing" <?php selected($order_status, 'processing'); ?>>Processing</option>
      <option value="out-for-delivery" <?php selected($order_status, 'out-for-delivery'); ?>>Out for delivery</option>
      <option value="delivered" <?php selected($order_status, 'delivered'); ?>>Delivered</option>
    </select>
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

  public function close_first_delivery_modal()
  {
    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }


    try {

      $user_id = get_current_user_id();
      update_user_meta($user_id, '_order_first_delivery_modal', 'closed');

      // error_log(print_r($order, true));
      wp_send_json(array('status' => 'success'));
    } catch (\Exception $e) {

      wp_send_json(array(
        'status' => 'error',
        'message' => $e->getMessage()
      ));
    }
  }

  public function close_fuel_delivered_modal()
  {
    if (get_current_user_id() == 0) {
      wp_die();
    }

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }


    try {

      $user_id = get_current_user_id();
      update_user_meta($user_id, '_order_fuel_delivered_modal', 'closed');

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

      if ($order_status == 'delivered') {
        $user_id = get_post_meta($post_id, '_order_user_id', true);
        $first_delivery_modal = get_user_meta($user_id, '_order_first_delivery_modal', true);
        if ($first_delivery_modal !== 'closed') {
          update_user_meta($user_id, '_order_first_delivery_modal', 'open');
        } else {
          update_user_meta($user_id, '_order_fuel_delivered_modal', 'open');
        }
      }
    }
  }
}
