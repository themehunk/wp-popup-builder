
<?php if ( ! defined( 'ABSPATH' ) ) exit; 

if ( ! class_exists( 'wppb_db' ) ) return;

// if(!class_exists( 'LFB_SAVE_DB' )) require_once(LFB_PLUGIN_PATH.'inc/front-end.php');

class wppb_db{
  private static $db;
  private static $table;
  private static $lfb_table;
  function __construct(){
    global $wpdb;
    self::$db = $wpdb;
    self::$table = self::$db->prefix.'wppb';
    self::$lfb_table = self::$db->prefix.'lead_form';
  }
public static function getCustomPopup($bid=""){
  if ($bid && is_numeric($bid)) {
    $querystr = "SELECT * FROM ".self::$table." WHERE addon_name='custom_popup' AND BID='".$bid."'";
  }else if($bid == ''){
    $querystr = "SELECT * FROM ".self::$table." WHERE addon_name='custom_popup' ORDER BY BID DESC";
  }
    $pageposts = isset($querystr)?self::$db->get_results($querystr):'';
    return !empty($pageposts)?$pageposts:false; 
}


public function popup_insert(){
if (isset($_POST['htmldata'])) {    
      $popupData = $this->arrayValueSanetize( $_POST['htmldata'] );
      if ($popupData) {
          $data['setting']  = serialize($popupData);
          $data['addon_name'] = 'custom_popup';
          $data_formate = ['%s','%s'];
          self::$db->insert(self::$table,$data, $data_formate);
          return self::$db->insert_id;
      }
    }
}
public function popup_update(){
  // print_r($_POST);
  // for html data update
      if (isset($_POST['bid']) && is_numeric($_POST['bid']) && isset($_POST['htmldata'])) {
          $popupData = $this->arrayValueSanetize($_POST['htmldata']);
          if ($popupData) {
              $data['setting']  = serialize($popupData);
              $formate_data     = ['%s'];
              $where = ['BID'=>$_POST['bid']];
              $formate_data_where =  ['%d'];
              return self::$db->update( self::$table, $data , $where, $formate_data, $formate_data_where); 
          }
      }elseif ( isset($_POST['popup_id']) && is_numeric($_POST['popup_id']) && isset($_POST['is_active']) && is_numeric($_POST['is_active']) ) {
  // for popup active and deactivate update
              $data['is_active']  = $_POST['is_active'];
              $formate_data     = ['%d'];
              $where = ['BID'=>$_POST['popup_id']];
              $formate_data_where =  ['%d'];
              return self::$db->update( self::$table, $data , $where, $formate_data, $formate_data_where); 
      }

}

public function popup_delete(){

    if ( isset($_POST['bid']) && is_numeric($_POST['bid']) ) {
          return self::$db->delete( self::$table , ['BID'=>$_POST['bid']], ['%d']);
      }

}

 //business popup update
  public function opt_update(){

    if (isset($_POST['popup_id']) && isset($_POST['option_key']) && isset($_POST['option_value']) && is_numeric($_POST['popup_id'])) {
          
          $bid     = intval($_POST['popup_id']);
          $option_name = sanitize_text_field($_POST['option_key']);
          $option_value= sanitize_text_field($_POST['option_value']);
          $exist_Addon = self::$db->get_row("SELECT boption FROM ".self::$table." WHERE BID='".$bid."'");

          if(isset($exist_Addon->boption)){
            if ($exist_Addon->boption == '') {
              $option = [$option_name => $option_value];
            }elseif ($exist_Addon->boption != '') {
              $option = unserialize($exist_Addon->boption);
              $option[$option_name] = $option_value;
            }
              $data['boption'] = serialize($option);
              $result = self::$db->update( self::$table,$data , ['BID'=>$bid], ['%s'], ['%d']);
                if ($option_value) {
                    $already_on = $this->chekPopupStatus($option_name);
                    $result = $already_on?22:$result;
                }
              return $result;
          }
      }
  }

