<?php 
if ( ! defined( 'ABSPATH' )) exit;

	$OldUser_options = ['all','pages','post','home_page','mobile-enable'];
	$check_option_prev = [];
	foreach ($OldUser_options as $options_value) {
		if ( isset($addon_option[$options_value]) && $addon_option[$options_value] ) {
			$check_option_prev[$options_value] = true;
		}
	}

// =========placement 
	$popupPlaceMent = $allPAges = $allPOst = $allWooCheck = '';
	if ( isset($addon_option['placement']) ) {
		if ( is_array( $addon_option['placement'] ) ) {
			$popupPlaceMent = 'pages';
			// for pages
			if ( isset( $addon_option['placement']['pages'] ) && is_array($addon_option['placement']['pages']) ) {
				$pagesId = array_flip( $addon_option['placement']['pages'] );
			}else if (isset($addon_option['placement']['pages']) && $addon_option['placement']['pages'] == 'all') {
				$allPAges = 'checked';
			}
			// for post
			if ( isset( $addon_option['placement']['post'] ) && is_array($addon_option['placement']['post']) ) {
				$postId = array_flip( $addon_option['placement']['post'] );
			}else if (isset($addon_option['placement']['post']) && $addon_option['placement']['post'] == 'all') {
				$allPOst = 'checked';
			}
			//for woocommerce posts
			if (class_exists( 'WooCommerce' )) {
				if ( isset( $addon_option['placement']['woocommerce'] ) && is_array($addon_option['placement']['woocommerce']) ) {
					$woocommerce_postId = array_flip( $addon_option['placement']['woocommerce'] );
				}else if (isset($addon_option['placement']['woocommerce']) && $addon_option['placement']['woocommerce'] == 'all') {
					$allWooCheck = 'checked';
				}
			}
		}else{
			$popupPlaceMent = $addon_option['placement'];
		}

	}
	// for pages
	$All_pages = get_pages(); 
	$all_pages_html = '';
	if ( $All_pages ) {
		 foreach ( $All_pages as $page_c ) {
				$all_pages_html .= '<li>';
				$checkedPAges = isset( $pagesId[ $page_c->ID ] ) ? 'checked' : '';
				$all_pages_html .= '<input '.$checkedPAges.' id="wppb-pages--'.$page_c->ID.'" type="checkbox" name="pages-check" value="'.$page_c->ID.'">';
				$all_pages_html .= '<label for="wppb-pages--'.$page_c->ID.'">';
				$all_pages_html .= '<span class="dashicons dashicons-yes-alt"></span>'.$page_c->post_title;
				$all_pages_html .= '</label></li>';
		  }
	}
	// for posts
	$All_post = get_posts(); 
	$all_post_html = '';
	if ( $All_post ) {
		 foreach ( $All_post as $post_c ) {
		 		$all_post_html .= '<li>';
				$checkedPost = isset( $postId[ $post_c->ID ] ) ? 'checked' : '';
				$all_post_html .= '<input '.$checkedPost.' id="wppb-posts--'.$post_c->ID.'" type="checkbox" name="post-check" value="'.$post_c->ID.'">';
				$all_post_html .= '<label for="wppb-posts--'.$post_c->ID.'">';
				$all_post_html .= '<span class="dashicons dashicons-yes-alt"></span>'.$post_c->post_title;
				$all_post_html .= '</label></li>';
		  }
	}
	//all woocommerce posts
			if (class_exists( 'WooCommerce' )) {
				$allWooCommercePost = '';
				$Woo_Args = array(
					'posts_per_page'=>50,
				    'post_type' => 'product',
				    'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash')    
				);
				$Woo_query_wppb = new WP_Query($Woo_Args);
				foreach ($Woo_query_wppb->posts as $wo_wppb_value) {
							$allWooCommercePost .= '<li>';
							$checkWoocomercePage = isset( $woocommerce_postId[ $wo_wppb_value->ID ] ) ? 'checked' : '';
							$allWooCommercePost .= '<input '.$checkWoocomercePage.' id="wppb-posts--'.$wo_wppb_value->ID.'" type="checkbox" name="woocommerce-check" value="'.$wo_wppb_value->ID.'">';
							$allWooCommercePost .= '<label for="wppb-posts--'.$wo_wppb_value->ID.'">';
							$allWooCommercePost .= '<span class="dashicons dashicons-yes-alt"></span>'.$wo_wppb_value->post_title;
							$allWooCommercePost .= '</label></li>';
				}
		}



