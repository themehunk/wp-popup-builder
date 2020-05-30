<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
class wp_popup_builder_init{

function initColumn($column){
			$popupColumn = '';
			foreach ($column as $value) {
					$uniqIdAttr = isset($value["id"])?'data-uniqid="'.$value["id"].'"':'';
					$style = isset($value["style"])?'style="'.$value["style"].'"':'';
					$popupValueContent = isset($value['content']) && is_array($value['content']) && !empty($value['content']) ?$this->initContent($value['content']):'';
					$popupColumn .= '<div '.$uniqIdAttr.' data-rl-column="1" class="wppb-popup-rl-column rlEditorDropable" '.$style.'>'.$popupValueContent.'</div>';
			}
			return $popupColumn;
}

function initContent($column_content){
				$popupContent = '';
				foreach ($column_content as $setting_value) {
				$Style = isset($setting_value['style'])?'style="'.$setting_value['style'].'"':'';
				$alignMent = isset($setting_value['alignment'])?'style="justify-content:'.$setting_value['alignment'].';"':'';
				$alignMentContent = $alignMent?'data-content-alignment="'.$setting_value['alignment'].'"':'';
				$dataLink = isset($setting_value['link'])?"data-editor-link='".$setting_value['link']."'":'';
				$dataLinktarget = isset($setting_value['target'])?"data-editor-link-target='".$setting_value['target']."'":'';
				$uniqIdAttr = isset($setting_value["id"])?'data-uniqid="'.$setting_value["id"].'"':'';
				$contentAttr = $Style.$alignMentContent.$dataLink.$dataLinktarget.$uniqIdAttr;
				if ($setting_value['type'] == 'text') {
					$popupContent .=	'<div class="data-rl-editable-wrap" '.$alignMent.'>
									<div class="actions_">
									<span class="dashicons dashicons-no rlRemoveElement"></span></div>
									<span data-rl-editable="text" '.$contentAttr.'>'.$setting_value['content'].'</span>
								</div>';
				}elseif ($setting_value['type'] == 'heading') {
				$popupContent .=	'<div class="data-rl-editable-wrap" '.$alignMent.'>
									<div class="actions_">
									<span class="dashicons dashicons-no rlRemoveElement"></span></div>
									<span class="text-heading" data-rl-editable="heading" '.$contentAttr.'>'.$setting_value['content'].'</span>
								</div>';
				}elseif ($setting_value['type'] == 'image') {
				
				$popupContent .= '<div class="data-rl-editable-wrap wrap-image_" '.$alignMent.'>
												<div class="actions_">
												<span class="dashicons dashicons-no rlRemoveElement"></span>
											 </div>
											 <img src="'.$setting_value['image-url'].'"  '.$contentAttr.' data-rl-editable="image">
											</div>';
				}elseif ($setting_value['type'] == 'link') {
				$popupContent .=	'<div class="data-rl-editable-wrap" '.$alignMent.'>
									<div class="actions_">
									<span class="dashicons dashicons-no rlRemoveElement"></span></div>
									<span data-rl-editable="link" '.$contentAttr.'>'.$setting_value['content'].'</span>
								</div>';
				}elseif ( $setting_value['type'] == 'lead-form' && ( isset($setting_value['content']) && is_numeric($setting_value['content']) ) ) {
				  	$formStyles = '';
					if ( isset($setting_value['styles']) ) {
				  		$formStyles = htmlspecialchars( json_encode($setting_value['styles']), ENT_COMPAT );
				  		$formStyles = 'data-form-styles="'.$formStyles.'"';
					}

                    $submitAlign = '';
                    if (isset($setting_value['styles']['submit-align'])) {
                      $submitAlign = 'lf_submit_'.$setting_value['styles']['submit-align'];
                    }
              		$popupContent .= '<div class="data-rl-editable-wrap" '.$alignMent.'>
								<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>
								<div class="wppb-popup-lead-form '.$submitAlign.'" '.$uniqIdAttr.' data-form-id="'.$setting_value['content'].'" '.$formStyles.'>
									'.wppb_db::lead_form_front_end()->lfb_show_front_end_forms($setting_value['content']).'
									</div>
									</div>';
                }
			}
		return $popupContent;
	}

