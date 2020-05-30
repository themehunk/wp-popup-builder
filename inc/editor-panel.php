<div class="rl_i_editor-inner-wrap">
	<div class="rl_i_editor-wrap-in">
		<div class="rl_i_editor-header">
			<div class="rl_i_editor-header-area">
				<span>Real Time Editor</span>
			</div>
		</div>
	<div class="rl_i_editor-content">
	<div class="rl_i_editor-content-area">
		<button class="wppb-export-sub">Export Popup</button>
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
			<?php $wp_builder_obj->header_title('Popup Name'); ?>
			<input data-global-input="popup-name" type="text" name="global-popup-name">			
			<?php $wp_builder_obj->header_title('Popup Background Setting');
			echo $wp_builder_obj->checkbox('global-overlay-image','Background Image','data-global-input="global-overlay-image"'); 
			?>
		<section class="global-overlay-image">
			<div class="rl_i_editor-item-content-items image_">
				<div class="rl-i-choose-image">
					<div data-global-input='overlay-image' class="rl-i-choose-image-wrap" style="background-image: url(<?php echo WPPB_URL ?>img/blank-img.png);">
						<div class="rl-i-choose-image-inside-wrap"><span class="iconPlus dashicons dashicons-plus"></span></div>
					</div>
				</div>
				<div class="background-image-setting">
						<span class="rl-sub-title">Background Position</span>
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
							<label class="rl-sub-title">Background Size</label>
							<div>
								<?php echo $wp_builder_obj->select("data-global-input='background-size'",[ ['Auto','auto'],['Contain','contain'],['Cover','cover'] ]); ?>
							</div>
						</div>
					</div>
			</div>
		</section>
			<?php 
				// overlay color / outside color / popup width 
				$wp_builder_obj->color('Background Color','background-color','data-global-input','overlay-color'); 
				$wp_builder_obj->color('Outside Color','background-color','data-global-input','outside-color');
				$wp_builder_obj->header_title('Popup Typography');
				$wp_builder_obj->range_slider('Popup Width', 'main-wrapper', ['title'=>'px','min'=>200,'max'=>800,'value'=>200] ,'wrapper-width');
				echo $wp_builder_obj->checkbox('wrapper-height','Popup Height Auto/Custom','data-global-input="wrapper-height-check"');
			?>
			<section class="global-wrapper-height-custom-auto">
			<?php  $wp_builder_obj->range_slider('Custom Height','main-wrapper-height', ['title'=>'px','min'=>150,'max'=>1000,'value'=>200] ,'wrapper-height'); ?>
			</section>
			<?php 
				$wp_builder_obj->margin_padding('main-wrapper', 'Popup Padding in px', 'data-global-input', 'p'); 
				$wp_builder_obj->border('global-border','data-global-input'); 
			?>
			<div class="rl_i_editor-item-content-items rl-two-column-width">
				<label class="rl-sub-title">Container Width</label>
				<div>
					<label class="rl-sub-title">Column One %</label>
					<label class="rl-sub-title">Column Two %</label>
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
				<?php 
					$wp_builder_obj->range_slider('Popup Appear Delay in Second', 'popup-delay-open', ['title'=>'sec','min'=>3,'max'=>60,'value'=>4] ,'popup-timer-appear-delay');
					$wp_builder_obj->range_slider( 'Popup Auto Close in Second', 'popup-delay-close', ['title'=>'sec','min'=>0,'max'=>500,'value'=>0] ,'popup-timer-autoclose'); 
				?>
			</section>
		<!-- timer section -->
		<!-- Close button setting -->
		<div data-toggle="close-btn-setting" class="rl_i_editor-element-Toggle outer-toggle rl-active">
			<span>Close Button Setting</span>
			<span class="bottomCarret dashicons dashicons-arrow-right"></span>
		</div>
		<section data-toggle-action="close-btn-setting" class="">
			<div class="rl_i_editor-item-content-items title_ inline__">
				<label class="rl-sub-title">Popup Close option By Click</label>
			</div>
			<div class="rl_i_editor-item-content-items inline__">
					<div>
					<?php echo $wp_builder_obj->select('data-cmn="close-btn" data-global-input="close-option"',[ ['Click On Icon',1],['Click On Icon and Outside',2],['Click On Outside',3,true] ]); ?>
					</div>
			</div>
			<section class="close-btn-container">				
			<?php 
			 	$wp_builder_obj->color('Icon Color','color','data-global-input','close-btn-color',"data-cmn='close-btn'");
				$wp_builder_obj->color('Icon Background Color','background-color','data-global-input','close-btn-bg-color',"data-cmn='close-btn'"); 
				$wp_builder_obj->range_slider( "Icon Font Size", 'close-font-size', ['title'=>'px','min'=>10,'max'=>100,'value'=>18,"attr"=>'data-cmn="close-btn"']);
				$wp_builder_obj->margin_padding('close-btn', 'Icon Padding in px', 'data-global-input', 'p', 'data-cmn="close-btn"'); 
			?>
			<div class="rl_i_editor-item-content-items title_ inline_">
				<div class="rl_i_range-font-size">
					<label class="rl-sub-title">Button Margin</label>
				</div>
			</div>
			<?php 
				$wp_builder_obj->range_slider('Top', 'close-btn', ['title'=>'%','min'=>"-20",'max'=>100,'value'=>18,"attr"=>'data-cmn="close-btn" data-margin="top"'], "close-btn-margin-top");
				$wp_builder_obj->range_slider('Right','close-btn', ['title'=>'%','min'=>"-20",'max'=>100,'value'=>18,"attr"=>'data-cmn="close-btn" data-margin="right"'], "close-btn-margin-right"); 
				$wp_builder_obj->border('close-btn','data-global-input',"data-cmn='close-btn'"); 
			?>
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
							<label class="rl-sub-title">Choose Image</label>
							<div class="rl-i-choose-image">
								<div data-editor-input='img' class="rl-i-choose-image-wrap" style="background-image: url(<?php echo WPPB_URL ?>img/blank-img.png);">
									<div class="rl-i-choose-image-inside-wrap"><span class="iconPlus dashicons dashicons-plus"></span></div>
								</div>
							</div>
						</div>
						<!-- title -->
						<div class="rl_i_editor-item-content-items item-text item-title_ block__">
							<label class="rl_i_editor-title rl-sub-title">Title</label>
							<textarea data-editor-input='title'></textarea>
						</div>
						<!-- link -->
						<div class="rl_i_editor-item-content-items item-link_ block__">
							<label class="rl_i_editor-title rl-sub-title">Link</label>
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
						<?php echo $wp_builder_obj->alignment('Alignment','text-alignment-choice','data-editor-input'); ?>
					</div>
				</div>
				<!-- style -->
				<div class="rl_i_editor-item-content-i rl_i_editor-item-content-style">
					<!-- width -->
					<?php  
					$wp_builder_obj->range_slider( 'Width', 'item-width', ['title'=>'%','min'=>1,'value'=>20,'max'=>100],false, 'data-editor-input' );
					echo $wp_builder_obj->alignment('Container Alignment','content-alignment','data-editor-input'); 
					// text color/ background-color / font-size / letter-spacing / line height
						$wp_builder_obj->color('Text Color','color','data-editor-input'); 
						$wp_builder_obj->color('Background Color','background-color','data-editor-input');
						$wp_builder_obj->range_slider( "Font Size", 'font-size', ['title'=>'px','min'=>10,'value'=>30,'max'=>100,"container-class"=>'item-text'], false , 'data-editor-input' );
						$wp_builder_obj->range_slider( "Letter Spacing", 'letter-spacing', ['title'=>'px','min'=>'-5','value'=>1,'max'=>50,"container-class"=>'item-text'], false , 'data-editor-input' );
						$wp_builder_obj->range_slider( 'Line Height', 'line-height', ['title'=>'px','min'=>'-5','value'=>1,'max'=>100,"container-class"=>'item-text'], false , 'data-editor-input' ); 
						?>
					<!-- font weight -->
					<div class="rl_i_editor-item-content-items item-text inline__">
						<label class="rl-sub-title">Font Weight</label>
						<div>
							<?php echo $wp_builder_obj->select('data-editor-input="font-weight"',[ [200,200],[300,300],[400,400],[500,500],[600,600],[700,700],[800,800],[900,900] ]); ?>
							
						</div>
					</div>
					<?php 
						  $wp_builder_obj->margin_padding('margin', 'Margin in px', 'data-editor-input', 'm');
						  $wp_builder_obj->margin_padding('padding', 'Padding in px', 'data-editor-input', 'p');
						  $wp_builder_obj->border('border','data-editor-input'); 
					?>
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
					<?php echo $wp_builder_obj->checkbox('popup_setting_active','Activate','class="wppb_popup_setting_active" data-bid="'.$wppb_popup_id.'"'.$popup_is_active); ?>
				</div>
			</section>
		<?php } ?>
		<!-- delete Setting -->
		<!-- add lead form -->
		<section class="rl-display-none rl-lead-form-panel">
			<div class="rl_i_editor-element-Toggle">
				<span>Lead Form Form</span>
			</div>
			
			<div class="rl_i_editor-item-content-items title_ inline__">
				<label class="rl-sub-title">Choose Lead Form</label>
			</div>

			<div class="rl_i_editor-item-content-items lead-form-bulider-select">
				<select>
					<option>Select Form</option>
					<?php echo wppb_db::lead_form_opt(); ?>
				</select>
			</div>
			<div class="wppb-lead-form-styling">
				<div class="rl_i_editor-item-content-header">
					<nav class="rl-clear">
						<span data-editor-tab="form-style" class="active_">Form</span>
						<span data-editor-tab="form-content">Form Content</span>
					</nav>
				</div>
				<!-- form-style -->
				<div class="rl_i_editor-item-content-i rl_i_editor-item-content-form-style active_  wppb-lf-form-style">
					<?php 
						$wp_builder_obj->header_title('Form Setting');
						$wp_builder_obj->range_slider('Form Width', 'lf-form-width', ['title'=>'%','min'=>"20",'max'=>100,'value'=>100], false, 'data-lead-form'); 
						// echo $wp_builder_obj->checkbox($id,$title,$attr);
						echo $wp_builder_obj->checkbox("form-margin-center","Form Centered",'data-lead-form="form-margin-center"');
						$wp_builder_obj->color('Background Color','background-color','data-lead-form','lf-form-color');
						$wp_builder_obj->border('form-border','data-lead-form'); 
					?>
				</div>
				<!-- heading style -->
				<div class="rl_i_editor-item-content-i rl_i_editor-item-content-form-content wppb-lf-content-style">
				 <?php 
					$wp_builder_obj->header_title('Heading Setting');
					echo $wp_builder_obj->checkbox("form-heading-enable","Heading Enable",'data-lead-form="form-heading-enable"');
					$wp_builder_obj->color('Color','color','data-lead-form','lf-heading-color');
					$wp_builder_obj->range_slider('Font Size', 'lf-heading-font-size', ['title'=>'px','min'=>"10",'max'=>100,'value'=>10], false, 'data-lead-form');
					$wp_builder_obj->header_title('Label Setting');
					$wp_builder_obj->color('Color','color','data-lead-form','lf-label-color');
					$wp_builder_obj->range_slider('Font Size', 'lf-label-font-size', ['title'=>'px','min'=>"10",'max'=>100,'value'=>10], false, 'data-lead-form');

					$wp_builder_obj->header_title('Field Setting');
					$wp_builder_obj->color('Color','color','data-lead-form','lf-field-color');
					$wp_builder_obj->color('Background Color','background-color','data-lead-form','lf-field-background-color');
					$wp_builder_obj->range_slider('Font Size', 'lf-field-font-size', ['title'=>'px','min'=>"10",'max'=>100,'value'=>10], false, 'data-lead-form');
					$wp_builder_obj->border('lf-field-border','data-lead-form'); 

					$wp_builder_obj->header_title('Submit Button Setting');
					$wp_builder_obj->color('Color','color','data-lead-form','lf-submit-btn-color');
					$wp_builder_obj->color('Background Color','background-color','data-lead-form','lf-submit-btn-bcolor');
					$wp_builder_obj->range_slider('Font Size', 'lf-submit-btn-font-size', ['title'=>'px','min'=>"10",'max'=>100,'value'=>10], false, 'data-lead-form'); 
					$wp_builder_obj->border('lf-submit-border','data-lead-form');
					echo $wp_builder_obj->alignment('Button Alignment','lf-submit-aliment','data-lead-form'); 
				?>
					<div class="rl_i_editor-item-content-items item-text inline__">
						<label class="rl-sub-title">Font Weight</label>
						<div>
							<?php echo $wp_builder_obj->select('data-lead-form="submit-font-weight"',[ [200,200],[300,300],[400,400],[500,500],[600,600],[700,700],[800,800],[900,900] ]); ?>
							
						</div>
					</div>
					<?php $wp_builder_obj->margin_padding('lf-submit-padding', 'Padding in px', 'data-lead-form', 'p'); ?>
				</div>
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