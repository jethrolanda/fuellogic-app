<?php
include_once 'inc/constants.php';
include_once 'inc/autoloader.php';

class FLA_Theme
{

  public $scripts;
  public $blocks;
  public $ajax;
  public $login;
  public $cpt;
  public $sites;
  public $signup;
  public $email;
  public $user;

  public function __construct()
  {

    $this->scripts = new \FLA\Theme\Scripts();
    $this->ajax = new \FLA\Theme\Blocks();
    $this->ajax = new \FLA\Theme\Ajax();
    $this->login = new \FLA\Theme\Login();
    $this->cpt = new \FLA\Theme\Cpt();
    $this->sites = new \FLA\Theme\Sites();
    $this->signup = new \FLA\Theme\Signup();
    $this->email = new \FLA\Theme\Email();
    $this->user = new \FLA\Theme\User();

    /*---EXTRAS ---*/

    // Remove admin bar in the frontend
    add_action('after_setup_theme', array($this, 'remove_admin_bar'));

    // Add custom urls
    add_action('init', array($this, 'add_rewrite_endpoint'));
  }

  public function remove_admin_bar()
  {
    show_admin_bar(false);
  }

  public function add_rewrite_endpoint()
  {
    // add_rewrite_endpoint('saved-locations', EP_ROOT);
    // add_rewrite_endpoint('contact-us', EP_ROOT);
    // add_rewrite_endpoint('order-process', EP_ROOT);
    // add_rewrite_endpoint('login', EP_ROOT);
    // add_rewrite_endpoint('signup', EP_ROOT);
    // add_rewrite_endpoint('forgot-password', EP_ROOT);
    // add_rewrite_endpoint('profile', EP_ROOT);
    // flush_rewrite_rules();
  }
}

$GLOBALS['fla_theme'] = new FLA_Theme();
