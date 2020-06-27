<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
ob_start();

// popup directory
class wppb {
	private static $instance;

	private function __construct(){
        add_action( 'admin_init', array( $this, 'create_roles' ) );
		add_action('admin_menu', array($this, 'admin_menu'));
  		add_action('admin_enqueue_scripts', array($this,'enqueue_admin_script') );
		add_action('wp_enqueue_scripts', array($this,'enqueue_front_script') );
	}
	public static function get() {
		return self::$instance ? self::$instance : self::$instance = new self();
	}

	public function create_roles() {
	    global $wp_roles;

	    if ( ! class_exists( 'WP_Roles' ) ) {
	        return;
	    }
	    if ( ! isset( $wp_roles ) ) {
	        $wp_roles = new WP_Roles();
	    }
	    // Shop manager role
	    add_role( 'wppb_role', __( 'Wp Popup Builder Role', 'wppb' ), array(
	        'level_9'        => true,
	        'read'          => true,
	    ) );
	    $wp_roles->add_cap( 'wppb_role', 'wppb_manager' );
	    $wp_roles->add_cap( 'administrator', 'wppb_manager' );
	}
	public function admin_menu() {
	    add_menu_page( __('Wp Popup Builder', 'wppb'), __('Wp Popup Builder', 'wppb'),'wppb_manager', 'wppb',array($this ,'display_addons'));
	}
	public function display_addons(){
		include_once WPPB_PATH.'inc/popup-init.php';
        if(isset($_GET['custom-popup'])){
        	include_once WPPB_PATH."inc/popup.php";
        }else{
            include_once WPPB_PATH."inc/popups-page.php"; 
        }
	}

	public function enqueue_admin_script($hook){
			if('toplevel_page_wppb'!=$hook) return;
		  wp_enqueue_style( 'color-pickr', WPPB_URL . 'js/color/nano.min.css',false);
		  wp_enqueue_script( 'color-pickr', WPPB_URL . 'js/color/pickr.es5.min.js', array ( 'jquery' ), 1, true);

		  //minicolor
		  wp_enqueue_style( 'wppb', WPPB_URL . 'css/style.css',false);
		  wp_enqueue_style( 'wppb-style', WPPB_URL . 'css/popup-style.css',false);
		  wp_enqueue_style( 'wppb-rl', WPPB_URL . 'css/rl_i_editor.css',false);
		  wp_enqueue_media();
		  wp_enqueue_script( 'wppb-js', WPPB_URL . 'js/script.js', array ( 'jquery','jquery-ui-draggable', 'wp-util', 'updates' ), 1, true);
		  wp_localize_script('wppb-js', 'wppb_ajax_backend', array('wppb_ajax_url' => admin_url('admin-ajax.php')));

	}

	public function enqueue_front_script(){
		  wp_enqueue_style('wppb-front', WPPB_URL . 'css/fstyle.css',false);
		  wp_enqueue_script('wppb-front-js', WPPB_URL . 'js/fscript.js', array ( 'jquery' ), 1, true);
		  wp_enqueue_style( 'dashicons' );
		}

	public static function load_file(){
		 	return  array('db','ajax');
		}
	

}

function wppb_install() {
      global $wpdb;
      $table = $wpdb->prefix .'wppb';
      $charset_collate = $wpdb->get_charset_collate();
      $create_table_query = "CREATE TABLE IF NOT EXISTS $table (
          BID INT(11) PRIMARY KEY AUTO_INCREMENT ,
          addon_name VARCHAR(100) NOT NULL,
		      setting LONGTEXT NOT NULL,
		      boption TEXT NOT NULL,
          is_active BOOLEAN DEFAULT '1'
        ) $charset_collate;";
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      dbDelta( $create_table_query );
  }
ob_end_clean();








