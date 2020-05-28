<?php 
// prebuilt popup json 
$prebuiltJsonFile = file_get_contents(WPPB_URL.'inc/wppb-builder.json');

// replace of image url with plugin path
	$getBeofrehttp_str 	 = strstr($prebuiltJsonFile,"plugins/wp-popup-builder/img/",true); 
	$getPosOfhttp_str   = strrpos($getBeofrehttp_str,'http');
	$replacedUrl_jsonData  = substr($getBeofrehttp_str,$getPosOfhttp_str).'plugins/wp-popup-builder/';
	$prebuiltJsonFile = str_replace($replacedUrl_jsonData,WPPB_URL,$prebuiltJsonFile);
// replace of image url with plugin path


$prebuiltJsonFile = json_decode($prebuiltJsonFile,true);
$countColumn = 0;
$jsonPopupDemo = '';

if (is_array($prebuiltJsonFile)) {
	foreach ($prebuiltJsonFile as $prebuilt_value) {
		$countColumn++;
		$jsonPopupDemo .= $wp_builder_obj->wppbPopupList_json( $prebuilt_value,$countColumn,count($prebuiltJsonFile) );			
	}
}
?>

<section class="wppb-popup-name-layout">
	<!-- popup name  -->
	<div class="wppb-popup-name">
		<div>
			<span>Enter Popup name</span>
			<input type="text" name="wppb-popup-name">
		</div>
	</div>
	<!-- popup name  -->
	<div class="prebulit-demo-popup">
	<!-- prebuilt popup section -->
		<section class="prebuilt-pupup-layout-container">
				<!-- layout 1 -->
				<div data-layout="layout-1">
					<span class="wppb-popup-close-btn dashicons dashicons-no-alt" style="color: #f01010d8;border: 2px solid #9c27b0e6;border-radius: 15px;padding: 1px;top: -2%;right: -2%;background-color: #ffffff;"></span>
					<div class="wppb-popup-custom-wrapper">	 	
							<div class="wppb-popup-overlay-custom-img" data-overlay-image="" style=""></div>
					         <div class="wppb-popup-custom-overlay" style="background-color:#6939bded;"></div>
					          <div class="wppb-popup-custom-content" style="padding: 18px 37px;">
					          		<div data-rl-wrap="layout-1" class="wppb-popup-rl-wrap rl-clear">
										<div data-rl-column='1' class="wppb-popup-rl-column rlEditorDropable">
											<div class="data-rl-editable-wrap">
												<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>
												<span class="text-heading" data-rl-editable="heading" data-content-alignment="center" style="font-size: 26px; line-height: 30px;">Add Your Business Heading</span>
											</div>
											<div class="data-rl-editable-wrap">
												<div class="actions_">
												<span class="dashicons dashicons-no rlRemoveElement"></span></div>
												<span data-rl-editable="text" style="font-size: 16px;margin: -4px 0px 15px;color: #d6d6d6;">Add your business sub heading</span>
											</div>
											<div class="data-rl-editable-wrap wrap-image_" style="justify-content: center;">
															<div class="actions_">
															<span class="dashicons dashicons-no rlRemoveElement"></span>
														 </div>
											<img src="<?php echo WPPB_URL ?>img/images.jpg" data-content-alignment="center" data-rl-editable="image" style="width: 83%;">
											</div>
											<div class="data-rl-editable-wrap">
												<div class="actions_">
												<span class="dashicons dashicons-no rlRemoveElement"></span></div>
												<span data-rl-editable="text" style="font-size: 12px;color:#ACACAC;letter-spacing: 0;margin: 0;padding: 12px 0;">Small Business: Pop-Up Shop Ticket, Sat, Apr 25 2020</span>
											</div>

											<div class="data-rl-editable-wrap" style="justify-content: center;">
												<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>
												<span data-rl-editable="link" data-content-alignment="center" data-editor-link="#" style="width: fit-content; padding: 8px 16px; border: 1px solid rgba(211, 74, 74, 0.35); color: rgba(226, 178, 32, 1);font-size: 15px; border-radius:2px;">Book Ticket</span>
											</div>
										</div>
									</div>
					          </div>
					</div>
				</div>
	<!-- layout 2 -->
				<div data-layout="layout-2">
					<span class="wppb-popup-close-btn dashicons dashicons-no-alt" style="top: 0%; right: 0%;"></span>
					<div class="wppb-popup-custom-wrapper" style="width: 500px;">	 	
							<div class="wppb-popup-overlay-custom-img" data-overlay-image="" style=""></div>
					         <div class="wppb-popup-custom-overlay" style="background-color:#FEFEFF;"></div>
					          <div class="wppb-popup-custom-content" style="padding: 40px 0;">
					          		<div data-rl-wrap="layout-2" class="wppb-popup-rl-wrap two-column rl-clear">
										<div data-rl-column='1' class="wppb-popup-rl-column rlEditorDropable">
											<div class="data-rl-editable-wrap wrap-image_">
															<div class="actions_">
															<span class="dashicons dashicons-no rlRemoveElement"></span>
														 </div>
											<img src="<?php echo WPPB_URL ?>img/images.jpg"data-content-alignment="center" data-rl-editable="image" style="padding: 6px;">
											</div>
										</div>
										<div data-rl-column='1' class="wppb-popup-rl-column rlEditorDropable">
											<div class="data-rl-editable-wrap">
												<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>
												<span class="text-heading" data-rl-editable="heading"data-content-alignment="center" style="letter-spacing: 0; line-height: 40px; font-size: 35px; font-weight: 500; padding-right: 0px; padding-bottom: 1px; color: rgba(82, 82, 82, 1);">Do you want 25% off  your first order ?</span>
										</div>
											<div class="data-rl-editable-wrap" style="justify-content: center;"><div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div><span data-rl-editable="link" data-editor-link="#" data-editor-link-target="0" style="width: 75%;padding: 8px 6px;border: 2px solid rgba(10, 198, 206, 1);letter-spacing: 0;font-weight: 500;font-size: 15px;line-height:15px;border-radius: 12px;color: rgba(10, 198, 206, 1);margin: 12px 0px 3px 0px;" data-content-alignment="center" class="">GET EXCLUSIVE CODE</span></div>
										</div>
									</div>
					          </div>
					</div>
				</div>			
	<!-- layout 3 -->
				<div data-layout="layout-3">
					<span class="wppb-popup-close-btn dashicons dashicons-no-alt" style="top: 0%; right: 0%;"></span>
					<div class="wppb-popup-custom-wrapper" style="width: 500px;">	 	
							<div class="wppb-popup-overlay-custom-img" data-overlay-image="" style=""></div>
					         <div class="wppb-popup-custom-overlay" style="background-color:#FEFEFF;"></div>
					          <div class="wppb-popup-custom-content" style="padding: 40px 0;">
					          		<div data-rl-wrap="layout-3" class="wppb-popup-rl-wrap two-column rl-clear">
										<div data-rl-column='1' class="wppb-popup-rl-column rlEditorDropable">
											<div class="data-rl-editable-wrap">
												<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>
												<span class="text-heading" data-rl-editable="heading"data-content-alignment="center" style="letter-spacing: 0; line-height: 40px; font-size: 35px; font-weight: 500; padding-right: 0px; padding-bottom: 1px; color: rgba(82, 82, 82, 1);">Do you want 25% off  your first order ?</span>
										</div>
											<div class="data-rl-editable-wrap" style="justify-content: center;"><div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div><span data-rl-editable="link" data-editor-link="#" data-editor-link-target="0" style="width: 75%;padding: 8px 6px;border: 2px solid rgba(10, 198, 206, 1);letter-spacing: 0;font-weight: 500;font-size: 15px;line-height:15px;border-radius: 12px;color: rgba(10, 198, 206, 1);margin: 12px 0px 3px 0px;" data-content-alignment="center" class="">GET EXCLUSIVE CODE</span></div>
										</div>


										<div data-rl-column='1' class="wppb-popup-rl-column rlEditorDropable">
											<div class="data-rl-editable-wrap wrap-image_">
															<div class="actions_">
															<span class="dashicons dashicons-no rlRemoveElement"></span>
														 </div>
											<img src="<?php echo WPPB_URL ?>img/images.jpg"data-content-alignment="center" data-rl-editable="image" style="padding: 6px;">
											</div>
										</div>

									</div>
					          </div>
					</div>
				</div>			
	<!-- layout 3 -->
		</section>
	<!-- prebuilt popup section -->
		<div class="wppb-popup-name">
			<div><span>Choose Layout</span></div>
		</div>																		

		<div class="prebulilt-popup-inner">
			<ul>
				<li>
					<input id='wppb-popup-layout-label__layout-1' type="radio" name="wppb-popup-layout" value="layout-1">
					<label for="wppb-popup-layout-label__layout-1"><img src="<?php echo WPPB_URL ?>img/layout-1.png"></label>
				</li>
				<li>
					<input id='wppb-popup-layout-label__layout-2' type="radio" name="wppb-popup-layout" value="layout-2">
					<label for="wppb-popup-layout-label__layout-2"><img src="<?php echo WPPB_URL ?>img/layout-2.png"></label>
				</li>
				<li>
					<input id='wppb-popup-layout-label__layout-3' type="radio" name="wppb-popup-layout" value="layout-3">
					<label for="wppb-popup-layout-label__layout-3"><img src="<?php echo WPPB_URL ?>img/layout-3.png"></label>
				</li>
			</ul>
		</div>
</div>

<!-- prebuilt json file  -->

<section class="wppb-prebuilt-popup-json">
	<div class="wppb-popup-name">
			<div><span>Prebuilt Layout</span></div>
		</div>	

	<?php echo $jsonPopupDemo;?>
</section>

<!-- prebuilt json file  -->

	<div class="wp-popup-name-layout-name-init">
		<button class="wppb-popup-name-init business_disabled">NEXT</button>
	</div>

</section>



