<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
	$custom_popup_all = wppb_db::getCustomPopup();
	$popup_html_all_custom = '';
if (!empty($custom_popup_all)) {
	foreach ($custom_popup_all as $popupValue) {
		$allSetting = unserialize($popupValue->setting);
		$business_id 	   		= isset($popupValue->BID)?$popupValue->BID:"";
		if ($popupValue->boption != '') {
			$bOption = unserialize( $popupValue->boption );
		}
		$device = isset($bOption['device']) ? $bOption['device'] : false;
		$popup_html_all_custom .= $wp_builder_obj->wppbPopupList( $allSetting,$business_id,$popupValue->is_active, $device);			
	}
}
?>
<div id="wppb-popup-demos-container">
	<div class="resetConfirmPopup">
		<div class="reserConfirm_inner">
			<div class="resetWrapper">
				<div class="resetHeader">
					<span><?php _e('Popup Will Delete Permanentally.','wppb') ?></span>
				</div>
				<div class="resetFooter">
					<a class="wppbPopup popup deny" href="#"><span class="dashicons dashicons-dismiss"></span><?php _e('No','wppb') ?></a>
					<a class="wppbPopup popup confirm" href="#"><span class="dashicons dashicons-yes-alt"></span><?php _e('Yes','wppb') ?></a>
				</div>
			</div>
		</div>
	</div>

<section id="wppb-custom-popup-section" class="wppb-custom-popup-section">
	<a target="_blank" href="https://themehunk.com/wp-popup-builder-pro/" class="buypro-wpbp">Buy Pro</a>
		<div class="wppb-custom-popup-heading">
			<h1><?php _e('WP Builder Popup','wppb'); ?></h1>
			<a href="<?php echo esc_url(WPPB_PAGE_URL.'&custom-popup','wppb') ?>"> <span class="dashicons dashicons-edit"></span> <?php _e('Add New Popup','wppb'); ?></a>
		</div>
		<?php if($popup_html_all_custom != ''){ ?>
			<div class="wppb-custom-popup-head rl-clear">
				<div class="wppb-popup-list-title"><span>Title</span></div>
				<div class="wppb-popup-list-enable"><span>Status</span></div>
				<div class="wppb-popup-list-mobile"><span>Device</span></div>
				<div class="wppb-popup-list-view"><span>View</span></div>
				<div class="wppb-popup-list-action"><span>Action</span></div>
				<div class="wppb-popup-list-setting"><span>Setting</span></div>
			</div>
			<div class="wppb-custom-popup-list">
				<?php echo $popup_html_all_custom ?>
			</div>
		<?php } ?>
</section>

</div>












