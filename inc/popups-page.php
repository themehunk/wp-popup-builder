<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
	$custom_popup_all = wppb_db::getCustomPopup();
	$popup_html_all_custom = '';
	$column_making = 0;
	if (!empty($custom_popup_all)) {
			foreach ($custom_popup_all as $popupKey => $popupValue) {
					
					$popupSetData = array(
						'wrapper-style'=>'width:unset;',
						'wrapper-height'=>'auto',
						'overlay-image-url'=>'',
						'overlay-style'=>"",
						'overlay-color'=>'#28292C91',
						'outside-color'=>'#cdcbcb',
						'content' => '',
						'global_content'=>'',
						'global-padding'=>'23px 37px',
						'layout' => '',
						'close-btn' => '',
						'popup-name' => 'New Popup'
						);

					$allSetting = unserialize($popupValue->setting);
					$popup_is_active = $popupValue->is_active?"checked='checked'":"";

		// print_r($popupValue);

					foreach ($allSetting as $setting_value) {
						if (isset($setting_value['content']) && is_array($setting_value['content'])) {
							if ($setting_value['type'] == 'global-setting') {
									foreach ($setting_value['content'] as $contentkey_ => $contentvalue_) {
										if(isset($popupSetData[$contentkey_]) )$popupSetData[$contentkey_] = $contentvalue_;
									}
							}if ($setting_value['type'] == 'wrap' ) {
								$popupSetData['content'] =	'<div data-rl-wrap="" class="wppb-popup-rl-wrap rl-clear">'.$wp_builder_obj->initColumn($setting_value['content']).'</div>';
							}
						}
					}
					$column_making++;
					$business_id 	   = isset($popupValue->BID)?$popupValue->BID:"";
					if ($column_making == 1) $popup_html_all_custom .= '<div class="wppb-popup-row wppb-popup_clear">';

					$popup_html_all_custom .= '<div class="wppb-popup-column-three">
												<div class="wppb-popup-demo">
													<div class="tempIdShow">'.$popupSetData['popup-name'].'</div>
													<div class="wppb-popup-demo-wrapper">'.$wp_builder_obj->popup_layout($popupSetData).'</div>
													<div class="wppb-popup-demo-settings">
														<div class="wppb-popup-setting-btns">
															
															<div class="wppb-popup-checkbox">
																<input id="business_popup--'.$business_id.'" type="checkbox" class="wppb_popup_setting_active" data-bid="'.$business_id.'" '.$popup_is_active.'>
																<label for="business_popup--'.$business_id.'"></label>
															</div>
															<a class="wppb-popup-setting can_disable" href="'.esc_url(WPPB_PAGE_URL.'&custom-popup='.$business_id).'">'.__("<span class='dashicons dashicons-admin-generic'></span> Settings","wppb").'</a>

														</div>
													</div>

												</div>
										</div>';

					if(count($custom_popup_all) == ($column_making)){
						$popup_html_all_custom .= '</div>';
					}elseif(($column_making) % 3 === 0){
						$popup_html_all_custom .= '</div><div class="wppb-popup-row wppb-popup_clear">';
					}			
			}
	}
// echo "</pre>";

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












