<?php
/*
  Plugin Name: WordPress Popup Builder
  Description: ThemeHunk Business Popup Free WordPress Plugin is specially built to show Lightbox Popup on your Page, Posts and Custom Posts. It contains ready to use popups with editing options and powerful animation effects. It will display all changes in real time. Just customize the desired popup and use it.
  Version: 1.0
  Author: ThemeHunk
  Author URI: http://www.themehunk.com/
  Text Domain: wppb
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define('WPPB_URL', plugin_dir_url(__FILE__));
define('WPPB_PATH', plugin_dir_path(__FILE__));


define("WPPB_PAGE_URL", admin_url('admin.php?page=wppb'));

include_once( WPPB_PATH . 'admin/inc.php');
include_once( WPPB_PATH . 'front/shortcode.php');
include_once( WPPB_PATH . 'front/load.php');

register_activation_hook( __FILE__, 'wppb_install' );
add_action( 'plugins_loaded', 'wppb_loaded' );

function wppb_loaded(){
  $instance  = wppb::get();
  $load_Files =  wppb::load_file();
	  foreach ($load_Files as $value) {
		include_once( WPPB_PATH . 'admin/'.$value.'.php');
	  }
  	wppb_shortcode::get();
  	wppb_load::get();
 }