	function popup_layout($popupSetData,$layout=''){
			$overlay_image = $popupSetData['overlay-image-url']?'background-image:url('.$popupSetData['overlay-image-url'].');':'';
			$overlayStyle = $overlay_image?$overlay_image.$popupSetData['overlay-style']:'';

			$globalHeight = $popupSetData["wrapper-height"] != 'auto'?$popupSetData["wrapper-height"].'px;':$popupSetData["wrapper-height"].';';
			$globalStyle = "padding:".$popupSetData["global-padding"].";height:".$globalHeight;

			$return = $popupSetData["close-btn"].'<div class="wppb-popup-custom-wrapper" style="'.$popupSetData["wrapper-style"].'">
			         <div class="wppb-popup-overlay-custom-img" data-overlay-image="'.$popupSetData['overlay-image-url'].'" style="'.$overlayStyle.'"></div>
			          <div class="wppb-popup-custom-overlay" style="background-color:'.$popupSetData['overlay-color'].';"></div>
			              <div class="wppb-popup-custom-content" style="'.$globalStyle.'">
				            '.$popupSetData["content"].'
			              </div>
			        </div>';
			return $return;
	}

// popup page list of all popupSetData content
public function wppbPopupContent($allSetting){
			$popupSetData = array( 
				'wrapper-style'		=>'',
				'wrapper-height'	=>'auto',
				'overlay-image-url' =>'',
				'overlay-style'		=>"",
				'overlay-color'		=>'#28292C91',
				'outside-color'		=>'#cdcbcb',
				'content' 			=> '',
				'global-padding'	=>'23px 37px',
				'layout' 			=> '',
				'close-btn' 		=> '',
				'popup-name' 		=> 'New Popup name'
			);
		foreach ($allSetting as $setting_value) {
			if (isset($setting_value['content']) && is_array($setting_value['content'])) {
				if ($setting_value['type'] == 'global-setting') {
						foreach ($setting_value['content'] as $contentkey_ => $contentvalue_) {
							if(isset($popupSetData[$contentkey_]) )$popupSetData[$contentkey_] = $contentvalue_;
						}
				}elseif ($setting_value['type'] == 'wrap' ) {
					$popupContentColumn = $this->initColumn($setting_value['content']);
					$popupSetData['content'] =	'<div data-rl-wrap="" class="wppb-popup-rl-wrap rl-clear">'.$popupContentColumn.'</div>';
				}
			}else if ($setting_value['type'] == "close-btn") {
					$uniqIdAttr = isset($setting_value["id"])?'data-uniqid="'.$setting_value["id"].'"':'';
					$styleClose = isset( $setting_value['style'] )?"style='".$setting_value['style']."'":'';
					$popupSetData["close-btn"] ='<span '.$uniqIdAttr.' class="wppb-popup-close-btn dashicons dashicons-no-alt" '.$styleClose.'></span>';
					
				}
		}
		return $popupSetData;
}
// popup page list of all popupSetData
public function wppbPopupList($allSetting,$column_making,$business_id,$countPopup,$isActive=false){
		$popupSetData = $this->wppbPopupContent($allSetting);
		$returnHtml = '';
		$popup_is_active = $isActive?"checked='checked'":"";
		$business_id 	   = $business_id?$business_id:"";
		if ($column_making == 1) $returnHtml .= '<div class="wppb-popup-row wppb-popup_clear">';
		$returnHtml .= '<div class="wppb-popup-column-three">
									<div class="wppb-popup-demo">
										<div class="tempIdShow">'.$popupSetData['popup-name'].'</div>
										<div class="wppb-popup-demo-wrapper">'.$this->popup_layout($popupSetData).'</div>
										<div class="wppb-popup-demo-settings">
											<div class="wppb-popup-setting-btns">
												<div class="wppb-popup-checkbox">
													<input id="business_popup--'.$business_id.'" type="checkbox" class="wppb_popup_setting_active" data-bid="'.$business_id.'" '.$popup_is_active.'>
													<label for="business_popup--'.$business_id.'"></label>
												</div>
												<a class="wppb-popup-setting can_disable" href="'.esc_url(WPPB_PAGE_URL.'&custom-popup='.$business_id).'"><span class="dashicons dashicons-admin-generic"></span> '.__("Settings","wppb").'</a>

											</div>
										</div>
									</div>
							</div>';
		if($countPopup == ($column_making)){
			$returnHtml .= '</div>';
		}elseif(($column_making) % 3 === 0){
			$returnHtml .= '</div><div class="wppb-popup-row wppb-popup_clear">';
		}
		return $returnHtml;
}

// popup page list of all popupSetData json file
public function wppbPopupList_json($allSetting,$column_making,$countPopup){
		$popupSetData = $this->wppbPopupContent($allSetting);
		$LayOutName = isset($popupSetData['layout']) && $popupSetData['layout'] ? 'data-layout="'.$popupSetData['layout'].'"' : '';
		$returnHtml = '';
		if ($column_making == 1) $returnHtml .= '<div class="wppb-popup-row wppb-popup_clear">';
		$returnHtml .= '<div class="wppb-popup-column-three">
								<input id="wppb-popup-layout-label__layout--'.$column_making.'" type="radio" name="wppb-popup-layout" value="prebuilt" '.$LayOutName.'>
								<label for="wppb-popup-layout-label__layout--'.$column_making.'" class="wppb-popup-json-label">'.$this->popup_layout($popupSetData).'</label>
						</div>';
		if($countPopup == ($column_making)){
			$returnHtml .= '</div>';
		}elseif(($column_making) % 3 === 0){
			$returnHtml .= '</div><div class="wppb-popup-row wppb-popup_clear">';
		}
		return $returnHtml;
}





// builder internal tools function
	public function header_title($title){
		echo '<div class="rl_i_editor-header-title">
						<label>'.$title.'</label>
					</div>';
	}
	public function color($title,$prop,$type,$color_id=1,$attr=''){
		if ($title && $prop && $type) {
			$typeAndProp = $type.'="'.$prop.'"' . $attr;
			echo '<div class="rl_i_editor-item-content-items item-text inline__"><label class="rl-sub-title">'.$title.'</label>
					<div>
						<label class="color-output" data-input-color="'.$color_id.'" '.$typeAndProp.'></label>
					</div>
				</div>';
		}
	}

