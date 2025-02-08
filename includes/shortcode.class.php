<?php

namespace FLA\Theme;


defined('ABSPATH') || exit;

class Shortcode
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
    add_shortcode('wishlist', array($this, 'wishlist'));
    add_shortcode('add_wishlist', array($this, 'add_wishlist'));
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

  function wishlist($atts)
  {
    $atts = shortcode_atts(array(
      'foo' => 'no foo',
      'baz' => 'default baz'
    ), $atts, 'bartag');

    ob_start();

    echo do_blocks('<!-- wp:product-wishlist-for-woocommerce/wishlist /-->');

    return ob_get_clean();
  }

  function add_wishlist($atts)
  {
    $atts = shortcode_atts(array(
      'foo' => 'no foo',
      'baz' => 'default baz'
    ), $atts, 'bartag');

    ob_start();

    echo do_blocks('<!-- wp:product-wishlist-for-woocommerce/add-wishlist /-->');
    return ob_get_clean();
  }
}
