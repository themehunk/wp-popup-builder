<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
class wppb_ajax extends wppb_db{
	public static $instance;
	 function __construct(){
			parent::__construct();
			add_action('wp_ajax_custom_insert', array($this,'insert'));
			add_action('wp_ajax_custom_update', array($this,'update'));
			add_action('wp_ajax_delete_popup', array($this,'delete'));
			add_action('wp_ajax_option_update', array($this,'option_update'));
			add_action('wp_ajax_popup_active', array($this,'update'));

			add_action('wp_ajax_getLeadForm', array($this,'getLeadForm'));
	}
	public static function get(){
		return self::$instance ? self::$instance : self::$instance = new self();
	}

	public function insert(){
		$result = $this->popup_insert();
		echo $result?$result:0;
		die();

	}
	public function update(){
		$result = $this->popup_update();
		echo $result?$result:0;
		die();
	}
	public function delete(){
		$result = $this->popup_delete();
		echo $result?$result:0;
		die();

	}
	public function option_update(){
			$result = $this->opt_update();
			echo $result?$result:0;
		die();
	}

	// lead form
	public function getLeadForm(){
		$result = $this->get_lead_form_ajx();
		echo $result?$result:0;
		die();
	}
}
wppb_ajax::get();