// =========device 
$device = isset( $addon_option['device'] ) ? $addon_option['device'] : 'all';
// =========page load  
$triggerV = ['class-id'=>'','minute'=>'00','second'=>'3','pageload'=>true]; 
if ( isset( $addon_option['trigger'] ) && is_array( $addon_option['trigger'] ) ) {
	foreach ($addon_option['trigger'] as $trigger_key => $trigger_value) {
			
			if ($trigger_key == 'page-load') {
				$triggerV['pageload'] = false;
				if ( $trigger_value == 'true' ) $triggerV['page-load'] = true;
			}else if( $trigger_key == 'time' && !empty($trigger_value) ){
				foreach ($trigger_value as $time_key => $Time_value) {
					if ($Time_value != '') {
						$triggerV[ $time_key ] = $Time_value; 
					}
				}
			}elseif( $trigger_key == 'click' && !empty($trigger_value) ){
				$triggerV['class-id'] = join( ',',$trigger_value );
			}else if( $trigger_key == 'page-scroll' ){
				$triggerV['page-scroll'] = $trigger_value;
			}else if( $trigger_key == 'exit' ){
				$triggerV['exit'] = true;
			}

		}	
}

$frequency = isset($addon_option['frequency']) ? [ $addon_option['frequency']=>true ] : false;

// print_r($frequency);

$showTime = isset($addon_option['show-time']) && $addon_option['show-time'] ? 'checked':'';
$afterDays = isset($addon_option['after-days']) && $addon_option['after-days'] ? 'checked':'';
$afterDaysCount = $afterDays ? $addon_option['after-days'] : '';
$afterDaysCountHour = isset($addon_option['after-hour']) && $addon_option['after-hour'] ? $addon_option['after-hour'] : '0';
$EveryPage = isset($addon_option['every-page']) && $addon_option['every-page'] ? 'checked':'';

$popup_is_active = isset($popup_is_active) ? $popup_is_active : '';

// echo "<br>";

// echo "</pre>";

?>


<section class="setting-submit-wrap wppb-title_">
	<div class="title__">
		<span>Title : </span>
		<span class="wppb-popup-title-name">Box Modal Name </span>
	</div>
	<div class="status__">
		<?php  
		echo $wp_builder_obj->checkbox("business-idd-",__("Status : ",'wppb'),'class="wppb_popup_setting_active" data-bid="'.$wppb_popup_id.'" '.$popup_is_active); 
		?>
	</div>
	<div class="save__">
		<button class="wppb-popup-setting-save business_disabled" data-bid="<?php echo $wppb_popup_id; ?>" >Save</button>
	</div>
</section>
<div class="wppb-popup-editor-divider"></div>


