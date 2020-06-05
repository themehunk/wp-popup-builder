(function(jQuery){
var Business_news_letter = {
	init:function(){
		Business_news_letter._bind();
	},
	_saveBusinessAddon:function(){
		let this_btn = jQuery(this);
		this_btn.addClass('rlLoading');
		let saveData = Business_news_letter._saveData();
			let data_ = {action:'custom_insert',htmldata:saveData};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				if (response && response != 0) {
		        		let pathName = window.location.pathname + window.location.search + "=" +response;
						window.history.replaceState(null,null,pathName);
						location.reload();
		        	}
			});
	},
	_updateAddon:function(){
		let this_btn = jQuery(this);
		this_btn.addClass('rlLoading');
		let saveData = Business_news_letter._saveData();
		let bid = this_btn.data('bid');
			let data_ = {action:'custom_update',htmldata:saveData,bid:bid};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				if (response || response == 0) {
		        		setTimeout(()=>this_btn.removeClass('rlLoading'),1000);
		        	}
			});
	},
	_exportPopup:function(){
		let saveData = Business_news_letter._saveData();
		let uniqId = Math.floor(Math.random() * Date.now());
		let filename = 'wppb-'+uniqId+'-builder.json';
		let jsonStr = JSON.stringify(saveData);
		let anchor_ = document.createElement('a');
		anchor_.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(jsonStr));
		anchor_.setAttribute('download', filename);
		anchor_.style.display = 'none';
		document.body.appendChild(anchor_);
		anchor_.click();
		document.body.removeChild(anchor_);
	},
	_initGlobalSave:function(inputs){
			let contentGlobal = jQuery('input[type="hidden"][data-global-save]');
			contentGlobal = contentGlobal.val() ? JSON.parse(contentGlobal.val()) : {};
			let outerParent = jQuery('.wppb-popup-custom');
			let overlayImage = outerParent.find('[data-overlay-image]');
			// overlay color set
			let overLayColor = outerParent.find('.wppb-popup-custom-overlay');
			overLayColor = Custom_popup_editor._checkStyle(overLayColor,'background-color');
			if(overLayColor) contentGlobal['overlay-color'] = overLayColor;
			// outside color set
			let outSideColor = Custom_popup_editor._checkStyle(outerParent,'background-color');
			if(outSideColor) contentGlobal['outside-color'] = outSideColor;
			// outside color set
			let globalPadding = outerParent.find('.wppb-popup-custom-content');
			globalPadding = Custom_popup_editor._checkStyle(globalPadding,'padding');
			if(outSideColor) contentGlobal['global-padding'] = globalPadding;

			if(overlayImage.attr('data-overlay-image')){
				contentGlobal['overlay-image-url'] = overlayImage.attr('data-overlay-image');
			}else{
				if(contentGlobal['overlay-image-url']) delete contentGlobal['overlay-image-url'];
			}
			let wrapperWidth = outerParent.find('.wppb-popup-custom-wrapper');
			if ( wrapperWidth.attr('style') )contentGlobal['wrapper-style'] = wrapperWidth.attr('style');
			let overlayStyle = Custom_popup_editor._removeStyle(overlayImage,"background-image",false)
			if(overlayStyle) contentGlobal['overlay-style'] = overlayStyle;
			// popup name
			let popupName = jQuery('input[name="global-popup-name"]').val();
			contentGlobal['popup-name'] = popupName;
			return {type:'global-setting',content:contentGlobal };
	},
	_saveData:function(){
		let getSaveData = jQuery('.wppb-popup-custom');
		let getSaveDataWrap = getSaveData.find('[data-rl-wrap]');
		let saveData = [];
		let getSaveGlobal = Business_news_letter._initGlobalSave();
		if (!jQuery.isEmptyObject(getSaveGlobal.content)) saveData.push(getSaveGlobal);
		// find all wrap 
		jQuery.each(getSaveDataWrap,(Wrap_index,Wrap_value)=>{
			let get_column = jQuery(Wrap_value).find('[data-rl-column]');
			let wrap_content = {type:'wrap',content:_columnGet(get_column)};
			if (jQuery(Wrap_value).attr('data-uniqid'))wrap_content['id'] = jQuery(Wrap_value).attr('data-uniqid');
			saveData.push(wrap_content);
		});
		// close btn 
		if ( _getClosebtn() ) saveData.push( _getClosebtn() );

				function _getClosebtn(){
					let closebtn = jQuery('.wppb-popup-custom .wppb-popup-close-btn');
					if (closebtn.length) {
						let returnData = {type:'close-btn'};
						if (closebtn.attr('style'))returnData['style'] = closebtn.attr('style');
						if (closebtn.attr('data-uniqid'))returnData['id'] = closebtn.attr('data-uniqid');
						return returnData;
					}
				}

				function _columnGet(column_){
					let column_Data = [];
					jQuery.each(column_,(Column_index,Column_value)=>{
						let column_data_ = jQuery(Column_value);
						let data_column = column_data_.find('[data-rl-editable], .wppb-popup-lead-form');
						let column_content = {type:'column',content:_contentGet(data_column)};
						if (column_data_.attr('data-uniqid'))column_content['id'] = column_data_.attr('data-uniqid');
						if (column_data_.attr('style'))column_content['style'] = column_data_.attr('style');

						column_Data.push(column_content);
					});
					return column_Data;
				}

				function _contentGet(getSaveDataInputs){
						let content_data = [];
						if (!getSaveDataInputs.length) {
							return false;
						}else{
							jQuery.each(getSaveDataInputs,(index,value)=>{
								let checkInput = jQuery(value);
								let saveAttrData = '';
								if ( checkInput.hasClass('wppb-popup-lead-form') ) {
									saveAttrData = {type:'lead-form',content:checkInput.attr('data-form-id')};
										if (checkInput.attr('data-uniqid'))saveAttrData['id'] = checkInput.attr('data-uniqid');
												let leadForm = checkInput.find('form');
												let leadFormStyle = {};
												if ( leadForm.attr('style') ) leadFormStyle['form-style'] = leadForm.attr('style');
												if ( leadForm.find('h2').attr('style') ) leadFormStyle['heading-style'] = leadForm.children('h2').attr('style');
												if ( leadForm.find('.text-type.lf-field > label').attr('style') ) leadFormStyle['label-style'] = leadForm.find('.text-type.lf-field > label').attr('style');

												if ( leadForm.find('.text-type.lf-field input').attr('style') ) leadFormStyle['field-style'] = leadForm.find('.text-type.lf-field input').attr('style');

												if ( leadForm.find('.lf-form-submit').attr('style') ) leadFormStyle['submit-style'] = leadForm.find('.lf-form-submit').attr('style');

												if ( leadForm.find('.lf-form-submit').attr('data-alignment') ) leadFormStyle['submit-align'] = leadForm.find('.lf-form-submit').attr('data-alignment');

												saveAttrData['styles'] = leadFormStyle;

								}else{
									saveAttrData = {type:checkInput.data('rl-editable'),content:checkInput.html()};
									if (checkInput.attr('style'))saveAttrData['style'] = checkInput.attr('style');
									if (checkInput.data('editor-link'))saveAttrData['link'] = checkInput.attr('data-editor-link');
									if (checkInput.data('editor-link-target') && saveAttrData['link'])saveAttrData['target'] = checkInput.attr('data-editor-link-target');
									if (checkInput.data('content-alignment'))saveAttrData['alignment'] = checkInput.attr('data-content-alignment');
									if (checkInput.attr('data-uniqid'))saveAttrData['id'] = checkInput.attr('data-uniqid');
									// image condition
									if (checkInput.data('rl-editable') == 'image'){
										saveAttrData['image-url'] = checkInput.attr('src');
									}
								}
								content_data.push(saveAttrData);
							});
							return content_data;
						}
				}
		
		return saveData;
	},
	_deleteAddon:function(){
		let this_btn = jQuery(this);
		let bid  = this_btn.data('bid');
		jQuery('.resetConfirmPopup').addClass('active');
		
		jQuery('.wppbPopup.deny').click(function(e){
			e.preventDefault();
			jQuery('.resetConfirmPopup').removeClass('active');
		});

			jQuery(document).mouseup(function(e){
				var resetWrapper = jQuery('.resetWrapper');
				 if (!resetWrapper.is(e.target) && resetWrapper.has(e.target).length === 0){
						jQuery('.resetConfirmPopup').removeClass('active');
                 }
			});
		jQuery('.wppbPopup.confirm').click(function(e){
			jQuery(this).addClass('rlLoading');
			e.preventDefault();

			let data_ = {action:'delete_popup',bid:bid};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				if (response || response == 0) {
		        		setTimeout(()=>{
		        		let pathName = window.location.pathname + "?page=wppb";
		        			window.location.href = pathName;
		        		},1000);
		        	}
			});
	});


	},
	_businessTabSetting:function(e){
				e.preventDefault();
				let tabActive = 'active';
				let currentLink = jQuery(this);
				currentLink.siblings().removeClass(tabActive);
				currentLink.addClass(tabActive);
				// for tab change
				let getTabActive = currentLink.data('tab');
				jQuery('.wppb-popup-tab-container').removeClass(tabActive);
				if (getTabActive == 'setting') {
					jQuery('.wppb-popup-demo.wppb-popup-tab-container').addClass(tabActive);
				}else if(getTabActive == 'option'){
					jQuery('.wppb-popup-option.wppb-popup-tab-container').addClass(tabActive);
				}
	},
	_businessOptionUpdate:function(e){
		var thisCheckBox = jQuery(this);
		var bid = thisCheckBox.closest('.wppb-opt-page-opt').data('bid');
		var option_key = thisCheckBox.data('name');
		let option_value = thisCheckBox.prop('checked') == true?1:0;
		// disable all on enable all pages and post
		var checkBoxDisable = thisCheckBox.closest('.wppb-popup-checkbox');
			checkBoxDisable.addClass('business_disabled');
		let data_ = {action:'option_update',popup_id:bid,option_key:option_key,option_value:option_value};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				if (response) {
		        		jQuery('.wppb-popup-optSaved-msg').fadeIn('slow');
		        		if (response == 22){
		        			var optMsg;
		        			if(option_key == 'home_page'){
		        				optMsg = 'Home Page';
		        			}else if(option_key == 'pages'){
		        				optMsg = 'Pages';
		        			}else if(option_key == 'post'){
		        				optMsg = 'Post';
		        			}
		        			jQuery('.wppb-popup-optPopup-msg').fadeIn().children('.opt_name').html(optMsg+" Popup Is Already On.");
		        			jQuery('.optClose').unbind().click(function(){
		        				jQuery(this).closest('.wppb-popup-optPopup-msg').fadeOut();	
		        			});
		        		}
		        	}
		        	setTimeout(function(){
		        		checkBoxDisable.removeClass('business_disabled');
		        		jQuery('.wppb-popup-optSaved-msg').fadeOut(1000);
		        	},1000);
			});

	},_ajaxFunction:function(data_){
		return jQuery.ajax({method:'post',
						url: wppb_ajax_backend.wppb_ajax_url,
				        data:data_
					  });
	},
	_savePopupActiveDeactive:function(){
	    	let this_button = jQuery(this);
	       	let popup_id  	= this_button.data('bid');
	    	let isActive 	= this_button.prop('checked') == true?1:0;
			this_button.addClass('business_disabled');
			let data_ = {action:'popup_active',bid:popup_id,is_active:isActive};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				// console.log(response);
				if (response) {
					this_button.removeClass('business_disabled');
				}
			});
	},
	_installNow: function(event){
			event.preventDefault();
			var $button 	= jQuery( event.target );
				jQuery(this).addClass('rlLoading');
				$document   = jQuery(document);
			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}
			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event );
				$document.on( 'credential-modal-cancel', function() {
					var $message = jQuery( '.install-lead-form-btn' );
					$message
						.addClass('active-lead-form-btn')
						.removeClass( 'updating-message install-lead-form-btn' )
						.text( wp.updates.l10n.installNow );
					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
				} );
			}
			wp.updates.installPlugin( {
				slug: 'lead-form-builder'
			} );
	},
	_activatePlugin: function( event, response ) {
			event.preventDefault();
			jQuery(this).addClass('rlLoading');
			let button = jQuery( '.install-lead-form-btn' );
			let timining = 100;
			if ( 0 === button.length ) {
				button = jQuery( '.active-lead-form-btn' );
				timining = 1000;
			}
			setTimeout( function(){
					let data_ = {action:'activate_lead_form'};
					let returnData = Business_news_letter._ajaxFunction(data_);
					returnData.success(function(response){
						console.log(response);
						if (response.data.success) {
							button.remove();
							jQuery('.lead-form-bulider-select').show();
							jQuery('.lead-form-bulider-select select').html('<option>select form</option>'+response.data.success);
						}
					});
			},timining );

		},
		_pluginInstalling: function(event, args) {
			event.preventDefault();
			let leadFormBtn = jQuery( '.install-lead-form-btn' );
			leadFormBtn.addClass('updating-message');
		},_installError: function( event, response ) {
			var $card = jQuery( '.install-lead-form-btn' );
			$card
				.removeClass( 'button-primary' )
				.addClass( 'disabled' )
				.html( wp.updates.l10n.installFailedShort );
		},
	_bind(){
		jQuery(document).on('click', '.wppb_popup_saveAddon', Business_news_letter._saveBusinessAddon);
		jQuery(document).on('click', '.wppb_popup_updateAddon', Business_news_letter._updateAddon);
		jQuery(document).on('click', '.wppb_popup_deleteAddon', Business_news_letter._deleteAddon);
		jQuery(document).on('click', '.wppb-popup-cmn-nav-item > a.wppb-popup-tab', Business_news_letter._businessTabSetting);

		jQuery(document).on('change', '.wppb-popup-option input[type="checkbox"]', Business_news_letter._businessOptionUpdate);
		jQuery(document).on('change','.wppb_popup_setting_active', Business_news_letter._savePopupActiveDeactive);

		jQuery(document).on('click','.wppb-export-sub', Business_news_letter._exportPopup);

		// lead form install
			jQuery( document ).on('click' , '.install-lead-form-btn', Business_news_letter._installNow );
			jQuery( document ).on('click' , '.active-lead-form-btn', Business_news_letter._activatePlugin);
			jQuery( document ).on('wp-plugin-install-success' , Business_news_letter._activatePlugin);
			jQuery( document ).on('wp-plugin-installing'      , Business_news_letter._pluginInstalling);
			jQuery( document ).on('wp-plugin-install-error'   , Business_news_letter._installError);
		
	}
}
// business popup editor functionlity
var Custom_popup_editor = {
	init:function(){
		Custom_popup_editor._popupEditorInit();
		Custom_popup_editor._bind();
	},
	_popupEditorInit:function(){
		//link same tab and another tab setting
		jQuery('.rl_i_editor-item-content-header [data-editor-tab]').click(function(){
			let thisButton = jQuery(this);
			thisButton.closest('.rl_i_editor-item-content-header').siblings('.rl_i_editor-item-content-i').removeClass('active_');
			thisButton.addClass('active_').siblings().removeClass('active_');
			jQuery('.rl_i_editor-item-content-'+thisButton.data('editor-tab')).addClass('active_');
		});

		jQuery('[data-toggle]').click(function(){
			// close container while open content style
			let clickTarget = jQuery(this);
			clickTarget.siblings().removeClass('rl-active');
			let getContainer = clickTarget.data('toggle');
			clickTarget.toggleClass('rl-active');
			jQuery('[data-toggle-action="'+getContainer+'"]').siblings('[data-toggle-action]').slideUp('fast');
			jQuery('[data-toggle-action="'+getContainer+'"]').slideToggle('fast');
			// hide style element 
			if(clickTarget.hasClass('outer-toggle')) jQuery('.rl_i_editor-item-content').slideUp('fast');
			jQuery('.rl-lead-form-panel').hide();
		});
		Custom_popup_editor._dragAndShort();
		Custom_popup_editor._globalSettingInit();
		Custom_popup_editor._leadFormInit();
	},
	_dragAndShort:function(){
		jQuery( ".wppb-popup-custom .rlEditorDropable" ).sortable({
	      revert: true,
	      placeholder: "ui-state-highlight",
	      cursor: "move",
	      // cancel:'.contentEditable',
	      update:function(){
	      	let droppedContainer = jQuery(this);
	      	if(droppedContainer.children().length > 1)droppedContainer.children('.rl_rmBlankSpace').remove();
	      }
	    });

		jQuery( ".rl_i_editor-element-add-item-list [data-item-drag]" ).draggable({
	      connectToSortable: ".wppb-popup-custom .rlEditorDropable",
	      helper: "clone",
	      revert: "invalid",
	      stop:function(event,ui){
	      	Custom_popup_editor._initAfterDrag(ui.helper);
	      }
	    });
	},
	_initAfterDrag:function(myObj){
	        	let editable,defaultText,extraAttr;
	        	let checkDragItem = myObj.data('item-drag');
	        	if(checkDragItem == 'text'){
	      			defaultText = 'Add Your Text Here';
	        		editable = 'text';
	        	}else if (checkDragItem == 'heading') {
	        		defaultText = 'Add Your Heading Here';
	        		editable = 'heading';
	        		extraAttr = {class:'text-heading'}
	        	}else if (checkDragItem == 'link') {
	        		defaultText = 'Link Text';
	        		editable = 'link';
	        		extraAttr = {'data-editor-link':'#',
	        					 'data-editor-link-target':'0',
	        					 style:"width:fit-content;padding: 6px 12px;border:1px solid #ffffff;",'data-content-alignment':"center"
	        					}
	        	}else if(checkDragItem == 'lead-form'){
					defaultText = 'Please Select Form';
	        		editable = 'lead-form';
	        		extraAttr = {class:'wppb-popup-lead-form',id:'lf-business-popup'}
	      		}
	        	let putAttr = {'data-rl-editable':editable};
				if (extraAttr)putAttr = jQuery.extend(putAttr,extraAttr);

	   			let newElement = Custom_popup_editor._addElement(putAttr,checkDragItem,defaultText);

	      		myObj.css('visibility','hidden');
	      		setTimeout(function(){myObj.replaceWith(newElement)},600);
	},
	_addElement:function(putAttr,checkDragItem,defaultText){
		let putHtml = '<div class="data-rl-editable-wrap">';
			putHtml += '<div class="actions_"><span class="dashicons dashicons-no rlRemoveElement"></span></div>';
			putHtml += '<span>'+defaultText+'</span>';
			putHtml += '</div>';
			let newElement = jQuery(putHtml);
        	newElement.children('span').attr(putAttr);
      		if (checkDragItem == 'image') {
      			let imageUrl = jQuery('input[name="popup-url"]').val();
      			let iMg = '<img src="'+imageUrl+'img/blank-img.png" style="width: 210px;" data-rl-editable="image">';
      			newElement.children('span').replaceWith(iMg);
      		}else if (checkDragItem == 'link') {
				newElement.css('justify-content','center');
      		}else if(checkDragItem == 'lead-form'){
				newElement.css('justify-content','center');
				newElement.children('span').removeAttr('data-rl-editable');
      		}
	      return newElement;
	},
	_openEditPanel:function(){
		let clickedObj = jQuery(this);
		let clickedObjData1 	= clickedObj.data('rl-editable');

		if (jQuery('.rl-editable-key-action').length)jQuery('.rl-editable-key-action').removeClass('rl-editable-key-action');
		clickedObj.addClass('rl-editable-key-action');
		let wrapperContent = jQuery('.rl_i_editor-item-content');

		// close container while open content style
		jQuery('.rl-lead-form-panel').hide();
		let toggleContainer = jQuery(".rl_i_editor-element-Toggle");
		jQuery.each(toggleContainer,(index,value)=>{
			let separateToggle = jQuery(value);
			let separateToggleData = separateToggle.data('toggle');
			if (separateToggleData == 'add-itemes' || separateToggleData == 'global-setting' || separateToggleData == 'close-btn-setting') {
				separateToggle.removeClass('rl-active');
				jQuery('[data-toggle-action="'+separateToggleData+'"]').slideUp('slow');
			}
		});

		if (clickedObjData1 != "image") {
			jQuery('.rl_i_editor-item-content .item-image').hide();
			jQuery('.rl_i_editor-item-content .item-text').show();
		}else if (clickedObjData1 == "image") {
			jQuery('.rl_i_editor-item-content .item-image').show();
			jQuery('.rl_i_editor-item-content .item-text').hide();
		}
		// close container while open content style
		wrapperContent.slideDown('slow');
		let allInputs = wrapperContent.find('[data-editor-input]');
		let initInput_ = (index,value)=>{
			let seperateInput 		= jQuery(value);
			let seperateInputData1 	= seperateInput.data('editor-input');
			// reset value
			if (value.type == "radio" || value.type == "checkbox") {
				seperateInput.prop('checked',false);
			}else if (value.type == "text" || value.type == "textarea" || value.type == 'number'){	
				seperateInput.val("");
			}
			// reset value
			if((clickedObjData1 == 'text' || clickedObjData1 == 'link' || clickedObjData1 == 'heading') && seperateInputData1 == 'title'){
				// get text of clicked item 
				seperateInput.val(clickedObj.html());
			}else if(seperateInputData1 == 'link'){
				// get link href of clicked item
				clickedObj.data('editor-link')?seperateInput.val(clickedObj.data('editor-link')):seperateInput.val('#');
			}else if(clickedObj.data('editor-link') && seperateInputData1 == '_linktarget'){
				if (clickedObj.data('editor-link-target') == 1 && seperateInput.val() == 1) {
					seperateInput.prop('checked',true);
				}else if (seperateInput.val() == 0) {
					seperateInput.prop('checked',true);
				}
			}else if( seperateInput.data('input-color') && seperateInputData1 != 'border'){
					Custom_popup_editor._colorPickr(seperateInput,clickedObj,seperateInputData1);
			}else if(seperateInputData1 == 'text-alignment-choice'){
				let getAlignment = clickedObj.css('text-align');
				if (seperateInput.val() == getAlignment){
					seperateInput.prop('checked',true);
				}
			}else if(seperateInput.attr('type') == 'range'){
				if (seperateInputData1 == 'item-width') {
						let width = clickedObj.outerWidth();
						let pwidth = clickedObj.parent().width();
						let getWidthInPer = Math.round((width / pwidth) * 100);
					Custom_popup_editor._inputRange(seperateInput,clickedObj,seperateInputData1,getWidthInPer);
				}else{
					Custom_popup_editor._inputRange(seperateInput,clickedObj,seperateInputData1);
				}				
			}else if (seperateInputData1 == 'content-alignment') {
				if (clickedObj.data('content-alignment') == 'center' && seperateInput.val() == 'center') {
					seperateInput.prop('checked',true);
				}else if (clickedObj.data('content-alignment') == 'flex-end' && seperateInput.val() == 'right') {
					seperateInput.prop('checked',true);
				}else if(!clickedObj.data('content-alignment') && seperateInput.val() == 'left'){
					seperateInput.prop('checked',true);
				}
			}else if(seperateInputData1 == "margin"){
				let margins = clickedObj.css('margin-'+seperateInput.data('margin'));
				if(margins || margins == '0') seperateInput.val(parseInt(margins));
			}else if(seperateInputData1 == "padding"){
				let paddings = clickedObj.css('padding-'+seperateInput.data('padding'));
				if(paddings || paddings == '0') seperateInput.val(parseInt(paddings));
			}else if (seperateInputData1 == 'img' && clickedObjData1 == "image") {
				let imgCurrent = clickedObj.attr('src');
				seperateInput.css('background-image','url('+imgCurrent+')');
				if (jQuery('.getChangeImage_').length)jQuery('.getChangeImage_').removeClass('getChangeImage_');
				clickedObj.addClass('getChangeImage_');
			}else if(seperateInputData1 == "border"){
				Custom_popup_editor.__borderGet(clickedObj,seperateInput);
			}else if (seperateInputData1 == 'font-weight') {
				let fontWeight = clickedObj.css('font-weight');
					seperateInput.val(fontWeight);
			}
		}
		jQuery.each(allInputs,initInput_);
	},
	_changedSetEditor:function(){
		let changedInput = jQuery(this);
		let clickedObj = jQuery('.rl-editable-key-action');
			let changeData = changedInput.data('editor-input');
			let changeValue = changedInput.val();
			if(changeData == 'title') {
				// set text of clicked item 
				clickedObj.html(changeValue);
			}else if (changeData == 'link') {
				// set link href of clicked item
				clickedObj.attr('data-editor-link',changeValue);
			}else if (changeData == '_linktarget' && clickedObj.data('editor-link')) {
				// set link href of clicked item
				clickedObj.attr('data-editor-link-target',changeValue);
			}else if(changeData == 'text-alignment-choice'){
				// set aligment clicked item
				clickedObj.css('text-align',changeValue);
			}else if (changeData == 'font-size') {
				// set font size with parameter clicked item
				clickedObj.css('font-size',changeValue+'px');
			}else if (changeData == 'letter-spacing') {
				// set line-height of clicked item
				clickedObj.css('letter-spacing',changeValue+'px');
			}else if (changeData == 'line-height') {
				// set line-height of clicked item
				clickedObj.css('line-height',changeValue+'px');
			}else if(changeData == 'margin'|| changeData == 'padding'){
				Custom_popup_editor._marginPadding(changeData,changedInput,clickedObj,changeValue);
			}else if(changeData == 'item-width'){
				console.log(changeValue);
				clickedObj.css('width',changeValue+'%');
			}else if (changeData == 'content-alignment') {
				Custom_popup_editor._contentAlign(clickedObj,changeValue);
			}else if (changeData == 'border') {
				Custom_popup_editor._borderFn(clickedObj,changedInput,changeValue);
			}else if (changeData == 'font-weight') {
				clickedObj.css('font-weight',changeValue);
			}
	},
	_globalSettingInit:function(){
		let inputs = jQuery('[data-global-input]');
		if (inputs.length) jQuery.each(inputs,globalInit_);	
		function globalInit_(ind,value){//loop
			let sepInput = jQuery(value);
			let dataInput = sepInput.data('global-input');
			let sepInputDataClr = sepInput.data('input-color');

			let setHiddenInputI = jQuery('input[type="hidden"][data-global-save]');
			let setHiddenInput = setHiddenInputI;
			if ( setHiddenInput.val() ) {
				setHiddenInput = JSON.parse(setHiddenInput.val());
			}
			if (dataInput == 'main-wrapper') {
				if(sepInput.data('show-range') == "wrapper-width"){
					Custom_popup_editor._inputRange(sepInput,jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper'),'width');
				}else if ( sepInput.data('padding') ) {
					let paddings = jQuery('.wppb-popup-custom .wppb-popup-custom-content').css('padding-'+sepInput.data('padding'));
					sepInput.val( parseInt(paddings) );
				}
			}else if(dataInput == 'popup-name'){
				setHiddenInput['popup-name'] ? sepInput.val( setHiddenInput['popup-name'] ) : sepInput.val( 'Enter Popup Name' );

			}else if( dataInput == 'global-border'){
				let globalBorder = jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper');
				Custom_popup_editor.__borderGet(globalBorder,sepInput);
			}else if (dataInput == 'main-wrapper-height') {
					Custom_popup_editor._inputRange(sepInput,jQuery('.wppb-popup-custom .wppb-popup-custom-content'),'height');
			}else if(dataInput=='wrapper-height-check'){
				let height = Custom_popup_editor._checkStyle( jQuery('.wppb-popup-custom .wppb-popup-custom-content'), 'height' );
					if (height == 'auto' || !height) {
						sepInput.prop('checked',false);
						jQuery('.global-wrapper-height-custom-auto').hide();
					}else{
						sepInput.prop('checked',true);
						jQuery('.global-wrapper-height-custom-auto').show();
					}
			}else if (sepInputDataClr == 'overlay-color' || sepInputDataClr == 'outside-color' ) {
				let colorObj = sepInputDataClr == 'outside-color' ? jQuery('.wppb-popup-custom') : jQuery('.wppb-popup-custom .wppb-popup-custom-overlay'); 
				Custom_popup_editor._colorPickr(sepInput,colorObj,dataInput);
			}else if (dataInput == 'overlay-image') {
				let imgUrl = jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').css('background-image');
				let popupUrl = jQuery('input[name="popup-url"]').val();
				let imageContainer = jQuery('.global-overlay-image');
				let imageCheckbox = jQuery('[data-global-input="global-overlay-image"]');
				if (imgUrl && imgUrl != 'none') {
					sepInput.css('background-image', imgUrl);
					imageContainer.show();
					imageCheckbox.prop('checked',true);
				}else{
					sepInput.css('background-image', 'none');
					imageContainer.hide();
					imageCheckbox.prop('checked',false);
				}
			}else if(dataInput == "background-position"){
					let getElemStyle = jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').attr('style');
					let saparateStyle = Custom_popup_editor._inlineCssSeparate(getElemStyle);
					if ('background-position' in saparateStyle && sepInput.val() == saparateStyle['background-position']) {
							sepInput.prop('checked',true);
						}else if (sepInput.val() == 'left top') {
							sepInput.prop('checked',true);
						}
			}else if (dataInput == "background-size") {
					let getElemStyle = jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img');
					 getElemStyle = getElemStyle.css('background-size');
					 sepInput.val(getElemStyle);
			}else if( sepInput.data('cmn') == 'close-btn'){
						let closeBtn = jQuery('.wppb-popup-custom .wppb-popup-close-btn');
						if (dataInput == 'close-option') {
								if (setHiddenInput['close-type']) {
						 				sepInput.val( setHiddenInput['close-type'] );
								}else{
						 				sepInput.val( 3 );
								}
						}
						if (closeBtn.length) {
							jQuery('.close-btn-container').show();
							if (dataInput == 'close-font-size') {
									Custom_popup_editor._inputRange(sepInput,closeBtn,'font-size');
							}else if ( dataInput == 'close-btn' && sepInput.data('padding') ) {
									let paddings = closeBtn.css('padding-'+sepInput.data('padding'));
									sepInput.val( parseInt(paddings) );
							}else if (sepInputDataClr == 'close-btn-color' || sepInputDataClr == 'close-btn-bg-color') {
									Custom_popup_editor._colorPickr( sepInput,closeBtn,dataInput );
							}else if ( dataInput == 'close-btn' && sepInput.data('margin') ) {
									let checkStyle = Custom_popup_editor._checkStyle( closeBtn, sepInput.data('margin') );
									let putParam = checkStyle?parseInt(checkStyle):5;
									Custom_popup_editor._inputRange(sepInput,closeBtn,sepInput.data('margin'),putParam);
							}else if (sepInput.data('border') || sepInput.data('input-color') == 'border-color') {
								Custom_popup_editor.__borderGet(closeBtn,sepInput);
							}
						}else{
							jQuery('.close-btn-container').hide();
						}
			}else if(dataInput == "column-width"){
			let get_wrap = jQuery('.wppb-popup-custom .wppb-popup-rl-wrap');
			let getColumn = get_wrap.find('.wppb-popup-rl-column');
					if (getColumn.length == 2) {
						jQuery('.rl-two-column-width').show();
						if (sepInput.data('column') == 1) {
							let firstClumn =  jQuery(getColumn[0]);
							let firstColumnW = Custom_popup_editor._checkStyle(firstClumn,'width');
							firstColumnW?sepInput.val( parseInt(firstColumnW) ):sepInput.val(50);
						}else if(sepInput.data('column') == 2){
							let firstClumn =  jQuery(getColumn[1]);
							let firstColumnW = Custom_popup_editor._checkStyle(firstClumn,'width');
							firstColumnW?sepInput.val( parseInt(firstColumnW) ):sepInput.val(50);
						}
					}else{
						jQuery('.rl-two-column-width').hide();
					}
				}else if (dataInput == 'popup-delay-open') {
					let popupDalay = setHiddenInput['popup-delay-open'] ? setHiddenInput['popup-delay-open'] : 3;
					Custom_popup_editor._inputRange( sepInput, false, false, popupDalay );
				}else if (dataInput == 'popup-delay-close') {
					let popupDalayClose = setHiddenInput['popup-delay-close'] ? setHiddenInput['popup-delay-close'] : 0;
					Custom_popup_editor._inputRange( sepInput, false, false, popupDalayClose );
				}else if ( dataInput == 'box-shadow-global' ) {
					Custom_popup_editor._setBoxShadow(sepInput, jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper') );
				}
		}//loop
	},
	_globalSetEditor:function(e){
		let sepInput = jQuery(this);
		if (sepInput) {
				let checkDatatype = sepInput.data('type');
				let inputData = sepInput.data('global-input');
				let inputValue = sepInput.val();
						let setHiddenInputI = jQuery('input[type="hidden"][data-global-save]');
						let setHiddenInput = setHiddenInputI;
						if ( setHiddenInput.val() ) {
							setHiddenInput = JSON.parse(setHiddenInput.val());
						}
				let checkArray = (typeof setHiddenInput === 'object')?true:false;
				if (inputData == 'main-wrapper') {

						if (sepInput.data('show-range') == 'wrapper-width') {
							jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper').css('width',inputValue);
						}else if ( sepInput.data('padding') ) {
							let optPerform = jQuery('.wppb-popup-custom .wppb-popup-custom-content');
							Custom_popup_editor._globalPadding('padding',sepInput,optPerform,inputValue);
						}else if ( sepInput.data('origin') == 'padding' ) {
							let optPerform = jQuery('.wppb-popup-custom .wppb-popup-custom-content');
							Custom_popup_editor._globalPadding('padding-origin',sepInput,optPerform,inputValue);
						}
				}else if(inputData == 'global-border'){
					let globalBorder = jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper');
					Custom_popup_editor._borderFn(globalBorder,sepInput,inputValue);
				}else if(inputData == 'main-wrapper-height'){
						jQuery('.wppb-popup-custom .wppb-popup-custom-content').css('height',inputValue+'px');
					if(checkArray)setHiddenInput['wrapper-height'] = inputValue;
				}else if(inputData == 'wrapper-height-check'){
					if (sepInput.prop('checked') === false) {
						jQuery('.wppb-popup-custom .wppb-popup-custom-content').css('height','auto');
						if(checkArray)setHiddenInput['wrapper-height'] = 'auto';
						jQuery('.global-wrapper-height-custom-auto').hide();
					}else{
						jQuery('.global-wrapper-height-custom-auto').show();
					}
				}else if (inputData == "background-position") {
						jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').css('background-position',inputValue);
				}else if (inputData == "background-size") {
						jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').css('background-size',inputValue);
				}else if(inputData == "global-overlay-image"){
					let imageContainer = jQuery('.global-overlay-image');
						if (sepInput.prop('checked') === true) {
							imageContainer.show();
							let popupUrl = jQuery('input[name="popup-url"]').val();
							let imgUrl = "url('"+popupUrl+"img/blank-img.png')";
							jQuery('.global-overlay-image .rl-i-choose-image-wrap').css('background-image', imgUrl);
						}else{
							imageContainer.hide();
							jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').css('background-image','none');
							jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').removeAttr('data-overlay-image');
						}
				}else if (inputData == 'close-font-size') {
					jQuery('.wppb-popup-custom .wppb-popup-close-btn').css('font-size',inputValue+'px');
				}else if (inputData == 'close-option') {
							if(checkArray)setHiddenInput['close-type'] = inputValue;
							if (inputValue == 1 || inputValue == 2) {
								let closeBtn = '<span class="wppb-popup-close-btn dashicons dashicons-no-alt"></span>';
								if( !jQuery('.wppb-popup-custom .wppb-popup-close-btn').length ) jQuery('.wppb-popup-custom > div').prepend(closeBtn);
								jQuery('.close-btn-container').show();
								Custom_popup_editor._globalSettingInit();
							}else{
								jQuery('.wppb-popup-custom .wppb-popup-close-btn').remove();
								jQuery('.close-btn-container').hide();
							}
				}else if ( inputData == 'close-btn' ) {
							let optPerform = jQuery('.wppb-popup-custom .wppb-popup-close-btn');
						if ( sepInput.data('padding') ) {
							Custom_popup_editor._globalPadding('padding',sepInput,optPerform,inputValue);
						}else if ( sepInput.data('origin') == 'padding' ) {
							Custom_popup_editor._globalPadding('padding-origin',sepInput,optPerform,inputValue);
						}else if ( sepInput.data('margin') ) {
							optPerform.css( sepInput.data('margin'), inputValue+'%');
						}else if ( sepInput.data('border') ) {
								Custom_popup_editor._borderFn(optPerform,sepInput,inputValue);
						}
				}else if (inputData == 'column-width') {
					let get_wrap = jQuery('.wppb-popup-custom .wppb-popup-rl-wrap');
					let getColumn = get_wrap.find('.wppb-popup-rl-column');
					if (sepInput.data('column') == 1) {
						jQuery(getColumn[0]).css('width',inputValue+'%');
						jQuery(getColumn[1]).css('width',(100 - inputValue)+'%');
						sepInput.siblings('input').val( 100 - inputValue );
					}else if (sepInput.data('column') == 2) {
						jQuery(getColumn[1]).css('width',inputValue+'%');
						jQuery(getColumn[0]).css('width',(100 - inputValue)+'%');
						sepInput.siblings('input').val( 100 - inputValue );
					}
				}else if (inputData == 'popup-delay-open'){
					if(checkArray)setHiddenInput['popup-delay-open'] = inputValue;
				}else if (inputData == 'popup-delay-close'){
					if(checkArray)setHiddenInput['popup-delay-close'] = inputValue;
				}else if ( inputData == "box-shadow-global" ) {
					Custom_popup_editor._boxShadowFn( jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper') ,sepInput);
				}
				if (checkArray)setHiddenInputI.val( JSON.stringify(setHiddenInput) );
		}
	},
	_marginPadding:function(changeData,changedInput,clickedObj,changeValue){
		if(changedInput.data('origin') && changeData == 'margin'){
			if (changedInput.prop('checked')) {
				let getFirstInput = changedInput.closest('.paraMeterContainer__').find('input[data-margin="top"]');
				let getFirstValue = getFirstInput.val()?getFirstInput.val():0;
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(getFirstValue);
				clickedObj.css('margin',getFirstValue+'px');
			}
		}else if(changeData == 'margin'){
			let marginOrigin = changedInput.data('margin');
			let getCheckBox = changedInput.closest('.paraMeterContainer__').find('[data-editor-input="margin-origin"]');
			if (getCheckBox.prop('checked')) {
				clickedObj.css('margin',changeValue+'px');
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(changeValue);
			}else{
				clickedObj.css('margin-'+marginOrigin,changeValue+'px');
			}
		}else if(changedInput.data('origin') && changeData == 'padding'){
			if (changedInput.prop('checked')) {
				let getFirstInput = changedInput.closest('.paraMeterContainer__').find('input[data-padding="top"]');
				let getFirstValue = getFirstInput.val()?getFirstInput.val():0;
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(getFirstValue);
				clickedObj.css('padding',getFirstValue+'px');
			}
		}else if(changeData == 'padding'){
			let paddingOrigin = changedInput.data('padding');
			let getCheckBox = changedInput.closest('.paraMeterContainer__').find('[data-editor-input="padding-origin"]');
			if (getCheckBox.prop('checked')) {
				clickedObj.css('padding',changeValue+'px');
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(changeValue);
			}else{
				clickedObj.css('padding-'+paddingOrigin,changeValue+'px');
			}
		}

	},
	__borderGet:function(elementBorder,input_){
		if( input_.data('border') == 'border-enable' ){
			let checkBorder = Custom_popup_editor._checkStyle(elementBorder,'border');
			let container = input_.closest('.content-style-border').find('.content-border');
				if (checkBorder){
					input_.prop('checked',true);
					container.show();
				}else{
					input_.prop('checked',false);
					container.hide();
				}
			}else if( input_.data('border') == 'width' ){
				let getWidth = elementBorder.css('border-width');
				input_.val( parseInt(getWidth) );
			}else if( input_.data('border') == 'radius' ){
					let getRadius = elementBorder.css('border-radius');
					input_.val( parseInt(getRadius) );
			}else if ( input_.data('input-color') == 'border-color' ) {
				Custom_popup_editor._colorPickr(input_,elementBorder,'border-color');
			}
	},
	_borderFn:function(clickedObj,changedInput,changeValue){
		let container = changedInput.closest('.content-style-border');
		if (changedInput.data('border') && changedInput.data('border') == 'border-enable') {
			if (changedInput.prop('checked')) {
				clickedObj.css("border",'1px solid orange');
				container.find('.content-border').show();
			}else{
				container.find('.content-border').hide();
				Custom_popup_editor._removeStyle(clickedObj,'border');
			}
		}else if (changedInput.data('border') && container.find('[type="checkbox"][data-border]').prop('checked')) {
			let checkProp = changedInput.data('border');
			if (checkProp == 'width') {
				clickedObj.css('border-width',changeValue);
			}else if (checkProp == 'radius') {
				clickedObj.css('border-radius',changeValue+'px');
			}else if(checkProp == 'border-style'){
				clickedObj.css('border-style',changeValue);
			}
		}
	},
	_setBoxShadow:function(input, clickedObj){
		let checkData = input.data('shadow');
		let getCss = Custom_popup_editor._checkStyle(clickedObj,'box-shadow');
		if (getCss && getCss != 'none') {
			if ( checkData == 'enable') {
				input.closest('.content-style-box-shadow').find('.content-box-shadow').show();
				input.prop('checked',true);
			}else if (checkData == 'x-offset' || checkData == 'y-offset' || checkData == 'blur' || checkData == 'spread') {
				let putVal = Custom_popup_editor._box_shadow_prop(getCss, checkData, true, true);
				input.val( parseInt(putVal) );
			}else if (checkData == 'color') {
				Custom_popup_editor._colorPickr( input, clickedObj ,'box-shadow' );
			}
		}else{
			if (checkData == 'enable') {
				input.prop('checked',false);
			}
			input.closest('.content-style-box-shadow').find('.content-box-shadow').hide();
		}
	},
	_boxShadowFn:function(clickedObj,changedInput){
		let checkData = changedInput.data('shadow');
		let inputVal  = changedInput.val();
		let container = changedInput.closest('.content-style-box-shadow');
		if (checkData == 'enable') {
			if (changedInput.prop('checked')) {
				let style = '#808080 2px 4px 7px 1px';
				Custom_popup_editor._setStyleColor(clickedObj,style,'box-shadow');
			}else{
				Custom_popup_editor._removeStyle(clickedObj,'box-shadow');
			}
			Custom_popup_editor._setBoxShadow(changedInput,clickedObj);
		}else if (container.find('[type="checkbox"][data-shadow]').prop('checked') && checkData) {
			let getCss = Custom_popup_editor._checkStyle(clickedObj,'box-shadow');
			let getBoxShadow = Custom_popup_editor._box_shadow_prop(getCss, checkData, inputVal);
			if(getBoxShadow) Custom_popup_editor._setStyleColor(clickedObj,getBoxShadow,'box-shadow');
		}
	},
	_box_shadow_prop:function(css, shadow_prop, value_, get_prop_){
		let splitted = css.split(' ');
			if (shadow_prop == 'color') {
				if(get_prop_ ){return splitted[0];}else{splitted[0] = value_ };
			}else if (shadow_prop == 'x-offset') {
				if(get_prop_ ){return splitted[1];}else{splitted[1] = value_ + 'px' };
			}else if (shadow_prop == 'y-offset') {
				if(get_prop_ ){return splitted[2];}else{splitted[2] = value_ + 'px' };
			}else if (shadow_prop == 'blur') {
				if(get_prop_ ){return splitted[3];}else{splitted[3] = value_ + 'px' };
			} else if (shadow_prop == 'spread') {
				if(get_prop_ ){return splitted[4];}else{splitted[4] = value_ + 'px' };
			}
		splitted = splitted.join(' ');
		return value_ ? splitted:false;
	},
	_globalPadding:function(changeData,changedInput,clickedObj,changeValue){
				if(changeData == 'padding'){
					let paddingOrigin = changedInput.data('padding');
					let getCheckBox = changedInput.closest('.paraMeterContainer__').find('[data-origin="padding"]');
					if (getCheckBox.prop('checked')) {
						clickedObj.css('padding',changeValue+'px');
						changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(changeValue);
					}else{
						clickedObj.css('padding-'+paddingOrigin,changeValue+'px');
					}
				}else if(changeData == 'padding-origin'){
					if (changedInput.prop('checked')) {
						let getFirstInput = changedInput.closest('.paraMeterContainer__').find('input[data-padding="top"]');
						let getFirstValue = getFirstInput.val()?getFirstInput.val():0;
						changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(getFirstValue);
						clickedObj.css('padding',getFirstValue+'px');
					}
				}
	},
	_contentAlign:function(clickedObj,changeValue){
		let alignContent = clickedObj.closest('.data-rl-editable-wrap');
		if (changeValue == 'center') {
			alignContent.css('justify-content','center');
			clickedObj.attr('data-content-alignment','center');
		}else if (changeValue == 'right') {
			alignContent.css('justify-content','flex-end');
			clickedObj.attr('data-content-alignment','flex-end');
		}else if (changeValue == 'left') {
			alignContent.css('justify-content','unset');
			if(clickedObj.data('content-alignment'))clickedObj.removeAttr('data-content-alignment');
		}
	},
	_rlRemoveElement:function(){
		let button = jQuery(this);
		button.closest('.data-rl-editable-wrap').remove();
		jQuery('.rl_i_editor-item-content').hide();
	},
	_chooseLayout:function(){
		let layoutName = jQuery('.wppb-popup-name-layout input[name="wppb-popup-layout"]');
		let popupName = jQuery('.wppb-popup-name-layout input[name="wppb-popup-name"]');
		let checkRadio = false;
		jQuery.each(layoutName, (index,value)=> {
			let radio_ = jQuery(value);
			if (radio_.prop('checked') == true) checkRadio = true;
		}); 
		if (checkRadio == true && popupName.val() != '') {
			jQuery('.wppb-popup-name-init').removeClass('business_disabled');
		}else{
			jQuery('.wppb-popup-name-init').addClass('business_disabled');
		}
	},
	_popupName:function(){
		let layOutRadio = jQuery('.wppb-popup-name-layout input[name="wppb-popup-layout"]:checked');
		let layoutName  = layOutRadio.val();
		let popupName   = jQuery('.wppb-popup-name-layout input[name="wppb-popup-name"]').val();

			if (layoutName && popupName) {
				let getLayout = '';
				if (layoutName == 'prebuilt') {
					getLayout = layOutRadio.siblings('label').html();
					layoutName = layOutRadio.data('layout') ? layOutRadio.data('layout') : '';
				}else{
					getLayout = jQuery('.prebuilt-pupup-layout-container > div[data-layout="'+layoutName+'"]').html();
				}
				let saveLAyout = {layout:layoutName,'popup-name':popupName};
				let setHiddenInputI = jQuery('input[type="hidden"][data-global-save]');
				setHiddenInputI.val( JSON.stringify(saveLAyout) );
				let putLayout = jQuery('.wppb-popup-custom > div');
				putLayout.html(getLayout);
				jQuery('.wppb-popup-name-layout').hide();
				jQuery('.wppb-popup-custom, .rl_i_editor-main-container').show();
				Custom_popup_editor._dragAndShort();
				Custom_popup_editor._globalSettingInit();
			}else{
				alert('fill the popup name');
			}
	},
	_bind:function(){
		jQuery(document).on('click', '.wppb-popup-custom [data-rl-editable]',Custom_popup_editor._openEditPanel);
		jQuery(document).on('click', '.wppb-popup-custom .rlRemoveElement',Custom_popup_editor._rlRemoveElement);
		jQuery(document).on('click', '.rl-i-choose-image',Custom_popup_editor._chooseImage);
		jQuery(document).on('keyup change', '[data-editor-input]',Custom_popup_editor._changedSetEditor);
		jQuery(document).on('keyup change', '[data-global-input]', Custom_popup_editor._globalSetEditor);
		jQuery(document).on('change', '.lead-form-bulider-select > select', Custom_popup_editor._leadFormChoose);
		jQuery(document).on('click', '.wppb-popup-lead-form', Custom_popup_editor._leadFormOpenPanel);

		jQuery(document).on('keyup', '.wppb-popup-name-layout input[name="wppb-popup-name"]', Custom_popup_editor._chooseLayout);
		jQuery(document).on('click', '.wppb-popup-name-layout input[name="wppb-popup-layout"]', Custom_popup_editor._chooseLayout);

		jQuery(document).on('click', '.wppb-popup-name-init', Custom_popup_editor._popupName);

		jQuery(document).on('keyup change', '.wppb-lead-form-styling [data-lead-form]',Custom_popup_editor._leadFormStylingSet);
	},
	_leadFormOpenPanel:function(){
		let getForm = jQuery(this);
		jQuery('.rl-lead-form-panel').slideDown('fast');
		// close container while open content style
		jQuery('.rl-editable-key-action').removeClass('rl-editable-key-action');
		let toggleContainer = jQuery(".rl_i_editor-element-Toggle");
		jQuery.each(toggleContainer,(index,value)=>{
			let separateToggle = jQuery(value);
			let separateToggleData = separateToggle.data('toggle');
				separateToggle.removeClass('rl-active');
				jQuery('[data-toggle-action="'+separateToggleData+'"]').slideUp('slow');
		});
		jQuery('.rl_i_editor-item-content').slideUp('fast');

		if ( getForm.data('form-id') ) {
			jQuery('.rl-lead-form-panel .lead-form-bulider-select select').val( getForm.attr('data-form-id') );
			Custom_popup_editor._leadFormStyling();
		}
	},
	_leadFormChoose:function(){
		let select = jQuery(this);
		let form_id = select.val();
  		if ( parseInt(form_id) ) {
			let letExistForm = jQuery('.wppb-popup-custom .wppb-popup-lead-form[data-form-id]');
			letExistForm.length ? letExistForm.addClass('rlLoading') : jQuery('.wppb-popup-custom #lf-business-popup').addClass('rlLoading');

  			let data_ = {action:'getLeadForm',form_id:form_id};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				if (response && response != 0) {
					let replace_form = "<div class='wppb-popup-lead-form' data-form-id='"+form_id+"'>"+response+"</div>"; 
					if ( letExistForm.length ) {
						let getStyles = letExistForm.attr('data-form-styles'); 
						replace_form = jQuery(replace_form).attr('data-form-styles' ,getStyles);
						letExistForm.replaceWith(replace_form);
					}else{
						jQuery('.wppb-popup-custom #lf-business-popup').replaceWith(replace_form);
					}
					Custom_popup_editor._leadFormInit();
					Custom_popup_editor._leadFormStyling();
				}
			});
  		}
	},
	_leadFormInit:function(){				
			let leadForm_ = jQuery('.wppb-popup-lead-form');
			jQuery.each(leadForm_, (index, value)=>{
					let leadForm = jQuery(value);
					let leadFormStyle_ = leadForm.data('form-styles');					
					leadForm = leadForm.find('form');
					if ( leadFormStyle_ ) {
						if (leadFormStyle_['submit-style']) {
							leadForm.find('.lf-form-submit').attr('style',leadFormStyle_['submit-style']);
						}
						if (leadFormStyle_['submit-align']) {
							leadForm.find('.lf-form-submit').attr('data-alignment',leadFormStyle_['submit-align']);
						}
						if (leadFormStyle_['form-style']) {
							leadForm.attr('style',leadFormStyle_['form-style']);
						}
						if (leadFormStyle_['label-style']) {
						let element = leadForm.find('.name-type.lf-field > label, .text-type.lf-field > label, .textarea-type.lf-field > label');
							element.attr('style',leadFormStyle_['label-style']);
						}
						if (leadFormStyle_['field-style']) {
						let element = leadForm.find('.lf-field input, .lf-field textarea');
							element.not('input[type="submit"]').attr('style',leadFormStyle_['field-style']);
						}
						if (leadFormStyle_['heading-style']) {
						let element = leadForm.children('h2');
							element.attr('style',leadFormStyle_['heading-style']);
						}
					}
			});			
	},
	_leadFormStyling:function(){
		jQuery('.wppb-lead-form-styling').show();
		let leadForm = jQuery('.wppb-popup-custom .wppb-popup-lead-form form');
		let getInputs = jQuery('.wppb-lead-form-styling [data-lead-form]');
		function leadFormInput(index, value){
			let sepInput = jQuery(value);
			let getData = sepInput.data('lead-form');
			if ( getData == 'lf-form-width' ) {
				let width = leadForm.outerWidth();
				let pwidth = leadForm.closest('.leadform-show-form').width();
				let getWidthInPer = Math.round((width / pwidth) * 100);
				Custom_popup_editor._inputRange(sepInput, false, false, getWidthInPer);
			}else if( sepInput.data('input-color') == "lf-form-color" ){
				Custom_popup_editor._colorPickr( sepInput, leadForm ,'background-color' );
			}else if( sepInput.data('input-color') == 'lf-heading-color'){
				Custom_popup_editor._colorPickr( sepInput, leadForm.children('h2') ,'color' );
			}else if( getData == 'lf-heading-font-size'){
				Custom_popup_editor._inputRange(sepInput, false, false, leadForm.children('h2').css('font-size') );
			}else if( sepInput.data('input-color') == 'lf-submit-btn-color' ){
				Custom_popup_editor._colorPickr( sepInput, leadForm.find('input.lf-form-submit') ,'color' );
			}else if( sepInput.data('input-color') == 'lf-submit-btn-bcolor' ){
				Custom_popup_editor._colorPickr( sepInput, leadForm.find('input.lf-form-submit') ,'background-color' );
			}else if( getData == 'lf-submit-btn-font-size' ){
				Custom_popup_editor._inputRange(sepInput, false, false, leadForm.find('input.lf-form-submit').css('font-size') );
			}else if( sepInput.data('input-color') == 'lf-label-color' ){
				let element = leadForm.find('.name-type.lf-field > label, .text-type.lf-field > label, .textarea-type.lf-field > label');
				Custom_popup_editor._colorPickr( sepInput, element ,'color' );
			}else if( getData == 'lf-label-font-size' ){
				let element = leadForm.find('.lf-field > label').css('font-size');
				Custom_popup_editor._inputRange(sepInput, false, false, element );
			}else if ( getData == 'form-border' || getData ==  'lf-submit-border' || getData == 'lf-field-border') {
					let elementBorder = getData == 'form-border' ? leadForm : (getData == 'lf-field-border') ? leadForm.find('.lf-field input, .textarea-type.lf-field textarea').not('input[type="submit"]') : leadForm.find('input.lf-form-submit');
					Custom_popup_editor.__borderGet(elementBorder,sepInput);
			}else if (getData == 'form-heading-enable') {
				leadForm.children('h2').css('display') != 'none' ? sepInput.prop('checked', true) : sepInput.prop('checked', false);
			}else if( sepInput.data('input-color') == 'lf-field-color' ){
				let element = leadForm.find('.name-type.lf-field input, .text-type.lf-field input, .textarea-type.lf-field textarea');
				Custom_popup_editor._colorPickr( sepInput, element ,'color' );
			}else if( sepInput.data('input-color') == 'lf-field-background-color' ){
				let element = leadForm.find('.name-type.lf-field input, .text-type.lf-field input, .textarea-type.lf-field textarea');
				Custom_popup_editor._colorPickr( sepInput, element ,'background-color' );
			}else if( getData == 'lf-field-font-size' || getData == 'lf-field-height' ){
				let element = leadForm.find('.lf-field input');
				element = getData == 'lf-field-font-size' ? element.css('font-size') : element.css('height');
				Custom_popup_editor._inputRange(sepInput, false, false, element );
			}else if ( getData == 'lf-submit-padding') {
				let element = leadForm.find('input.lf-form-submit');
				let paddings = element.css('padding-'+sepInput.data('padding'));
				if(paddings || paddings == '0') sepInput.val(parseInt(paddings));
			}else if ( getData == 'submit-font-weight'){
				let fontWeight = leadForm.find('input.lf-form-submit').css('font-weight');
				if(fontWeight || fontWeight == '0') sepInput.val(parseInt(fontWeight));
			}else if (getData == 'lf-submit-aliment') {
				let getAlignment = leadForm.find('.submit-type.lf-field').css('text-align');
				if(getAlignment == sepInput.val()) sepInput.prop('checked',true);
			}else if( getData == 'form-margin-center' ){
				let getMargin = Custom_popup_editor._checkStyle(leadForm,'margin');
				getMargin == 'auto' ? sepInput.prop('checked',true) : sepInput.prop('checked',false);
			}
		}
		jQuery.each(getInputs, leadFormInput);
	},
	_leadFormStylingSet:function(){
		let input_ = jQuery(this);
		let dataCheck = input_.data('lead-form');

		let inputVal = input_.val();
		let leadForm = jQuery('.wppb-popup-custom .wppb-popup-lead-form form');
		if (dataCheck == 'lf-form-width') {
			leadForm.css('width',inputVal+'%');
		}else if (dataCheck == 'lf-label-font-size') {
			leadForm.find('.lf-field > label').css('font-size',inputVal+'px');
		}else if (dataCheck == 'lf-field-font-size' || dataCheck == 'lf-field-height') {
			let element = leadForm.find('.lf-field input, .textarea-type.lf-field textarea').not('input[type="submit"]');
			dataCheck == 'lf-field-font-size' ? element.css('font-size',inputVal+'px') : element.css('height',inputVal+'px');
		}else if( dataCheck == 'lf-submit-btn-font-size'){
			leadForm.find('input.lf-form-submit').css('font-size',inputVal+'px');
		}else if( dataCheck == 'lf-heading-font-size'){
			leadForm.children('h2').css('font-size',inputVal+'px');
				let elementBorder = dataCheck == 'form-border' ? leadForm : (dataCheck == 'lf-field-border') ? leadForm.find('.lf-field input, .textarea-type.lf-field textarea').not('input[type="submit"]') : leadForm.find('input.lf-form-submit');
				Custom_popup_editor._borderFn(elementBorder,input_,inputVal);
		}else if ( dataCheck == 'form-heading-enable') {
			input_.prop('checked') == true ? leadForm.children('h2').show() : leadForm.children('h2').hide();
		}else if ( input_.data('padding') && dataCheck == 'lf-submit-padding' ) {
			Custom_popup_editor._globalPadding('padding', input_ ,leadForm.find('input.lf-form-submit') ,inputVal);
		}else if ( input_.data('origin') == 'padding' && dataCheck == 'lf-submit-padding' ) {
			Custom_popup_editor._globalPadding('padding-origin', input_ ,leadForm.find('input.lf-form-submit') ,inputVal);
		}else if ( dataCheck == 'submit-font-weight') {
			leadForm.find('input.lf-form-submit').css('font-weight',inputVal);
		}else if (dataCheck == 'lf-submit-aliment') {
				leadForm.find('input.lf-form-submit').attr('data-alignment',inputVal);
				leadForm.find('.submit-type.lf-field').css('text-align',inputVal);
		}else if (dataCheck == 'form-margin-center') {
				if (input_.prop('checked') == true) {
					leadForm.css('margin','auto');
				}else{
					Custom_popup_editor._removeStyle(leadForm,'margin');
				}
		}
	}
	,_chooseImage:function(e){
		e.preventDefault();
    	let this_button = jQuery(this);
    	custom_uploader = wp.media({
			title: 'Business Popup Image Uploader',
			library : {type : 'image'},
			button: {text: 'Choose This Image'},
			multiple: false 
		}).on('select', function() {
			let attachment = custom_uploader.state().get('selection').first().toJSON();
			let putImageInner = this_button.find('.rl-i-choose-image-wrap');
			if (putImageInner.data('global-input')) {
				jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').css('background-image', 'url('+attachment.url+')').attr('data-overlay-image',attachment.url);
			}else{
				jQuery('.getChangeImage_').attr('src',attachment.url);
			}
			putImageInner.css('background-image', 'url('+attachment.url+')');
		}).open();
	},
	_inlineCssSeparate:function(inline_css){
				let saparateStyle = [];
				inline_css.split(';').forEach((value_, index_)=>{
					if(value_.search(':') > -1){
				      let getCss = value_.split(':');
				     	saparateStyle[getCss[0].trim()] = getCss[1].trim();  
				    }
				});
				return saparateStyle;
	},
	_setStyleColor:function(element,element_value,styleProperty){
				let getElemStyle =  element.attr('style');
				if (getElemStyle) {
						let saparateStyle = Custom_popup_editor._inlineCssSeparate(getElemStyle);
						if (styleProperty in saparateStyle) delete saparateStyle[styleProperty];
						saparateStyle[styleProperty] = element_value;
						let newStyle = '';
						for (let key in saparateStyle) {newStyle += key+':'+saparateStyle[key]+";";}
						element.attr('style',newStyle);
				}else{
						element.attr('style',styleProperty+':'+element_value);
				}
	},
	_removeStyle:function(element,removeStyle,apply_=true){
				let getElemStyle =  element.attr('style');
				if (getElemStyle) {
					let saparateStyle = Custom_popup_editor._inlineCssSeparate(getElemStyle);
						let newStyle = '';
						for (let key in saparateStyle) {
							if (key.indexOf(removeStyle) == 0)continue;
							newStyle += key+':'+saparateStyle[key]+";";
						}
						if (apply_) {
							element.attr('style',newStyle);
						}else{
							return newStyle;
						}
				}
	},
	_checkStyle:function(element,style_){
		let getElemStyle =  element.attr('style');
				if (getElemStyle) {
					let saparateStyle = Custom_popup_editor._inlineCssSeparate(getElemStyle);
					return style_ in saparateStyle?saparateStyle[style_]:false;
				}
	},
	_colorPickr:function(select_element,clickedObj,getColorProperty,getColor=false){
		let getColorValue = clickedObj.css(getColorProperty);
		if (getColorProperty == 'box-shadow') {
			let getCss = Custom_popup_editor._checkStyle(clickedObj,'box-shadow');
			getColorValue = Custom_popup_editor._box_shadow_prop(getCss, 'color', true, true);
			console.log(getColorValue);

		}
		select_element.css('background-color',getColorValue);
		const inputElement = select_element[0];
		const pickr = new Pickr({
		  el:inputElement,
		  useAsButton: true,
		  default: getColorValue,
		  theme: 'nano',
		  swatches: [
		    'rgba(244, 67, 54, 1)',
		    'rgba(233, 30, 99, 0.95)',
		    'rgba(156, 39, 176, 0.9)',
		    'rgba(103, 58, 183, 0.85)',
		    'rgba(63, 81, 181, 0.8)',
		    'rgba(33, 150, 243, 0.75)',
		    'rgba(255, 193, 7, 1)'
		  ],
		  components: {
		    preview: true,
		    opacity: true,
		    hue: true,
		    interaction: {
		      input: true,
		    }
		  }
		}).on('change',(color,instance)=>{
		  let color_ = color.toHEXA().toString(0);
		  // preview css on input editor item
		  select_element.css('background-color',color_);
		  // apply color on selected item
		  if (getColorProperty == 'box-shadow') {
		  	let getCss = Custom_popup_editor._checkStyle(clickedObj,'box-shadow');
		  	let propBoxShadow = Custom_popup_editor._box_shadow_prop(getCss, 'color', color_);
		  	Custom_popup_editor._setStyleColor(clickedObj,propBoxShadow,'box-shadow');
		  }else{
		  	Custom_popup_editor._setStyleColor(clickedObj,color_,getColorProperty);
			
		  }
		  // to get output on input
		  // if (getColor && getColor[0].tagName == 'INPUT'){
				// getColor.val(color_).change();		  	
		  // }
		});

	},
	_inputRange:function(rangeSlider,clickedObj,prop,def=""){
		let thisData = rangeSlider.data('show-range');
		let putOutput = jQuery('[data-range-output="'+thisData+'"]');
		// set default data
		let defaultValue = !def && clickedObj.length ?clickedObj.css(prop): def;
		  putOutput.val(parseInt(defaultValue));
		  rangeSlider.val(parseInt(defaultValue));

		  rangeSlider[0].oninput = function() {
		  putOutput.val(jQuery(this).val());
		  rangeSlider.change();
		}
		putOutput.on('change' ,function(){
			rangeSlider.val(jQuery(this).val()).change();
		});
	}
}
	Custom_popup_editor.init();
	Business_news_letter.init();
})(jQuery);