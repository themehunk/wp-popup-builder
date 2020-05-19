<div class="rl_i_editor-inner-wrap">
	<?php 
	if(!isset($wppb_popup_id)) { ?>
		<div class="rl_i_editor-inner-wrap-mask"></div>
	<?php } ?>
	<div class="rl_i_editor-wrap-in">
		<div class="rl_i_editor-header">
			<div class="rl_i_editor-header-area">
				<span>Real Time Editor</span>
			</div>
		</div>
	<div class="rl_i_editor-content">
	<div class="rl_i_editor-content-area">
		<!-- content -->
		<div data-toggle="add-itemes" class="rl_i_editor-element-Toggle outer-toggle rl-active">
			<span>Content</span>
			<span class="bottomCarret dashicons dashicons-arrow-right"></span>
		</div>
		<section data-toggle-action="add-itemes" class="rl_i_editor-element-item">
			<div class="rl_i_editor-element-add-item">
				<ul class="rl_i_editor-element-add-item-list rl-clear">
					<li><span data-item-drag="text"><i class="text-icon">T</i>Text</span></li>
					<li><span data-item-drag="heading"><i class="text-icon">H</i>Heading</span></li>
					<li><span data-item-drag="link"><i class="text-icon dashicons dashicons-admin-links"></i>Button</span></li>
					<li><span data-item-drag="image"><i class="text-icon dashicons dashicons-format-image"></i>Image</span></li>
					<li><span data-item-drag="lead-form"><i class="text-icon dashicons dashicons-feedback"></i>Form</span></li>
				</ul>
			</div>
		</section>
		<!-- global setting -->
		<div data-toggle="global-setting" class="rl_i_editor-element-Toggle outer-toggle rl-active">
			<span>Global Content</span>
			<span class="bottomCarret dashicons dashicons-arrow-right"></span>
		</div>
		<section data-toggle-action="global-setting" class="rl_i_editor-global-setting rl_i_editor-element-item">
			<div class="rl_i_editor-header-title">
				<label>Popup Background Setting </label>
			</div>
			<!-- overlay image -->
			<div  class="rl_i_editor-item-content-items title_ inline__">
				<div class="rl_i_range-font-size">
					<div class="wppb-popup-checkbox-container">
						<label class="wppb-popup-checkbox-title">Background Image</label>
						<div class="wppb-popup-checkbox">
							<input id="global-overlay-image" type="checkbox" data-global-input="global-overlay-image">
							<label for="global-overlay-image"></label>
						</div>
					</div>
				</div>
			</div>
		<section class="global-overlay-image">
			<div class="rl_i_editor-item-content-items image_">
				<div class="rl-i-choose-image">
					<div data-global-input='overlay-image' class="rl-i-choose-image-wrap" style="background-image: url(<?php echo WPPB_URL ?>img/blank-img.png);">
						<div class="rl-i-choose-image-inside-wrap"><span class="iconPlus dashicons dashicons-plus"></span></div>
					</div>
				</div>
				<div class="background-image-setting">
						<span>Background Position</span>
						<div class="background-image-setting-position">
							<div>
								<input id="image-setting-left-top1" type="radio" name="background-position" data-global-input='background-position' value="left top">
								<label for="image-setting-left-top1"><span class="dashicons dashicons-arrow-up-alt rotat-45"></span></label>
							</div>

							<div>
								<input id="image-setting-center-top1" type="radio" name="background-position" data-global-input='background-position' value="center top">
								<label for="image-setting-center-top1"><span class="dashicons dashicons-arrow-up-alt"></span></label>
							</div>

							<div>
								<input id="image-setting-right-top1" type="radio" name="background-position" data-global-input='background-position' value="right top">
								<label for="image-setting-right-top1"><span class="dashicons dashicons-arrow-up-alt rotat45"></span></label>
							</div>

							<div>
								<input id="image-setting-left-center1" type="radio" name="background-position" data-global-input='background-position' value="left center">
								<label for="image-setting-left-center1"><span class="dashicons dashicons-arrow-left-alt"></span></label>
							</div>

							<div>
								<input id="image-setting-center-center1" type="radio" name="background-position" data-global-input='background-position' value="center center">
								<label for="image-setting-center-center1"><span class="dashicons dashicons-move"></span></label>
							</div>

							<div>
								<input id="image-setting-center-right1" type="radio" name="background-position" data-global-input='background-position' value="center right">
								<label for="image-setting-center-right1"><span class="dashicons dashicons-arrow-right-alt"></span></label>
							</div>

							<div>
								<input id="image-setting-bottom-left1" type="radio" name="background-position" data-global-input='background-position' value="bottom left">
								<label for="image-setting-bottom-left1"><span class="dashicons dashicons-arrow-down-alt rotat45"></span></label>
							</div>

							<div>
								<input id="image-setting-bottom-center1" type="radio" name="background-position" data-global-input='background-position' value="bottom center">
								<label for="image-setting-bottom-center1"><span class="dashicons dashicons-arrow-down-alt"></span></label>
							</div>

							<div>
								<input id="image-setting-bottom-right1" type="radio" name="background-position" data-global-input='background-position' value="bottom right">
								<label for="image-setting-bottom-right1"><span class="dashicons dashicons-arrow-down-alt rotat-45"></span></label>
							</div>
						</div>
						<div class="rl_i_editor-item-content-items inline__">
							<label>Background Size</label>
							<div class="rl_i_editor-item-color">
								<?php echo $wp_builder_obj->select("data-global-input='background-size'",[ ['Auto','auto'],['Contain','contain'],['Cover','cover'] ]); ?>
							</div>
						</div>
						
					</div>
					
			</div>
		</section>
		<!-- overlay color -->
			<?php echo $wp_builder_obj->color('Background Color','background-color','data-global-input','overlay-color'); ?>
		<!-- outside color -->
			<?php echo $wp_builder_obj->color('Outside Color','background-color','data-global-input','outside-color'); ?>
			<!-- widdth -->
			<div class="rl_i_editor-header-title">
				<label>Popup Typography</label>
			</div>
			<?php echo $wp_builder_obj->range_slider('Popup Width', 'main-wrapper', ['title'=>'px','min'=>200,'max'=>800,'value'=>200] ,'wrapper-width'); ?>
			<!-- height -->
			<div  class="rl_i_editor-item-content-items title_ inline__">
				<div class="rl_i_range-font-size">
					<div class="wppb-popup-checkbox-container">
						<label class="wppb-popup-checkbox-title">Popup Height Auto/Custom</label>
						<div class="wppb-popup-checkbox">
							<input id="wrapper-height-auto-custom" type="checkbox" data-global-input="wrapper-height-check">
							<label for="wrapper-height-auto-custom"></label>
						</div>
					</div>
				</div>
			</div>
			<section class="global-wrapper-height-custom-auto">
			<?php echo $wp_builder_obj->range_slider('Custom Height','main-wrapper-height', ['title'=>'px','min'=>150,'max'=>1000,'value'=>200] ,'wrapper-height'); ?>
			</section>
			<!-- padding  -->
				<div class="rl_i_editor-item-content-items title_ inline_">
					<div class="rl_i_range-font-size"><label>Popup Padding in px</label></div>
					</div>
					<div class="rl_i_editor-item-content-items inline_">
						<div class="rl_i_editor-item-content-padding_ paraMeterContainer__">
							<ul class="ul-inputs-margin-padding rl-clear">
								<li>
									<input type="number" value="" data-global-input="main-wrapper" data-padding="top">
								</li>
								<li>
									<input type="number" value="" data-global-input="main-wrapper" data-padding="right">
								</li>
								<li>
									<input type="number" value="" data-global-input="main-wrapper" data-padding="bottom">
								</li>
								<li>
									<input type="number" value="" data-global-input="main-wrapper" data-padding="left">
								</li>
								<li class="padding-origin_ margin-padding-origin">
									<input id="padding-origin_global_wrap" type="checkbox" data-global-input="main-wrapper" data-origin="padding">
									<label for="padding-origin_global_wrap"><span class="dashicons dashicons-admin-links"></span></label>
								</li>
							</ul>							
							<ul class="ul-inputs-text rl-clear">
								<li>TOP</li>
								<li>RIGHT</li>
								<li>BOTTOM</li>
								<li>LEFT</li>
								<li></li>
							</ul>
						</div>
					</div>
			
			<div class="rl_i_editor-item-content-items rl-two-column-width">
				<label>Container Width</label>
				<div>
					<label>Column One %</label>
					<label>Column Two %</label>
				</div>
				<div>
					<input type="number" data-global-input="column-width" data-column="1">
					<input type="number" data-global-input="column-width" data-column="2">
				</div>
			</div>

		</section>
		<!-- timer section -->
			<div data-toggle="popup-timer-opt" class="rl_i_editor-element-Toggle outer-toggle">
				<span>Popup Timer</span>
				<span class="bottomCarret dashicons dashicons-arrow-right"></span>
			</div>
			<section data-toggle-action="popup-timer-opt" class="rl-popup-timer-opt rl-display-none">
			<?php echo $wp_builder_obj->range_slider('Popup Appear Delay', 'popup-delay-open', ['title'=>'Second','min'=>3,'max'=>60,'value'=>4] ,'popup-timer-appear-delay'); ?>
			<?php echo $wp_builder_obj->range_slider( 'Popup Auto Close', 'popup-delay-close', ['title'=>'Second','min'=>0,'max'=>500,'value'=>0] ,'popup-timer-autoclose'); ?>
			</section>
		<!-- timer section -->
		<!-- Close button setting -->
		<div data-toggle="close-btn-setting" class="rl_i_editor-element-Toggle outer-toggle rl-active">
			<span>Close Button Setting</span>
			<span class="bottomCarret dashicons dashicons-arrow-right"></span>
		</div>
		<section data-toggle-action="close-btn-setting" class="">

			<div class="rl_i_editor-item-content-items title_ inline__">
				<label>Popup Close option By Click</label>
			</div>
			<div class="rl_i_editor-item-content-items inline__">
							<div class="rl_i_editor-item-color">
								<select data-cmn="close-btn" data-global-input="close-option">
									<option value="1">Click On Icon</option>
									<option value="2">Click On Icon and Outside</option>
									<option value="3" selected="selected">Click On Outside</option>
								</select>
							</div>
			</div>
			
			<section class="close-btn-container">				
			<?php echo $wp_builder_obj->color('Icon Color','color','data-global-input','close-btn-color'); ?>
			<?php echo $wp_builder_obj->color('Icon Background Color','background-color','data-global-input','close-btn-bg-color'); ?>
					<!-- text font size -->
				<?php echo $wp_builder_obj->range_slider( "Icon Font Size", 'close-font-size', ['title'=>'px','min'=>10,'max'=>100,'value'=>18,"attr"=>'data-cmn="close-btn"']); ?>
					<!-- padding  -->
				<div class="rl_i_editor-item-content-items title_ inline_">
					<div class="rl_i_range-font-size"><label>Icon Padding in px</label></div>
					</div>
					<div class="rl_i_editor-item-content-items inline_">
						<div class="rl_i_editor-item-content-padding_ paraMeterContainer__">
							<ul class="ul-inputs-margin-padding rl-clear">
								<li>
									<input type="number" value="" data-cmn="close-btn" data-global-input="close-btn" data-padding="top">
								</li>
								<li>
									<input type="number" value="" data-cmn="close-btn" data-global-input="close-btn" data-padding="right">
								</li>
								<li>
									<input type="number" value="" data-cmn="close-btn" data-global-input="close-btn" data-padding="bottom">
								</li>
								<li>
									<input type="number" value="" data-cmn="close-btn" data-global-input="close-btn" data-padding="left">
								</li>
								<li class="padding-origin_ margin-padding-origin">
									<input id="padding-origin_global_close-btn" type="checkbox" data-cmn="close-btn" data-global-input="close-btn" data-origin="padding">
									<label for="padding-origin_global_close-btn"><span class="dashicons dashicons-admin-links"></span></label>
								</li>
							</ul>							
							<ul class="ul-inputs-text rl-clear">
								<li>TOP</li>
								<li>RIGHT</li>
								<li>BOTTOM</li>
								<li>LEFT</li>
								<li></li>
							</ul>
						</div>
					</div>
					<div class="rl_i_editor-item-content-items title_ inline_">
						<div class="rl_i_range-font-size">
							<label>Button Margin</label>
						</div>
					</div>
					<?php echo $wp_builder_obj->range_slider('Top', 'close-btn', ['title'=>'%','min'=>"-20",'max'=>100,'value'=>18,"attr"=>'data-cmn="close-btn" data-margin="top"'], "close-btn-margin-top"); ?>
					<?php echo $wp_builder_obj->range_slider('Right','close-btn', ['title'=>'%','min'=>"-20",'max'=>100,'value'=>18,"attr"=>'data-cmn="close-btn" data-margin="right"'], "close-btn-margin-right"); ?>
					<!-- border -->
					<section class="content-style-border">
						<div  class="rl_i_editor-item-content-items title_ inline__">
							<div class="rl_i_range-font-size">
								<div class="wppb-popup-checkbox-container">
									<label class="wppb-popup-checkbox-title">Border</label>
									<div class="wppb-popup-checkbox">
										<input id="border-enable-label-11-close-btn" data-cmn="close-btn" type="checkbox" data-global-input="close-btn" data-border='border-enable'>
										<label for="border-enable-label-11-close-btn"></label>
									</div>
								</div>
							</div>
						</div>
						<div  class="rl_i_editor-item-content-items content-border">
							<div>
								<label>Border Width</label>
								<input type="number" value="" data-cmn="close-btn" data-global-input="close-btn" data-border="width">
							</div>
							<div>
								<label>Border radius</label>
								<input type="number" value="" data-cmn="close-btn" data-global-input="close-btn" data-border="radius">
							</div>
							<div>
								<label>Border Color</label>
								<label class="color-output" data-cmn="close-btn" data-input-color="1" data-global-input='border-color'></label>
							</div>
							<div>
								<label>Border Style</label>
								<?php echo $wp_builder_obj->select('data-cmn="close-btn" data-global-input="close-btn" data-border="border-style"',[ ['solid','solid'],['dashed','dashed'],['dotted','dotted'],['double','double'],['groove','groove'],['ridge','ridge'] ]); ?>
							</div>
						</div>
					</section>
					<!-- border -->

			</section>
		<!-- Close button setting -->

		</section>
		<!-- global setting -->
		<section class="rl_i_editor-item-content">
			<div class="rl_i_editor-item-content-tab">
				<div class="rl_i_editor-item-content-header">
					<nav class="rl-clear">
						<span data-editor-tab="content" class="active_">Content</span>
						<span data-editor-tab="style">Style</span>
					</nav>
				</div>
				<!-- content -->
				<div class="rl_i_editor-item-content-i rl_i_editor-item-content-content active_">
					<div>
						<!-- image -->
						<div class="rl_i_editor-item-content-items item-image image_">
							<label>Choose Image</label>
							<div class="rl-i-choose-image">
								<div data-editor-input='img' class="rl-i-choose-image-wrap" style="background-image: url(<?php echo WPPB_URL ?>img/blank-img.png);">
									<div class="rl-i-choose-image-inside-wrap"><span class="iconPlus dashicons dashicons-plus"></span></div>
								</div>
							</div>
						</div>
						<!-- title -->
						<div class="rl_i_editor-item-content-items item-text item-title_ block__">
							<label class="rl_i_editor-title">Title</label>
							<textarea data-editor-input='title'></textarea>
						</div>
						<!-- link -->
						<div class="rl_i_editor-item-content-items item-link_ block__">
							<label class="rl_i_editor-title">Link</label>
							<div class="rl_i_editor-anchor">
								<div class="rl_i_editor-anchor-input">
									<input type="text" data-editor-input='link'>
									<label data-toggle="_linktargetSetting" class="dashicons dashicons-admin-links"></label>
								</div>
								 <div data-toggle-action="_linktargetSetting" class="rl_i_editor-anchor-setting">
								   <div>
									<div>
										<input id="_linkTarget11" data-editor-input='_linktarget' type="radio" name="_linktarget" value="1">
										<label for="_linkTarget11">Another tab</label>
									</div>
									<div>
										<input id="_linkTarget00" data-editor-input='_linktarget' type="radio" name="_linktarget" value="0">
										<label for="_linkTarget00">same tab</label>
									</div>
								  </div>
								</div>
							</div>
						</div>
						<!-- text alignment -->
						<div class="rl_i_editor-item-content-items item-text item-alignment_ inline__">
							<label>Alignment</label>
							<div class="rl_text-alignment">
								<ul class="text-alignment-choice">
									<li>
										<input id="_alignment_left" data-editor-input="alignment" type="radio" name="text-alignment-choice" value="left">
										<label for="_alignment_left" class="dashicons dashicons-editor-alignleft"></label>
									</li>
									<li>
										<input id="_alignment_center" data-editor-input="alignment" type="radio" name="text-alignment-choice" value="center">
										<label for="_alignment_center" class="dashicons dashicons-editor-aligncenter"></label>
									</li>
									<li>
										<input id="_alignment_right" data-editor-input="alignment" type="radio" name="text-alignment-choice" value="right">
										<label for="_alignment_right" class="dashicons dashicons-editor-alignright"></label>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- style -->
				<div class="rl_i_editor-item-content-i rl_i_editor-item-content-style">
					<!-- width -->
		<?php echo $wp_builder_obj->range_slider( 'Width', 'item-width', ['title'=>'%','min'=>1,'value'=>20,'max'=>100],false, 'data-editor-input' ); ?>
					<!-- text alignment -->
						<div class="rl_i_editor-item-content-items item-alignment_ inline__">
							<label>Container Alignment</label>
							<div class="rl_text-alignment">
								<ul class="text-alignment-choice">
									<li>
										<input id="_content_alignment_left" data-editor-input="content-alignment" type="radio" name="item-alignment-choice" value="left">
										<label for="_content_alignment_left" class="dashicons dashicons-editor-alignleft"></label>
									</li>
									<li>
										<input id="_content_alignment_center" data-editor-input="content-alignment" type="radio" name="item-alignment-choice" value="center">
										<label for="_content_alignment_center" class="dashicons dashicons-editor-aligncenter"></label>
									</li>
									<li>
										<input id="_content_alignment_right" data-editor-input="content-alignment" type="radio" name="item-alignment-choice" value="right">
										<label for="_content_alignment_right" class="dashicons dashicons-editor-alignright"></label>
									</li>
								</ul>
							</div>
						</div>
				<!-- text color -->
					<?php echo $wp_builder_obj->color('Text Color','color','data-editor-input'); ?>
					<?php echo $wp_builder_obj->color('Background Color','background-color','data-editor-input'); ?>
				<!-- text font size -->
					<?php echo $wp_builder_obj->range_slider( "Font Size", 'font-size', ['title'=>'px','min'=>10,'value'=>30,'max'=>100,"container-class"=>'item-text'], false , 'data-editor-input' ); ?>
					<?php echo $wp_builder_obj->range_slider( "Letter Spacing", 'letter-spacing', ['title'=>'px','min'=>'-5','value'=>1,'max'=>50,"container-class"=>'item-text'], false , 'data-editor-input' ); ?>
					<?php echo $wp_builder_obj->range_slider( 'Line Height', 'line-height', ['title'=>'px','min'=>'-5','value'=>1,'max'=>100,"container-class"=>'item-text'], false , 'data-editor-input' ); ?>
					<!-- font weight -->
					<div class="rl_i_editor-item-content-items item-text inline__">
							<label>Font Weight</label>
							<div class="rl_i_editor-item-color">
								<?php echo $wp_builder_obj->select('data-editor-input="font-weight"',[ [200,200],[300,300],[400,400],[500,500],[600,600],[700,700],[800,800],[900,900] ]); ?>
								
							</div>
						</div>
					<!-- font weight -->

					<!-- margin  -->
					<div class="rl_i_editor-item-content-items title_ inline_">
						<div class="rl_i_range-font-size">
							<label>Margin in px</label>
						</div>
					</div>
					<div class="rl_i_editor-item-content-items inline_">
						<div class="rl_i_editor-item-content-margin_ paraMeterContainer__">
							<ul class="ul-inputs-margin-padding rl-clear">
								<li>
									<input type="number" value="" data-editor-input="margin" data-margin="top">
								</li>
								<li>
									<input type="number" value="" data-editor-input="margin" data-margin="right">
								</li>
								<li>
									<input type="number" value="" data-editor-input="margin" data-margin="bottom">
								</li>
								<li>
									<input type="number" value="" data-editor-input="margin" data-margin="left">
								</li>
								<li class="margin-origin_ margin-padding-origin">
									<input id="margin-origin_" type="checkbox" data-editor-input="margin-origin">
									<label for="margin-origin_"><span class="dashicons dashicons-admin-links"></span></label>
								</li>
							</ul>
							<ul class="ul-inputs-text rl-clear">
								<li>TOP</li>
								<li>RIGHT</li>
								<li>BOTTOM</li>
								<li>LEFT</li>
								<li></li>
							</ul>
						</div>
					</div>
					<!-- padding  -->
					<div class="rl_i_editor-item-content-items title_ inline_">
					<div class="rl_i_range-font-size"><label>Padding in px</label></div>
					</div>
					<div class="rl_i_editor-item-content-items inline_">
						<div class="rl_i_editor-item-content-padding_ paraMeterContainer__">
							<ul class="ul-inputs-margin-padding rl-clear">
								<li>
									<input type="number" value="" data-editor-input="padding" data-padding="top">
								</li>
								<li>
									<input type="number" value="" data-editor-input="padding" data-padding="right">
								</li>
								<li>
									<input type="number" value="" data-editor-input="padding" data-padding="bottom">
								</li>
								<li>
									<input type="number" value="" data-editor-input="padding" data-padding="left">
								</li>
								<li class="padding-origin_ margin-padding-origin">
									<input id="padding-origin_" type="checkbox" data-editor-input="padding-origin">
									<label for="padding-origin_"><span class="dashicons dashicons-admin-links"></span></label>
								</li>
							</ul>							
							<ul class="ul-inputs-text rl-clear">
								<li>TOP</li>
								<li>RIGHT</li>
								<li>BOTTOM</li>
								<li>LEFT</li>
								<li></li>
							</ul>
						</div>
					</div>
					<!-- border -->
					<section class="content-style-border">
						<div  class="rl_i_editor-item-content-items title_ inline__">
							<div class="rl_i_range-font-size">
								<div class="wppb-popup-checkbox-container">
									<label class="wppb-popup-checkbox-title">Border</label>
									<div class="wppb-popup-checkbox">
										<input id="border-enable-label-11" data-border='1' type="checkbox" data-editor-input="border-enable">
										<label for="border-enable-label-11"></label>
									</div>
								</div>
							</div>
						</div>
						<div  class="rl_i_editor-item-content-items content-border">
							<div>
								<label>Border Width</label>
								<input type="number" value="" data-editor-input="border" data-border="width">
							</div>
							<div>
								<label>Border radius</label>
								<input type="number" value="" data-editor-input="border" data-border="radius">
							</div>
							<div>
								<label>Border Color</label>
								<label class="color-output" data-input-color="1" data-editor-input='border-color'></label>
							</div>
							<div>
							<label>Border Style</label>							
								<?php echo $wp_builder_obj->select('data-editor-input="border" data-border="border-style"',[ ['solid','solid'],['dashed','dashed'],['dotted','dotted'],['double','double'],['groove','groove'],['ridge','ridge'] ]); ?>
							</div>
						</div>
					</section>
					<!-- border -->
				</div>
				<!-- style -->
			</div>
		</section>
		<!-- delete Setting -->
		<?php if(isset($wppb_popup_id)) { ?>
			<div data-toggle="popup-delete-opt" class="rl_i_editor-element-Toggle outer-toggle">
				<span>Popup Delete</span>
				<span class="bottomCarret dashicons dashicons-arrow-right"></span>
			</div>
			<section data-toggle-action="popup-delete-opt" class="rl-popup-delete-opt rl-display-none">
				<div>
					<div class="popup-delete-wrap"><?php echo $popupSetData['deletebtn']; ?></div>
						<div class="wppb-popup-checkbox-container">
							<label class="wppb-popup-checkbox-title">Activate</label>
							<div class="wppb-popup-checkbox">
								<input id="wppb_popup--<?php echo $wppb_popup_id ?>" type="checkbox" class="wppb_popup_setting_active" data-bid="<?php echo $wppb_popup_id ?>" <?php echo $popup_is_active ?>>
								<label for="wppb_popup--<?php echo $wppb_popup_id ?>"></label>
							</div>
						</div>
				</div>
			</section>
		<?php } ?>
		<!-- delete Setting -->
		<!-- add lead form -->
		<section class="rl-display-none rl-lead-form-panel">
			<div class="rl_i_editor-element-Toggle">
				<span>Lead Form Form</span>
			</div>
			<div class="rl_i_editor-header-title">
				<label>Choose Lead Form</label>
			</div>
			<div class="rl_i_editor-item-content-items lead-form-bulider-select">
				<select>
					<option>Select Form</option>
					<?php echo wppb_db::lead_form_opt(); ?>
				</select>
			</div>
		</section>
		<!-- add lead form -->
	</div>
	</div>

			<div class="rl_i_editor-footer">
				<div class="rl_i_editor-footer-area">
					<?php echo $popupSetData['savebtn']; ?>
				</div>
			</div>
	</div>
</div>