<!-- popup display -->
<section class="wppb-display-popup">
		<span class="popup-display-sub-heading">Popup Display And Shortcode</span>
		<div class="wppb-popup-placement">
			<ul class="rl-clear">
				<li>
					<input id='popup--placement-all' type="radio" name="popup-placement" value="all" <?php if (isset($check_option_prev['all']) || $popupPlaceMent == "all" ) echo 'checked'; ?> >
					<label for='popup--placement-all'><span class="dashicons dashicons-admin-site-alt3"></span><span>Whole Site</span></label>
				</li>
				<li>
					<input id='popup--placement-home_page' type="radio" name="popup-placement" value="home_page" <?php if (isset($check_option_prev['home_page']) || $popupPlaceMent == "home_page" ) echo 'checked'; ?> >
					<label for='popup--placement-home_page'><span class="dashicons dashicons-admin-home"></span><span>Home Page</span></label>
				</li>
				<li>
					<input id='popup--placement-pages' type="radio" name="popup-placement" value="pages" <?php if (isset($check_option_prev['pages']) || $popupPlaceMent == "pages" ) echo 'checked'; ?> >
					<label for='popup--placement-pages'><span class="dashicons dashicons-list-view"></span><span>Selected Pages</span></label>
				</li>
			</ul>
			<div class="wppb-perticular-page">
				<div class="wppb-perticular-page-shortcode">
		          <span class="wppb-popup-title"><?php _e('Shortcode','wppb') ?></span>
		          <span><?php _e('[wppb popup="'.$wppb_popup_id.'"]','wppb') ?></span>
		      </div>
		    </div>
		</div>
		<div class="wppb-placement-selection <?php if ($popupPlaceMent != "pages") echo "rl-display-none"; ?>"><!-- wppb-placement -->
			<div>
				<div class="wppb-placement-wrap"> <!-- placement-wrap -->
					<!-- nav -->
					<div class="nav_">
						<span class="active" data-tab="pages" data-tab-group="post-page-placement">Pages</span>
						<span data-tab="post" data-tab-group="post-page-placement">Posts</span>
						<?php if (class_exists( 'WooCommerce' )) { ?>
						<span data-tab="woocommerce" data-tab-group="post-page-placement">Woocommerce</span>
						<?php } ?>
					</div>

					<?php	
						// for previous user purpose
						$allPAges = $allPAges || isset($check_option_prev['pages']) ?'checked' : ''; 
						$allPOst = $allPOst || isset($check_option_prev['post']) ?'checked' : ''; 
					?>

					<!-- pages_ -->
					<div class="pages_  rl-display-none active" data-tab-active="pages" data-tab-group="post-page-placement">
						<div class="all_">
						 <?php  echo $wp_builder_obj->checkbox("wppb-opt-all-pages",__("All Pages",'wppb'),'data-name="all-pages" '.$allPAges); ?>
						</div>
						<div class="saparate_">
							<ul>
								<?php echo $all_pages_html; ?>
							</ul>
						</div>
					</div>
					<!-- post_ -->
					<div class="post_ rl-display-none" data-tab-active="post" data-tab-group="post-page-placement">
						<div class="all_">
							<?php  echo $wp_builder_obj->checkbox("wppb-opt-all-posts",__("All Post",'wppb'),'data-name="all-posts" '.$allPOst); ?>
						</div>
						<div class="saparate_">
							<ul>
								<?php echo $all_post_html; ?>
							</ul>
						</div>
					</div>
					<?php if (class_exists( 'WooCommerce' )) { ?>
					<!-- woocommerce posts -->
						<div class="woocommerce_ rl-display-none" data-tab-active="woocommerce" data-tab-group="post-page-placement">
							<div class="all_">
								<?php  echo $wp_builder_obj->checkbox("wppb-opt-all-woocommerce-posts",__("Woocommerce Post",'wppb'),'data-name="all-woocommerce-posts" '.$allWooCheck); ?>
							</div>
							<div class="saparate_">
								<ul>
									<?php echo $allWooCommercePost; ?>
								</ul>
							</div>
						</div>
					<!-- woocommerce posts -->
					<?php } ?>
				</div><!-- placement-wrap -->
			</div>
		</div><!-- wppb-placement -->	
</section>
<div class="wppb-popup-editor-divider"></div>
<!-- popup display device -->
<section class="wppb-display-device">
		<span class="popup-display-sub-heading">Popup Display Device</span>
		<div class="wppb-popup-placement">
			<ul class="rl-clear">
				<li>
					<input id='popup--device-all' type="radio" name="popup-device" value="all" <?php if( $device == "all" )echo "checked"; ?> >
					<label for='popup--device-all'><span class="dashicons dashicons-desktop"></span><span>All Device</span></label>
				</li>
				<li>
					<input id='popup--device-desktop' type="radio" name="popup-device" value="desktop" <?php if( $device == "desktop" )echo "checked"; ?> >
					<label for='popup--device-desktop'><span class="dashicons dashicons-desktop"></span><span>Desktop</span></label>
				</li>
				<li>
					<input id='popup--device-mobile' type="radio" name="popup-device" value="mobile" <?php if( $device == "mobile" )echo "checked"; ?> >
					<label for='popup--device-mobile'><span class="dashicons dashicons-smartphone"></span><span>Mobile</span></label>
				</li>
			</ul>
		</div>
</section>
<!-- popup trigger -->
<div class="wppb-popup-editor-divider"></div>

