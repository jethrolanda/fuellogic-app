<?php
function create_block_blocks_block_init()
{
  register_block_type_from_metadata(__DIR__ . '/blocks/build/login');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/signup');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/introduction');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/onboarding');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/sites');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/orders');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/invoices');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/loading');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/mobile-menu');
  register_block_type_from_metadata(__DIR__ . '/blocks/build/desktop-menu');
}
add_action('init', 'create_block_blocks_block_init');

add_filter('show_admin_bar', '__return_false');

// Load Frontend CSS and JS
add_action('wp_enqueue_scripts', 'frontend_script_loader');
function frontend_script_loader()
{
  wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css', array());

  // Range Slider Scripts
  // wp_register_script('range-slider-script', FSCS_JS_ROOT_URL . 'rangeslider.min.js', array('jquery'), $this->hours_in_seconds, false);
}
// include_once 'inc/constants.php';
// include_once 'inc/autoloader.php';

// class FLA_Theme
// {

//   public $scripts;
//   public $login;
//   public $orders;
//   public $metabox;
//   public $register;
//   public $ordercpt;
//   public $user;
//   public $hubspot;

//   public function __construct()
//   {
//     $this->scripts = new \FuelLogicApp\Theme\Scripts();
//     $this->login = new \FuelLogicApp\Theme\Login();
//     $this->orders = new \FuelLogicApp\Theme\Orders();
//     $this->metabox = new \FuelLogicApp\Theme\MetaBox();
//     $this->register = new \FuelLogicApp\Theme\Register();
//     $this->ordercpt = new \FuelLogicApp\Theme\OrdersCPT();
//     $this->hubspot = new \FuelLogicApp\Theme\Hubspot();
//     $this->user = new \FuelLogicApp\Theme\User(array('Hubspot' => $this->hubspot));

//     /*---EXTRAS ---*/

//     // Remove admin bar in the frontend
//     add_action('after_setup_theme', array($this, 'remove_admin_bar'));

//     // Add custom urls
//     add_action('init', array($this, 'add_rewrite_endpoint'));
//   }

//   public function remove_admin_bar()
//   {
//     show_admin_bar(false);
//   }

//   public function add_rewrite_endpoint()
//   {
//     add_rewrite_endpoint('saved-locations', EP_ROOT);
//     add_rewrite_endpoint('contact-us', EP_ROOT);
//     add_rewrite_endpoint('order-process', EP_ROOT);
//     add_rewrite_endpoint('login', EP_ROOT);
//     add_rewrite_endpoint('signup', EP_ROOT);
//     add_rewrite_endpoint('forgot-password', EP_ROOT);
//     add_rewrite_endpoint('profile', EP_ROOT);
//     flush_rewrite_rules();
//   }
// }

// $GLOBALS['fla_theme'] = new FLA_Theme();