	public function range_slider($title, $id, $arr, $id_two=false, $type_ = "data-global-input"){
 			$title_ = isset( $arr['title'] ) ? $arr['title'] : ''; 
 			$attr  = isset( $arr['min'] ) ?'min="'.$arr['min'].'"': ''; 
 			$attr .= isset( $arr['max'] ) ?'max="'.$arr['max'].'"': ''; 
 			$attr .= isset( $arr['value'] ) ?'value="'.$arr['value'].'"': '';
 			$attr .= $attrTwo = isset( $arr['attr'] ) ? $arr['attr'] : '';
 			$id_two = !$id_two ? $id : $id_two;

 			$attr .=  $type_.'="'.$id.'"';
 			$container = isset( $arr['container-class'] ) ? $arr['container-class'] : '';
		 	echo '<div  class="rl_i_editor-item-content-items  '.$container.' title_ inline__">
						<div class="rl_i_range-font-size"><label class="rl-sub-title">'.$title.'</label></div>
					</div>
					<div  class="rl_i_editor-item-content-items inline__ '.$container.'">
						<div class="range_ rl_i_range-font-size">
							<input data-show-range="'.$id_two.'" type="range" '.$attr.'>
						</div>
						<div class="data-range-output">
							<input type="number" data-range-output="'.$id_two.'" '.$attrTwo.'>
							<label class="param-title rl-sub-title">'.$title_.'</label>
						</div>
					</div>';
		 }
	public function select($attr,$option){
			$return = "<select ".$attr.">";
			if ( is_array($option) ) {
				foreach ($option as $value) {
						if ( isset($value[0]) && isset($value[1]) ) {
							$selected = isset($value[2]) ? 'selected="selected"':'';
							$return	.= "<option value='".$value[1]."' ".$selected.">".$value[0]."</option>";
						}
					}	
				}	
			$return	.= "</select>";
			return $return;
		}
	public function checkbox($id,$title,$attr){
			return '<div  class="rl_i_editor-item-content-items title_ inline__">
			<div class="rl_i_range-font-size">
					<div class="wppb-popup-checkbox-container">
						<label class="wppb-popup-checkbox-title rl-sub-title">'.$title.'</label>
						<div class="wppb-popup-checkbox">
							<input id="wppb_popup__checkbox__label_id-'.$id.'" type="checkbox" '.$attr.'>
							<label for="wppb_popup__checkbox__label_id-'.$id.'"></label>
						</div>
					</div>
				</div>
				</div>';
		}
	public function border($id,$type,$attr = ''){
		$data_attr = $type.'="'.$id.'"' . $attr;
		$border = $this->select($data_attr.' data-border="border-style"',[ ['solid','solid'],['dashed','dashed'],['dotted','dotted'],['double','double'],['groove','groove'],['ridge','ridge'] ]);
				$return =  '<section class="content-style-border">
						'.$this->checkbox($id,"Border",$data_attr.' data-border="border-enable"').'
					<div  class="rl_i_editor-item-content-items content-border">
						<div>
							<label class="rl-sub-title">'.__('Border Width','wppb').'</label>
							<div><input type="number" value="" '.$data_attr.' data-border="width"></div>
						</div>
						<div>
							<label class="rl-sub-title">'.__('Border radius','wppb').'</label>
							<div><input type="number" value="" '.$data_attr.' data-border="radius"></div>
						</div>
						<div>
							<label class="rl-sub-title">'.__('Border Color','wppb').'</label>
							<div><label class="color-output" '.$data_attr.' data-input-color="border-color"></label></div>
						</div>
						<div>
							<label class="rl-sub-title">'.__('Border Style','wppb').'</label>
							<div>'.$border.'</div>
						</div>
					</div>
				</section>';
				echo $return;
	}

