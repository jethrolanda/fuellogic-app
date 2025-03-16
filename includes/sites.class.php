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
class Sites
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
    add_action("wp_ajax_add_site", array($this, 'add_site'));

    add_action("wp_ajax_update_site", array($this, 'update_site'));

    add_action("wp_ajax_delete_site", array($this, 'delete_site'));

    add_action('add_meta_boxes', array($this, 'wpse_add_custom_meta_box_2'));

    add_filter('manage_sites_posts_columns', array($this, 'cpt_author_column'));
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
   * Add site
   * 
   * @since 1.0
   */
  public function add_site()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'site-nonce')) {
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
          'data' => $this->get_sites()
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
   * Update site
   * 
   * @since 1.0
   */
  public function update_site()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'site-nonce')) {
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
          'data' => $this->get_sites()
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
   * Delete site
   * 
   * @since 1.0
   */
  public function delete_site()
  {

    if (!defined('DOING_AJAX') || !DOING_AJAX) {
      wp_die();
    }

    /**
     * Verify nonce
     */
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'site-nonce')) {
      wp_die();
    }

    try {

      if ($_POST['id']) {
        wp_delete_post($_POST['id'], true);
        wp_send_json(array('status' => 'success', 'data' => $this->get_sites()));
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
      'Site Information',
      array($this, 'show_custom_meta_box_2'),
      'sites',
      'normal',
      'high'
    );
  }

  public function show_custom_meta_box_2()
  {
    global $post;


    $site_address = get_post_meta($post->ID, '_site_address', true);
    $site_delivery_schedule = get_post_meta($post->ID, '_site_delivery_schedule', true);
    $site_delivery_notes = get_post_meta($post->ID, '_site_delivery_notes', true);
    $site_images = get_post_meta($post->ID, '_site_images', true);
?>
    <table>
      <tr>
        <th>User</th>
        <td><?php echo get_the_author_meta('display_name', $post->post_author); ?></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><?php echo $site_address; ?></td>
      </tr>
      <tr>
        <th>Delivery Schedule</th>
        <td><?php echo $site_delivery_schedule; ?></td>
      </tr>
      <tr>
        <th>Delivery Notes</th>
        <td><?php echo $site_delivery_notes; ?></td>
      </tr>
      <tr>
        <th>Images</th>
        <td><?php echo $site_images; ?></td>
      </tr>
    </table>
<?php
  }

  public function get_sites()
  {
    $posts = get_posts(array(
      'post_type' => 'sites',
      'post_status' => 'publish',
      'numberposts' => -1,
      'author' => get_current_user_id(),
      'fields' => 'ids',
      'order' => 'asc'
    ));
    $sites = array();
    if ($posts) {
      foreach ($posts as $key => $id) {
        $sites[$key]['id'] = $id;
        $sites[$key]['name'] = get_the_title($id);
        $sites[$key]['address'] = get_post_meta($id, '_site_address', true);
        $sites[$key]['delivery_schedule'] = get_post_meta($id, '_site_delivery_schedule', true);
        $sites[$key]['delivery_notes'] = get_post_meta($id, '_site_delivery_notes', true);
        $sites[$key]['images'] = get_post_meta($id, '_site_images', true);
      }
    }
    return $sites;
  }

  public function cpt_author_column($columns)
  {
    return array_merge($columns, ['author' => __('Author', 'textdomain')]);
  }
}