 // check that popup on or off on pages,post, and home page
  private function chekPopupStatus($option_name){
          $return_Html = self::popup_pages();
          $findAlready = 0;
          if (!empty($return_Html)) {
            foreach ($return_Html as $value) {
                  $option = unserialize($value->boption); 
                  if (isset($option[$option_name]) && $option[$option_name]) {
                      if($findAlready >= 2)break;
                      $findAlready++;     
                  }    
            }
          }
          return $findAlready >= 2?true:false;
  }
  //get popup for all pages,pages,post
  public static function popup_pages(){
    $querystr = "SELECT setting,boption FROM ".self::$table." WHERE setting !='' AND boption!='' AND is_active = 1";
    $pageposts = self::$db->get_results($querystr);
    return !empty($pageposts)?$pageposts:false; 
  }

//get for addon for update 
  public static function Popup_show($bid){
    if ($bid && is_numeric($bid)) {
      return  self::$db->get_row("SELECT setting FROM ".self::$table." WHERE BID='".$bid."' AND is_active='1'");
    } 
  }

public function arrayValueSanetize($arr){
  $returnArray = [];
  if ( is_array($arr) ) {

        $arr = $this->uniq_class($arr);

        foreach($arr as $key => $value){
          $key = is_numeric($key)?$key:sanitize_text_field($key);
          if(is_array($value)){
              $returnArray[$key] = $this->arrayValueSanetize($value);
          }else{
              if ($key == "link" || $key == "image-url" || $key == 'overlay-image-url') {
                    // senetize link 
                    $value = esc_url($value);
              }else if($key == "style" || $key == "overlay-style"){
                // senetize style 
                $value = wp_kses_post($value);
              }else{          
                // senetize text and normal text
                $value = sanitize_text_field($value);
              }
            $returnArray[$key] = $value;
          } //else

        } //foreach
  }
  return !empty($returnArray)?$returnArray:false;
}

public function uniq_class($arr){
  if( ( (isset($arr['type']) && isset($arr['content'])) || ( isset($arr['type']) && $arr['type'] == 'close-btn' ) ) && !isset($arr['id']) ){
        $uniqid = !is_array($arr['type']) ? uniqid( 'wppb-'.$arr['type'].'-', true) : uniqid( 'wppb-content-', true);
        $uniqid = str_replace('.', '', $uniqid);
        $arr = array_merge($arr,['id'=>$uniqid]);
    }
    return $arr;
}

// popup html creating
public function wppb_html($setting,$inline=false){
// echo "<pre>";
    if ($setting && @unserialize( $setting )) {
        $popupSetData = array(
          'wrapper-style'=>'width:550px;',
          'wrapper-height'=>'auto',
          'overlay-image-url'=>'',
          'overlay-style'=>"",
          'overlay-color'=>'#28292C91',
          'outside-color'=>'#535353F2',
          'content' => '',
          'global-padding'=>'23px 37px',
          'layout' => '',
          'close-btn'=>'',
          'style'=>'',
          'lead-form' => ''
          );
      $popupFrontSetting = ['close-type'=>3,'outside-color'=>'#535353F2','effect'=>1,'popup-delay-open'=>3,'popup-delay-close'=>0];
      $allSetting = unserialize($setting);   
      
      // print_r($allSetting);

        foreach ($allSetting as $setting_value) {
          if (isset($setting_value['content']) && is_array($setting_value['content'])) {
            if ($setting_value['type'] == 'global-setting') {
                foreach ($setting_value['content'] as $contentkey_ => $contentvalue_) {
                  $popupSetData[$contentkey_] = $contentvalue_;
                  if (isset($popupFrontSetting[$contentkey_]))$popupFrontSetting[$contentkey_] = $contentvalue_;
                }
            }elseif ($setting_value['type'] == 'wrap' ) {
              $data_layout = $popupSetData['layout'] == 'layout-3' || $popupSetData['layout'] == 'layout-2'?'two-column':'';
              $Wrap_uniq_id = isset( $setting_value['id'] ) ? $setting_value['id'] : '';
              $popupColumnContent = $this->wppb_initColumn($setting_value['content'],$Wrap_uniq_id);
              $popupSetData["content"] .= '<div id="'.$Wrap_uniq_id.'" class="'.$data_layout.' wppb-popup-rl-wrap rl-clear">'.$popupColumnContent['content'].'</div>';
              $popupSetData["style"] .= $popupColumnContent['style'];
            }
          }else if ($setting_value['type'] == "close-btn" && !$inline) {
            $Wrap_uniq_id = isset( $setting_value['id'] ) ? $setting_value['id'] : '';
            $popupSetData["style"] .= isset( $setting_value['style'] )?"#".$Wrap_uniq_id."{".$setting_value['style']."}":'';
            $popupSetData["close-btn"] ='<span id="'.$Wrap_uniq_id.'" class="wppb-popup-close-btn dashicons dashicons-no-alt"></span>';
          }

        }
        $popupSetData['front-setting'] = htmlspecialchars( json_encode( $popupFrontSetting ), ENT_COMPAT );
        return $this->wppb_layout($popupSetData);
    }
}

public function wppb_initColumn($column,$parentId){
    $popupColumn = ['content'=>'','style'=>''];
      foreach ($column as $value) {
          $id = isset($value["id"])?$value["id"]:'';
          $popupColumn['style'] .= isset($value["style"])?'#'.$parentId.' .'.$id.'{'.$value["style"].'}':'';          
          $popupContent = isset($value['content']) && is_array($value['content']) && !empty($value['content']) ?$this->wppb_initContent( $value['content'], $parentId ):['content'=>'','style'=>''];

          $popupColumn['style'] .= $popupContent["style"];
          $popupColumn['content'] .= '<div class="'.$id.' wppb-popup-rl-column">'.$popupContent["content"].'</div>';
      }
      return $popupColumn;
}

public function wppb_initContent($column_content,$parentId){
              $popupContent = ['content'=>'','style'=>''];

              foreach ($column_content as $setting_value) {
                $uniqIdAttr = isset($setting_value["id"])?$setting_value["id"]:'';
                  
                if( isset($setting_value['style']) ) {
                  $popupContent['style'] .= "#".$parentId.' .'.$uniqIdAttr.'{'.$setting_value['style'].';}';
                }

                $alignMent = isset($setting_value['alignment'])?'style="justify-content:'.$setting_value['alignment'].';"':'';
                $dataLink = isset($setting_value['link'])?$setting_value['link']:'';
                $dataLinktarget = isset($setting_value['target']) && $setting_value['target']?"target='_blank'":'';
                $uniqIdAttr = $setting_value['type'] == 'heading'? $uniqIdAttr." text-heading":$uniqIdAttr;

                if ($setting_value['type'] == 'link' || $dataLink) {
                    $popupContent['content'] .=  '<div class="data-rl-editable-wrap" '.$alignMent.'>
                          <a href="'.$dataLink.'" class="'.$uniqIdAttr.'" '.$dataLinktarget.'>'.$setting_value['content'].'</a>
                        </div>';
                }elseif ($setting_value['type'] == 'text' || $setting_value['type'] == 'heading') {
                  $popupContent['content'] .=  '<div class="data-rl-editable-wrap" '.$alignMent.'>
                          <span class="'.$uniqIdAttr.'">'.$setting_value['content'].'</span>
                        </div>';
                }elseif ($setting_value['type'] == 'image') {
                  $popupContent['content'] .= '<div class="data-rl-editable-wrap wrap-image_" '.$alignMent.'>
                               <img  class="'.$uniqIdAttr.'" src="'.$setting_value['image-url'].'">
                              </div>';
                }elseif ( $setting_value['type'] == 'lead-form' && is_numeric($setting_value['content']) ) {

                  if ( isset($setting_value['styles']) && $uniqIdAttr ) {
                        $allUniqueId = "#".$parentId.' #'.$uniqIdAttr;
                        if ( isset($setting_value['styles']['form-style']) ){
                              $popupContent['style'] .= $allUniqueId.' form{'.$setting_value['styles']['form-style'].';}';
                          }
                        if ( isset($setting_value['styles']['submit-style']) ){
                            $popupContent['style'] .= $allUniqueId.' form input[type="submit"]{'.$setting_value['styles']['submit-style'].';}';
                        }
                        if ( isset($setting_value['styles']['label-style']) ){
                            $popupContent['style'] .= $allUniqueId.' form .lf-field > label{'.$setting_value['styles']['label-style'].';}';
                        }

                        if ( isset($setting_value['styles']['heading-style']) ){
                            $popupContent['style'] .= $allUniqueId.' form > h2{'.$setting_value['styles']['heading-style'].';}';
                        }

                        if ( isset($setting_value['styles']['field-style']) ){
                            $popupContent['style'] .= $allUniqueId.' form .lf-field input:not([type="submit"]),'.$allUniqueId.'form .lf-field texarea{'.$setting_value['styles']['field-style'].';}';
                        }
                        $submitAlign = '';
                        if (isset($setting_value['styles']['submit-align'])) {
                          $submitAlign = 'lf_submit_'.$setting_value['styles']['submit-align'];
                        }

                  }

                  $popupContent['content'] .= '<div class="data-rl-editable-wrap" '.$alignMent.'>
                  <div class="wppb-popup-lead-form '.$submitAlign.'" id="'.$uniqIdAttr.'">
                  '.self::lead_form_front_end()->lfb_show_front_end_forms($setting_value['content']).'
                  </div>
                  </div>';
                }
            }
          return $popupContent;
  }

