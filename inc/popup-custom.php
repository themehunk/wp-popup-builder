<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<input type="hidden" name="popup-url" value="<?php echo esc_attr(WPPB_URL); ?>">

<input type="hidden" data-global-save="global-content" value='<?php echo esc_attr($popupSetData["global_content"]); ?>'>

<div class="wppb-popup-custom <?php echo esc_attr(!$get_CustomPopup ?'rl-display-none':''); ?>" style="background-color:<?php echo esc_attr($popupSetData['outside-color']); ?>;">
	<div>

	<?php 

	$arr = array(

        	'span' => array(
                  'data-overlay-image' => array(),
                  'data-rl-column' => array(),
                  'data-content-alignment' => array(),
                  'data-editor-link' => array(),
                  'data-editor-link-target' => array(),
                  'data-rl-editable' => array(),
                  'data-form-styles' => array(),
                  'data-rl-editable-wrap'=> array(),
                  'data-form-id'=> array(),
                  'data-shortcode'=> array(),
                  'class'  => array(),
                  'data-uniqid' => array(),
                  'style'  => array(),
                  'contenteditable'=> array(),
                  'data-color-id-background-color'=> array(),
                  'data-color-id-border-color'=> array(),
			), 

			'div' => array(
                  'class'  => array(),
                  'data-uniqid' => array(),
                  'style'  => array(),
                  'data-overlay-image' => array(),
                  'data-rl-column' => array(),
                  'data-content-alignment' => array(),
                  'data-editor-link' => array(),
                  'data-editor-link-target' => array(),
                  'data-rl-editable' => array(),
                  'data-form-styles' => array(),
                  'data-rl-editable-wrap'=> array(),
                  'data-form-id'=> array(),
                  'data-shortcode'=> array(),
				), 

			   'img' => array(
					  'title' => array(),
					  'src'	=> array(),
					  'alt'	=> array(),
					  'class'  => array(),
	                  'data-uniqid' => array(),
	                  'style'  => array(),
	                  'data-overlay-image' => array(),
	                  'data-rl-column' => array(),
	                  'data-content-alignment' => array(),
	                  'data-editor-link' => array(),
	                  'data-editor-link-target' => array(),
	                  'data-rl-editable' => array(),
	                  'data-form-styles' => array(),
	                  'data-rl-editable-wrap'=> array(),
	                  'data-form-id'=> array(),
	                  'data-shortcode'=> array(),
				)

			);

			//echo wp_kses($wp_builder_obj->popup_layout($popupSetData),$arr); 

			echo $wp_builder_obj->popup_layout($popupSetData); 



		?>	

	</div>	
	
</div> 