<section class="wppb-display-trigger">
		<span class="popup-display-sub-heading">Popup Trigger</span>
		<div class="wppb-popup-placement">
			<ul class="rl-clear">
				<li>
					<input id='popup--trigger-page-load' type="checkbox" name="popup-trigger" value="page-load" <?php if( isset($triggerV['page-load']) || $triggerV['pageload'] ) echo 'checked'; ?> >
					<label for='popup--trigger-page-load'><span class="dashicons dashicons-update-alt"></span><span>Page Load</span></label>
				</li>
				<li>
					<input id='popup--trigger-click' type="checkbox" name="popup-trigger" value="click" <?php if( $triggerV['class-id'] ) echo 'checked'; ?> >
					<label for='popup--trigger-click'><span class="dashicons dashicons-external"></span><span>On Click</span></label>
				</li>
				<li>
					<input id='popup--trigger-page-scroll' type="checkbox" name="popup-trigger" value="page-scroll" <?php if(isset($triggerV['page-scroll'])) echo 'checked'; ?> >
					<label for='popup--trigger-page-scroll'><span class="dashicons dashicons-arrow-up-alt"></span><span>Page Scroll</span></label>
				</li>
				<li>
					<input id='popup--trigger-exit-popup' type="checkbox" name="popup-trigger" value="exit" <?php if(isset($triggerV['exit'])) echo 'checked'; ?> >
					<label for='popup--trigger-exit-popup'><span class="dashicons dashicons-dismiss"></span><span>Exit Window</span></label>
				</li>
			</ul>
		</div>

		<div class="trigger-class-id <?php if($triggerV['class-id'] == '') echo 'rl-display-none'; ?>">
			<div>
				<label>Click Class / ID</label>
				<input type="text" name="class-id" placeholder=".myclass,#myid" value="<?php echo $triggerV['class-id'] ?>">
			</div>
		</div>
		<div class="trigger-time <?php if( !(isset($triggerV['page-load']) || $triggerV['pageload']) ) echo 'rl-display-none'; ?>">
			<span class="popup-display-sub-heading-2">Time Spent After Appear Popup.</span>
			<div>
				<div>
					<label>Second</label>
					<input type="number" max="60" name="second" value="<?php echo $triggerV['second']; ?>">
				</div>
			</div>
		</div>

		<div class="page-scroll rl-clear <?php echo !isset($triggerV['page-scroll']) ? 'rl-display-none' : ''; ?>">
			<div>
				<span>When Page Scroll Percent Then Popup Will Appear.</span>
			</div>
			<div>
				<input type="number" max="60" name="page-scroll" value="<?php echo isset($triggerV['page-scroll']) ? $triggerV['page-scroll'] : '10'; ?>">
				<label>%</label>
			</div>
		</div>
</section>
<div class="wppb-popup-editor-divider"></div>
<section class="wppb-popup-frequency">
		<span class="popup-display-sub-heading">Frequency</span>
		<div class="wrap-frequency">
			<div>
				<input <?php if(isset($frequency['every-page']) ) echo 'checked'; ?> id="checkbox--frequency-every-page" type="radio" name="frequency" value="every-page">
				<label for="checkbox--frequency-every-page"><span class="dashicons dashicons-yes-alt"></span>Every Time Site Reload.</label>
			</div>

			<div>
				<input <?php if(isset($frequency['one-time']) ) echo 'checked'; ?> id="checkbox--frequency-show-time" type="radio" name="frequency" value="one-time">
				<label for="checkbox--frequency-show-time"><span class="dashicons dashicons-yes-alt"></span>One Time Show On Visit Page.</label>
			</div>
			<div class="frequency-day-hour">
				<input <?php if(isset($frequency['after-time']) ) echo 'checked'; ?> id="checkbox--frequency-after-days" type="radio" name="frequency" value="after-time">
				<label for="checkbox--frequency-after-days"><span class="dashicons dashicons-yes-alt"></span>How Much Time After Show Popup. </label>
				<div>
					<label>Days</label>
					<input type="number" name="after-days-count" value="<?php echo $afterDaysCount ?>"> 
				</div>
				<div>
					<label>Hour</label>
					<input type="number" name="after-days-hour-count" value="<?php echo $afterDaysCountHour ?>"> 
				</div>
			</div>

		</div>
</section>

<div class="wppb-popup-editor-divider"></div>
<section class="setting-submit-wrap">
	<button class="wppb-popup-setting-save business_disabled" data-bid="<?php echo $wppb_popup_id; ?>" >Save</button>
</section>