  public function wppb_layout($popupSetData,$layout=''){

    $internal_Css = '';
    if ( $popupSetData['style'] ) {
        $internal_Css = "<div><style>".$popupSetData['style']."</style></div>";
    }

    $overlay_image = $popupSetData['overlay-image-url']?'background-image:url('.$popupSetData['overlay-image-url'].');':'';
    $overlayStyle = $overlay_image?$overlay_image.$popupSetData['overlay-style']:'';
    $globalHeight = $popupSetData["wrapper-height"] != 'auto'?$popupSetData["wrapper-height"].'px;':$popupSetData["wrapper-height"].';';
    $globalStyle = "padding:".$popupSetData["global-padding"].";height:".$globalHeight;

    $return = $popupSetData["close-btn"].'<div class="wppb-popup-custom-wrapper" style="'.$popupSetData["wrapper-style"].'">
            <input type="hidden" name="popup-setting-front" value="'.$popupSetData["front-setting"].'">
             <div class="wppb-popup-overlay-custom-img" style="'.$overlayStyle.'"></div>
              <div class="wppb-popup-custom-overlay" style="background-color:'.$popupSetData['overlay-color'].';"></div>
                  <div class="wppb-popup-custom-content" style="'.$globalStyle.'">
                  '.$popupSetData["content"].'
                  </div>
            </div>';
    return $internal_Css.$return;
}

// lead form -------------- function --------------- 

public static function lead_form_front_end(){
  return class_exists( 'LFB_Front_end_FORMS' ) ? new LFB_Front_end_FORMS() : false;
}

public static function lead_form_db(){
  return class_exists( 'LFB_SAVE_DB' ) ? new LFB_SAVE_DB() : false;
}

  public static function lead_form_opt(){    
      $forms = self::lead_form_db() ? self::lead_form_db()->lfb_get_all_form_title() : false;
      $return = '';
      if (!empty($forms)) {
          foreach ($forms as $value) {
            if ( isset($value->id) && isset($value->form_title) )$return .= "<option value='".$value->id."'>".$value->form_title."</option>";
          }
      }
    return $return ? $return : "<option>No Form Found</option>";
  }

public function get_lead_form_ajx(){
  if (isset($_POST['form_id']) && is_numeric($_POST['form_id']) ) {
      $form_id = $_POST['form_id'];
      return self::lead_form_front_end()->lfb_show_front_end_forms($form_id);
  }
}


// class end
}

