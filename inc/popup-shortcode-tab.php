<?php 
if ( ! defined( 'ABSPATH' )) exit;	
	$options = ['pages','post','home_page'];
	$check_option = [];
	foreach ($options as $options_value) {
		$check_option[$options_value] = isset($addon_option[$options_value]) && $addon_option[$options_value]?'checked="checked"':'';
	}
?>
 <div class="wppb-opt-wrapper">
   	 <section class="wppb-popup-position">
   		<div class="wppb-header-top-header">
  			<span class="wppb-popup-heading-title wppb-popup-title"><?php _e('Popup Position','wppb') ?></span>
  			<p class="wppb-popup-heading-description"><?php _e('Set Desired Location of Business Popup on your site.','wppb') ?></p>
   		</div>
  		<div class="wppb-popup-both">
			<!-- perticular page -->
			<div class="wppb-perticular-page">
	  		  <div class="wppb-popup-page-demo">
	  		  	<div></div><div></div><div></div><div></div>
	  		  	<div></div><div></div><div></div>
	  		  	<div class="wppb-popup-screen"></div>
	  		  </div>
				  <div class="wppb-perticular-page-shortcode">
		          <span class="wppb-popup-title"><?php _e('Particular Page','wppb') ?></span>
		          <span><?php _e('[wppb popup="'.$wppb_popup_id.'"]','wppb') ?></span>
	          </div>
	        </div>
	        <p><?php _e('Or','wppb') ?></p>
		    <!-- page by -->
	        <div class="wppb-opt-all-pages">
		        <div class="wppb-popup-optPopup-msg">
		        	<span class="dashicons dashicons-no optClose"></span><span class="opt_name"></span>
		        </div>
		        <div class="wppb-popup-optSaved-msg">
		        	<p><span class="checked-icon dashicons dashicons-yes"></span><?php _e('Option Saved','wppb') ?></p>
		        </div>
		  		  <div class="wppb-popup-page-demo">
		  		  	<div></div><div></div><div></div><div></div>
		  		  	<div></div><div></div><div></div>
		  		  	<div class="wppb-popup-screen"></div>
		  		  </div>
	        		<div class="wppb-opt-all-pages-div">
			            <span  class="wppb-popup-heading-title wppb-popup-title"><?php _e('Without Shortcode','wppb') ?></span>
			            <div class="wppb-opt-page-opt" data-bid="<?php echo $wppb_popup_id ?>">
			                <div class="wppb-popup-checkbox-container">
			                  <span class="wppb-popup-checkbox-title"><?php _e('Home Page','wppb') ?></span>
			                  <div class="wppb-popup-checkbox">
			                    <input id="wppb-opt-home_page" type="checkbox" data-name="home_page" <?php _e($check_option['home_page'],'wppb') ?>>
			                    <label for="wppb-opt-home_page"></label>
			                  </div>
			                </div>
			                <div class="wppb-popup-checkbox-container">
			                  <span class="wppb-popup-checkbox-title"><?php _e('Pages','wppb') ?></span>
			                  <div class="wppb-popup-checkbox">
			                    <input id="wppb-opt-pages" type="checkbox" data-name="pages" <?php _e($check_option['pages'],'wppb') ?>>
			                    <label for="wppb-opt-pages"></label>
			                  </div>
			                </div>
			                <div class="wppb-popup-checkbox-container">
			                  <span class="wppb-popup-checkbox-title"><?php _e('Post','wppb') ?></span>
			                  <div class="wppb-popup-checkbox">
			                    <input id="wppb-opt-post" type="checkbox" data-name="post" <?php _e($check_option['post'],'wppb') ?>>
			                    <label for="wppb-opt-post"></label>
			                  </div>
			                </div>
			            </div>
			        </div>
		       </div>
		      <!-- page by -->
			  </div>
		</section>
 </div>
<div class="wppb-popup-editor-divider"></div>
<div class="wppb-header-top-header">
	<span class="wppb-popup-heading-title wppb-popup-title"><?php _e('Inline Popup','wppb') ?></span>
	<p class="wppb-popup-heading-description"><?php _e('Display your Business Popup on Post and Widget Box areas.','wppb') ?></p>
</div>	
<div class="wppb-popup-both">
	<!-- perticular page -->
	<div class="wppb-perticular-page">
		  <div class="wppb-popup-page-demo">
		  	<div></div><div></div>
		  	<div class="wppb-popup-inline-post"></div>
		  	<div></div><div></div>
		  </div>
		  <div class="wppb-perticular-page-shortcode">
          <span class="wppb-popup-title"><?php _e('Inline In Post','wppb') ?> </span>
          <span><?php _e('[wppb inline="'.$wppb_popup_id.'"]','wppb') ?></span>
      </div>
    </div>
    <p></p>
        <!-- page by -->
    <div class="wppb-perticular-page">
	  <div class="wppb-popup-page-demo">
	  	<section class="wppb-popup-widget-demo">
	  		<div>
	  			<div></div><div></div><div></div>
	  		</div>
	  		<div></div>
	  	</section>
	  			<div></div><div></div><div></div>
	  </div>
	  <div class="wppb-perticular-page-shortcode">
      <span class="wppb-popup-title"><?php _e('Widget Box','wppb') ?></span>
      <span><?php _e('[wppb widget="'.$wppb_popup_id.'"]','wppb') ?></span>
      </div>
    </div>
      <!-- page by -->
</div>