	public function margin_padding($id,$title,$type,$margin_padding,$attr=''){
		$attr = $type."='".$id."'" .$attr;
		$parameter = $margin_padding == "m" ? 'margin' : 'padding';
		$return = '<div class="rl_i_editor-item-content-items title_ inline_">
		<div class="rl_i_range-font-size"><label class="rl-sub-title">'.$title.'</label></div>
		</div>
			<div class="rl_i_editor-item-content-items inline_">
				<div class="rl_i_editor-item-content-padding_ paraMeterContainer__">
					<ul class="ul-inputs-margin-padding rl-clear">
						<li>
							<input type="number" value="" '.$attr.' data-'.$parameter.'="top">
						</li>
						<li>
							<input type="number" value="" '.$attr.' data-'.$parameter.'="right">
						</li>
						<li>
							<input type="number" value="" '.$attr.' data-'.$parameter.'="bottom">
						</li>
						<li>
							<input type="number" value="" '.$attr.' data-'.$parameter.'="left">
						</li>
						<li class="padding-origin_ margin-padding-origin">
							<input id="m__p_origin-'.$parameter.'-'.$id.'" type="checkbox" '.$attr.' data-origin="'.$parameter.'">
							<label for="m__p_origin-'.$parameter.'-'.$id.'"><span class="dashicons dashicons-admin-links"></span></label>
						</li>
					</ul>							
					<ul class="ul-inputs-text rl-clear">
						<li>'.__('TOP','wppb').'</li>
						<li>'.__('RIGHT','wppb').'</li>
						<li>'.__('BOTTOM','wppb').'</li>
						<li>'.__('LEFT','wppb').'</li>
						<li></li>
					</ul>
				</div>
			</div>';
			echo $return;
		}

		public function alignment($title,$id,$type,$attr=''){
				$attr_ = $type."='".$id."'" . $attr;
				$return = '<div class="rl_i_editor-item-content-items item-alignment_ inline__">
				<label class="rl-sub-title">'.$title.'</label>
				<div class="rl_text-alignment">
					<ul class="text-alignment-choice">
						<li>
							<input id="_alignment_label_'.$id.'_left" '.$attr_.' type="radio" name="'.$id.'" value="left">
							<label for="_alignment_label_'.$id.'_left" class="dashicons dashicons-editor-alignleft"></label>
						</li>
						<li>
							<input id="_alignment_label_'.$id.'_center" '.$attr_.' type="radio" name="'.$id.'" value="center">
							<label for="_alignment_label_'.$id.'_center" class="dashicons dashicons-editor-aligncenter"></label>
						</li>
						<li>
							<input id="_alignment_label_'.$id.'_right" '.$attr_.' type="radio" name="'.$id.'" value="right">
							<label for="_alignment_label_'.$id.'_right" class="dashicons dashicons-editor-alignright"></label>
						</li>
					</ul>
				</div>
			</div>';
			return $return;
		}

// class end
}

$wp_builder_obj = new wp_popup_builder_init();










?>
