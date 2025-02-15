<?php

namespace FLA\Theme;


defined('ABSPATH') || exit;

class Cpt
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
    add_action('init', array($this, 'create_sites_cpt'));
    add_filter('use_block_editor_for_post_type', array($this, 'prefix_disable_gutenberg'), 10, 2);
    add_action('init', array($this, 'init_remove_support'), 100);
    add_action('admin_head', array($this, 'my_remove_meta_boxes1'), 99, 2);
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


  public function create_sites_cpt()
  {

    register_post_type(
      'sites',
      // CPT Options
      array(
        'labels' => array(
          'name' => __('Sites'),
          'singular_name' => __('Site')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'sites'),
        'show_in_rest' => true,
        'capabilities' => array(
          // 'create_posts' => false
        ),
        'publicly_queryable'  => false
      ),
    );
  }


  public function prefix_disable_gutenberg($current_status, $post_type)
  {
    // Use your post type key instead of 'sites'
    if ($post_type === 'sites') return false;
    return $current_status;
  }

  public function init_remove_support()
  {
    remove_post_type_support('sites', 'editor');
  }

  public function my_remove_meta_boxes1()
  {
    remove_meta_box('pageparentdiv', 'sites', 'side');
  }
}
