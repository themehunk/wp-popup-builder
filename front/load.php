<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 

class wppb_load{
	private function __construct(){		
			add_action( 'wp_footer', array($this,'footer_load') );
	}
	public static function get(){
		return new self();
	}
	public  function footer_load(){
 		$return_Html = wppb_db::popup_pages();

 		if ( !empty($return_Html) ) {
 			foreach ($return_Html as $key => $value) {

 					if ( isset($value->boption) && isset($value->setting) && @unserialize($value->boption) ) {
	 					$option = unserialize($value->boption); 
	 					$popupHtml = new wppb_db();
	 					$popupHtmlContent = $popupHtml->wppb_html($value->setting);
	 						// for all page setting
	 						if ($popupHtmlContent) {
	 							if (isset($option['pages']) && $option['pages'] && get_post_type() === 'page') {
				 						echo '<div data-option="1" class="wppb-popup-open popup active">'.$popupHtmlContent.'</div>';
				 					}else if (isset($option['post']) && $option['post'] && get_post_type() === 'post') {
				 						echo '<div data-option="1" class="wppb-popup-open popup active">'.$popupHtmlContent.'</div>';
				 					}else if (isset($option['home_page']) && $option['home_page']  && is_front_page()) {
				 					echo '<div data-option="1" class="wppb-popup-open popup active">'.$popupHtmlContent.'</div>';
				 					}
	 						}
		 					 	
	 					}
 			}
 		}
 	}
// class end
}
