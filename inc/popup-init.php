<?php if ( ! defined( 'ABSPATH' ) ) exit;
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
				}elseif ( $setting_value['type'] == 'lead-form' && is_numeric($setting_value['content']) ) {
                  $popupContent .= '<div class="data-rl-editable-wrap" '.$alignMent.'>
									<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>
									<div class="wppb-popup-lead-form" data-form-id="'.$setting_value['content'].'">
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

		$return = '<div class="wppb-popup-custom-wrapper" style="width:'.$popupSetData["wrapper-width"].'px;">
		         <div class="wppb-popup-overlay-custom-img" data-overlay-image="'.$popupSetData['overlay-image-url'].'" style="'.$overlayStyle.'"></div>
		          <div class="wppb-popup-custom-overlay" style="background-color:'.$popupSetData['overlay-color'].';"></div>
		              <div class="wppb-popup-custom-content" style="'.$globalStyle.'">
			            '.$popupSetData["close-btn"].$popupSetData["content"].'
		              </div>
		        </div>';
		return $return;
}


	public function color($title,$prop,$type,$color_id=1){
		if ($title && $prop && $type) {
			$typeAndProp = $type.'="'.$prop.'"';
			return '<div class="rl_i_editor-item-content-items item-text inline__"><label>'.$title.'</label>
					<div class="rl_i_editor-item-color">
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
		 	return '<div  class="rl_i_editor-item-content-items  '.$container.' title_ inline__">
						<div class="rl_i_range-font-size"><label>'.$title.'</label></div>
					</div>
					<div  class="rl_i_editor-item-content-items inline__ '.$container.'">
						<div class="rl_i_range-font-size">
							<input data-show-range="'.$id_two.'" type="range" '.$attr.'>
						</div>
						<div class="data-range-output">
							<input type="number" data-range-output="'.$id_two.'" '.$attrTwo.'>
						</div>
						<label class="param-title">'.$title_.'</label>
					</div>';
		 }
	public function select($attr,$option){
			$return = "<select ".$attr.">";
			if ( is_array($option) ) {
				foreach ($option as $value) {
						if ( isset($value[0]) && isset($value[1]) ) {
							$return	.= "<option value='".$value[1]."'>".$value[0]."</option>";
						}
					}	
				}	
			$return	.= "</select>";
			return $return;
		}

// class end
}

$wp_builder_obj = new wp_popup_builder_init();










?>
