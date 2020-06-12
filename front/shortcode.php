<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 

class wppb_shortcode{
	private function __construct(){
		add_shortcode( 'wppb', array($this,'popup') );
	}
	public static function get(){
		return new self();
	}
 	public function popup( $atts ,$content) {
			    $a = shortcode_atts( array('popup' => '','inline' => '','widget' => ''), $atts );
				$popup_id = false;
				$popupInline = true;
				if ($a['inline']) {
					$popup_id = $a['inline'];
					$open_popup_div = '<div class="wppb-popup-main-wrap inline_ inline-popup active">'; 
				}elseif ($a['popup']) {
					$popupInline = false;
					$popup_id = $a['popup'];	
					$open_popup_div = '<div class="wppb-popup-open popup active">'; 
				}elseif ($a['widget']) {
					$popup_id = $a['widget'];	
					$open_popup_div = '<div class="wppb-popup-main-wrap inline_ widget-popup active">'; 
				}
				if ($popup_id) {
					$return_Html = wppb_db::Popup_show($popup_id);
					if ( isset($return_Html->setting) ) {
							$popupHtml = new wppb_db();
		 					$popupHtmlContent = $popupHtml->wppb_html( $return_Html->setting,$popupInline );
							return $popupHtmlContent && $return_Html ? $open_popup_div.$popupHtmlContent.'</div>':'';
					}
				}
	}
// class end
}
