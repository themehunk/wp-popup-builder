<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
	$custom_popup_all = wppb_db::getCustomPopup();
	$popup_html_all_custom = '';
	$column_making = 0;

if (!empty($custom_popup_all)) {
	foreach ($custom_popup_all as $popupValue) {
		$allSetting = unserialize($popupValue->setting);
		$column_making++;
		$business_id 	   		= isset($popupValue->BID)?$popupValue->BID:"";
		$customPopupCount 		= count($custom_popup_all);
		$popup_html_all_custom .= $wp_builder_obj->wppbPopupList( $allSetting,$column_making,$business_id,$customPopupCount,$popupValue->is_active );			
	}
}

?>

<div id="wppb-popup-demos-container">

<section id="wppb-custom-popup-section" class="wppb-custom-popup-section">
		<div class="wppb-custom-popup-heading">
			<h1>Business Popup List </h1>
			<a href="<?php echo esc_url(WPPB_PAGE_URL.'&custom-popup') ?>"> <span class="dashicons dashicons-edit"></span> Add New Popup</a>
		</div>
		<?php echo $popup_html_all_custom ?>
</section>

</div>












