<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 

class wppb_load{
	private function __construct(){	
			if ( isset($_GET['wppb_preview']) ) {
				add_action( 'wp_footer', array($this,'preview_footer') );
			}else{
				add_action( 'wp_footer', array($this,'footer_load') );
			}	
	}
	public static function get(){
		return new self();
	}

	public function preview_footer(){
		if ( isset($_GET['wppb_preview']) && $_GET['wppb_preview'] && is_numeric($_GET['wppb_preview']) ) {
					$popupId = intval( $_GET['wppb_preview'] );
					$return_Html = wppb_db::Popup_show($popupId, true);
					if ( isset($return_Html->setting) ) {
						$popupHtml = new wppb_db();
						$popupHtmlContent = $popupHtml->wppb_html( $return_Html->setting );
						echo $popupHtmlContent && $return_Html ? '<div data-option="1" class="wppb-popup-open popup active">'.$popupHtmlContent.'</div>':'';
					}
		}
	}

	public  function footer_load(){
	 		$return_Html = wppb_db::popup_pages();
	 		if ( !empty($return_Html) ) {
 				// $popupInitObj = new wp_popup_builder_init();
	 			foreach ($return_Html as $value) {
 					if ( isset($value->boption) && isset($value->setting) && @unserialize($value->boption) ) {
 						$popupData = $this->show_popup_part_start($value);
 						if ( $popupData ) echo $popupData;
 					}
	 			}
	 		}
 	}
 	public function show_popup_part_start($value, $shortcode=false){
 				$return_data = false;
 				$option = unserialize($value->boption); 
				$device = isset( $option['device'] ) ? $option['device'] : false;
				$checkMobile = wp_is_mobile();
				// if ( $device == 'mobile' && $checkMobile ) { //desktop condition
				if ( ($device == 'mobile' || isset($option['mobile-enable']) ) && $checkMobile ) { //desktop condition and also for previous user
					$return_data = true;
				}else if( $device == 'desktop' && !$checkMobile ){ //mobile condition
					$return_data =  true;
				}else if ( $device == 'all' || $device == false ) { //all and if not device set
					$return_data =  true;
				}
				return $return_data ? $this->show_popup_part_one( $value,$option,$shortcode ):false;
 	}

 	public function show_popup_part_one($value,$option,$shortcode){
 			$return_ = false;
			$placement = isset($option['placement']) ? $option['placement'] : false;
			// if ( $placement == 'all' ) {//new user
			if ( $placement == 'all' || (isset($option['all']) && $option['all']) ) {
				$return_ = true;
			// }else if ( $placement == 'home_page' && is_front_page() ) { for new update
			}else if ( ( $placement == 'home_page' && is_front_page() ) || (isset($option['home_page']) && $option['home_page'])) {
				$return_ = true;
			}else{
				// for all page or selected pages
				$checkPostType = get_post_type();
					// if ( $checkPostType == 'page' && isset($placement['pages']) && $placement['pages'] == 'all' ) {
					if ( ($checkPostType == 'page' && isset($placement['pages']) && $placement['pages'] == 'all') || (isset($option['pages']) && $option['pages']) ) {
						$return_ = true; 
					// }else if( $checkPostType == 'post' && isset($placement['post']) && $placement['post'] == 'all' ){
					}else if( ($checkPostType == 'post' && isset($placement['post']) && $placement['post'] == 'all') || (isset($option['post']) && $option['post']) ){
						$return_ = true; 
					}else if(isset($placement['woocommerce']) && $placement['woocommerce'] == 'all'){
						$return_ = true; 
					}
			}
			if ( $shortcode || $return_ ) {
				$popupHtml = new wppb_db();
				$popupHtmlContent = $popupHtml->wppb_html($value->setting);
				$showPopup = $popupHtmlContent ? '<div data-option="1" class="wppb-popup-open popup active">'.$popupHtmlContent.'</div>': '';
				if($showPopup) return $showPopup;
			}
 	}



// class end
}
