(function(jQuery){
var Business_news_letter = {
	init:function(){
		Business_news_letter._bind();
	},
	_saveBusinessAddon:function(){
		let this_btn = jQuery(this);
		this_btn.addClass('rlLoading');
		let saveData = Business_news_letter._saveData();
		
		
		console.log(saveData);

		// return;

			let data_ = {action:'custom_insert',htmldata:saveData};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				console.log(response);
				// return;
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
	
		console.log(saveData);
		// return;

		let bid = this_btn.data('bid');
			let data_ = {action:'custom_update',htmldata:saveData,bid:bid};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				// console.log(response);
				if (response || response == 0) {
		        		setTimeout(()=>this_btn.removeClass('rlLoading'),1000);
		        	}
			});
	},
	_initGlobalSave:function(inputs){

			let contentGlobal = jQuery('input[type="hidden"][data-global-save]');
			contentGlobal = contentGlobal.val() ? JSON.parse(contentGlobal.val()) : {};
			let outerParent = jQuery('.wppb-popup-custom');
			
			let overlayImage = outerParent.find('[data-overlay-image]');
			let wrapperWidth = outerParent.find('.wppb-popup-custom-wrapper');
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

			if(overlayImage.attr('data-overlay-image'))contentGlobal['overlay-image-url'] = overlayImage.attr('data-overlay-image');
			contentGlobal['wrapper-width'] = parseInt(wrapperWidth.css('width'));
			let overlayStyle = Custom_popup_editor._removeStyle(overlayImage,"background-image",false)
			if(overlayStyle) contentGlobal['overlay-style'] = overlayStyle;

			return {type:'global-setting',content:contentGlobal };
	},
	_saveData:function(){
		let getSaveData = jQuery('.wppb-popup-custom');
		let getSaveDataWrap = getSaveData.find('[data-rl-wrap]');
		let saveData = [];
		
		let getSaveGlobal = Business_news_letter._initGlobalSave();
		if (!jQuery.isEmptyObject(getSaveGlobal.content)) saveData.push(getSaveGlobal);

		// console.log(getSaveData);
		// console.log(getSaveGlobal);
		// console.log(getSaveDataWrap);

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
				console.log(response);
				if (response || response == 0) {
		        		setTimeout(()=>{
		        		let pathName = window.location.pathname + "?page=business-popup";
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
		// console.log(bid);
		// console.log(option_key);
		// return;

		// disable all on enable all pages and post
		var checkBoxDisable = thisCheckBox.closest('.wppb-popup-checkbox');
			checkBoxDisable.addClass('business_disabled');
		let data_ = {action:'option_update',popup_id:bid,option_key:option_key,option_value:option_value};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				console.log(response);
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
			let data_ = {action:'popup_active',popup_id:popup_id,is_active:isActive};
			
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				console.log(response);
			});

	},
	_bind(){
		jQuery(document).on('click', '.wppb_popup_saveAddon', Business_news_letter._saveBusinessAddon);
		jQuery(document).on('click', '.wppb_popup_updateAddon', Business_news_letter._updateAddon);
		jQuery(document).on('click', '.wppb_popup_deleteAddon', Business_news_letter._deleteAddon);
		jQuery(document).on('click', '.wppb-popup-cmn-nav-item > a.wppb-popup-tab', Business_news_letter._businessTabSetting);

		jQuery(document).on('change', '.wppb-popup-option input[type="checkbox"]', Business_news_letter._businessOptionUpdate);
		jQuery(document).on('change','.wppb_popup_setting_active', Business_news_letter._savePopupActiveDeactive);

	}
		// alert('hdhdh');

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
			jQuery('.rl_i_editor-item-content-i').removeClass('active_');
			thisButton.addClass('active_').siblings().removeClass('active_');
			jQuery('.rl_i_editor-item-content-'+thisButton.data('editor-tab')).addClass('active_');
		});

		//data active and deactive
		jQuery('.rl_i_editor-item-content-header [data-editor-tab]').click(function(){
			let thisButton = jQuery(this);
			jQuery('.rl_i_editor-item-content-i').removeClass('active_');
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
	      // cursor: "move",
	      start:function(event,ui){
	      	// let uiElement = ui.helper;
	      },
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
			jQuery('.item-image').not('.rl_i_editor-global-setting .item-image').hide();
			jQuery('.item-text').show();
		}else if (clickedObjData1 == "image") {
			jQuery('.item-image').show();
			jQuery('.item-text').hide();
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
			}else if(seperateInput.data('input-color')){
				// get color and init of clicked item
				Custom_popup_editor._colorPickr(seperateInput,clickedObj,seperateInputData1);
			}else if(seperateInputData1 == 'alignment'){
				let getAlignment = clickedObj.css('text-align');
				if (seperateInput.val() == getAlignment){
					seperateInput.prop('checked',true);
				}
			}else if(seperateInput.attr('type') == 'range'){
				if (seperateInputData1 == 'item-width') {
						let width = clickedObj.width();
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
				seperateInput.val(parseInt(margins));
			}else if(seperateInputData1 == "padding"){
				let paddings = clickedObj.css('padding-'+seperateInput.data('padding'));
				seperateInput.val(parseInt(paddings));
			}else if (seperateInputData1 == 'img' && clickedObjData1 == "image") {
				let imgCurrent = clickedObj.attr('src');
				seperateInput.css('background-image','url('+imgCurrent+')');
				if (jQuery('.getChangeImage_').length)jQuery('.getChangeImage_').removeClass('getChangeImage_');
				clickedObj.addClass('getChangeImage_');
			}else if(seperateInputData1 == "border"){
				if (seperateInput.data('border') == 'width'){
					seperateInput.val(parseInt(clickedObj.css('border-width')));
				}else if (seperateInput.data('border') == 'radius') {
					seperateInput.val(parseInt(clickedObj.css('border-radius')));
				}
			}else if (seperateInputData1 == 'border-enable') {
					let checkBorder = Custom_popup_editor._checkStyle(clickedObj,'border');
				if (checkBorder){
					seperateInput.prop('checked',true);
					jQuery('.content-border').show();
				}else{
					seperateInput.prop('checked',false);
					jQuery('.content-border').hide();
				}
			}else if (seperateInputData1 == 'font-weight') {
				let fontWeight = clickedObj.css('font-weight');
					seperateInput.val(fontWeight);
			}

			// console.log(seperateInput);
			// console.log(value);
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
			}else if(changeData == 'alignment'){
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
			}else if(changeData == 'margin' || changeData == 'margin-origin' || changeData == 'padding' || changeData == 'padding-origin'){
				Custom_popup_editor._marginPadding(changeData,changedInput,clickedObj,changeValue);
			}else if(changeData == 'item-width'){
				clickedObj.css('width',changeValue+'%');
			}else if (changeData == 'content-alignment') {
				Custom_popup_editor._contentAlign(clickedObj,changeValue);
			}else if (changeData == 'border' || changeData == 'border-enable') {
				Custom_popup_editor._borderFn(changeData,clickedObj,changedInput,changeValue);
			}else if (changeData == 'font-weight') {
				clickedObj.css('font-weight',changeValue);
			}

			// console.log(changeData);
			// console.log(changedInput);
			// console.log(changeValue);

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
			
			// console.log(sepInput);
			// console.log(value);

			if (dataInput == 'main-wrapper') {

				if(sepInput.data('show-range') == "wrapper-width"){
					Custom_popup_editor._inputRange(sepInput,jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper'),'width');
				}else if ( sepInput.data('padding') ) {
					let paddings = jQuery('.wppb-popup-custom .wppb-popup-custom-content').css('padding-'+sepInput.data('padding'));
					sepInput.val( parseInt(paddings) );
				}
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
				// console.log(sepInput);
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
			// console.log(value);
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
							}else if( sepInput.data('border') == 'border-enable' ){
									let checkBorder = Custom_popup_editor._checkStyle(closeBtn,'border');
									let container = sepInput.closest('.content-style-border').find('.content-border');
										if (checkBorder){
											sepInput.prop('checked',true);
											container.show();
										}else{
											sepInput.prop('checked',false);
											container.hide();
										}
							}else if( sepInput.data('border') == 'width' ){
								let getWidth = closeBtn.css('border-width');
								sepInput.val( parseInt(getWidth) );
							}else if( sepInput.data('border') == 'radius' ){
									let getRadius = closeBtn.css('border-radius');
									sepInput.val( parseInt(getRadius) );
							}else if ( dataInput == 'border-color' ) {
								Custom_popup_editor._colorPickr(sepInput,closeBtn,'border-color');
							}
						}else{
							jQuery('.close-btn-container').hide();
						}

			}else if(dataInput == "column-width"){

			// console.log(value);

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
				}

			// console.log(value);
		}//loop


	},
	_globalSetEditor:function(e){
		let sepInput = jQuery(this);

		// console.log( sepInput[0] );
		// console.log( sepInput.val() );
		// return;

		if (sepInput) {
				let checkDatatype = sepInput.data('type');
				let inputData = sepInput.data('global-input');
				let inputValue = sepInput.val();
						let setHiddenInputI = jQuery('input[type="hidden"][data-global-save]');
						let setHiddenInput = setHiddenInputI;
						if (setHiddenInput.val()) {
							setHiddenInput = JSON.parse(setHiddenInput.val());
						}
				let checkArray = (typeof setHiddenInput === 'object')?true:false;
				if (inputData == 'main-wrapper') {

						if (sepInput.data('show-range') == 'wrapper-width') {
							jQuery('.wppb-popup-custom .wppb-popup-custom-wrapper').css('width',inputValue);
							if(checkArray)setHiddenInput['wrapper-width'] = inputValue;
						}else if ( sepInput.data('padding') ) {
							let optPerform = jQuery('.wppb-popup-custom .wppb-popup-custom-content');
							Custom_popup_editor._globalPadding('padding',sepInput,optPerform,inputValue);
							if(checkArray)setHiddenInput['global-padding'] = optPerform.css('padding');
						}else if ( sepInput.data('origin') == 'padding' ) {
							let optPerform = jQuery('.wppb-popup-custom .wppb-popup-custom-content');
							Custom_popup_editor._globalPadding('padding-origin',sepInput,optPerform,inputValue);
							if(checkArray)setHiddenInput['global-padding'] = optPerform.css('padding');
						}
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
							jQuery('.wppb-popup-custom .wppb-popup-overlay-custom-img').attr('data-overlay-image','none').css('background-image','none');
							if ('overlay-image-url' in setHiddenInput) delete setHiddenInput['overlay-image-url'];

						}
				}else if (inputData == 'close-font-size') {
					jQuery('.wppb-popup-custom .wppb-popup-close-btn').css('font-size',inputValue+'px');
				}else if (inputData == 'close-option') {
							if(checkArray)setHiddenInput['close-type'] = inputValue;

							if (inputValue == 1 || inputValue == 2) {
								let closeBtn = '<span class="wppb-popup-close-btn dashicons dashicons-no-alt"></span>';
								jQuery('.wppb-popup-custom .wppb-popup-custom-content').prepend(closeBtn);
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
							if ( sepInput.data('border') == 'border-enable' ) {
								Custom_popup_editor._borderFn( 'border-enable', optPerform,sepInput,inputValue);
							}else{
								Custom_popup_editor._borderFn( 'border' , optPerform,sepInput,inputValue);
							}
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
				}

				if (checkArray)setHiddenInputI.val( JSON.stringify(setHiddenInput) );

		}

	},
	_borderFn:function(changeData,clickedObj,changedInput,changeValue){
		let container = changedInput.closest('.content-style-border');
		if (changeData == 'border-enable') {
			if (changedInput.prop('checked')) {
				clickedObj.css("border",'1px solid orange');
				container.find('.content-border').show();
			}else{
				container.find('.content-border').hide();
				Custom_popup_editor._removeStyle(clickedObj,'border');
			}
		}else if (changeData == 'border' && container.find('[type="checkbox"][data-border]').prop('checked')) {
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
	_marginPadding:function(changeData,changedInput,clickedObj,changeValue){
		if(changeData == 'margin'){
			let marginOrigin = changedInput.data('margin');
			let getCheckBox = changedInput.closest('.paraMeterContainer__').find('[data-editor-input="margin-origin"]');
			if (getCheckBox.prop('checked')) {
				clickedObj.css('margin',changeValue+'px');
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(changeValue);
			}else{
				clickedObj.css('margin-'+marginOrigin,changeValue+'px');
			}
		}else if(changeData == 'margin-origin'){
			if (changedInput.prop('checked')) {
				let getFirstInput = changedInput.closest('.paraMeterContainer__').find('input[data-margin="top"]');
				let getFirstValue = getFirstInput.val()?getFirstInput.val():0;
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(getFirstValue);
				clickedObj.css('margin',getFirstValue+'px');
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
		}else if(changeData == 'padding-origin'){
			if (changedInput.prop('checked')) {
				let getFirstInput = changedInput.closest('.paraMeterContainer__').find('input[data-padding="top"]');
				let getFirstValue = getFirstInput.val()?getFirstInput.val():0;
				changedInput.closest('.paraMeterContainer__').find('input[type="number"]').val(getFirstValue);
				clickedObj.css('padding',getFirstValue+'px');
			}
		}

	},
	_rlRemoveElement:function(){
		let button = jQuery(this);
		button.closest('.data-rl-editable-wrap').remove();
		jQuery('.rl_i_editor-item-content').hide();
	},
	_chooseLayout:function(){

		let clickedLaout = jQuery(this);
		let getLayout = clickedLaout.data('layout');
		    getLayout =   jQuery('.prebuilt-pupup-layout-container > div[data-layout="'+getLayout+'"]').html();
		let putLayout = jQuery('.wppb-popup-custom');
		let saveLAyout = {layout:clickedLaout.attr('data-layout')};
		let setHiddenInputI = jQuery('input[type="hidden"][data-global-save]');
		setHiddenInputI.val( JSON.stringify(saveLAyout) );
		putLayout.html(getLayout);
		jQuery('.prebulit-demo-popup').hide();
		jQuery('.wppb-popup-name').show();
	},
	_popupName:function(){
		let inputValue = jQuery('input[name="wppb-popup-name"]').val();

			if (inputValue) {

				let setHiddenInputI = jQuery('input[type="hidden"][data-global-save]');
				let setHiddenInput = setHiddenInputI;
				if (setHiddenInput.val()) {
					setHiddenInput = JSON.parse(setHiddenInput.val());
				}
				let checkArray = (typeof setHiddenInput === 'object')?true:false;
				if(checkArray)setHiddenInput['popup-name'] = inputValue;
				if (checkArray)setHiddenInputI.val( JSON.stringify(setHiddenInput) );
				jQuery('.wppb-popup-name').hide();
				jQuery('.wppb-popup-custom').show();
				jQuery('.rl_i_editor-inner-wrap-mask').remove();
				Custom_popup_editor._dragAndShort();
				Custom_popup_editor._globalSettingInit();

			}else{
				alert('fill the popup name');
			}
	
	},
	_leadFormOpenPanel:function(){
		let getForm = jQuery(this);
		jQuery('.rl-lead-form-panel').slideDown('fast');
		// close container while open content style
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
		}


	},
	_leadFormChoose:function(){
		let select = jQuery(this);
		let form_id = select.val();
  		if ( parseInt(form_id) ) {
  			let data_ = {action:'getLeadForm',form_id:form_id};
			let returnData = Business_news_letter._ajaxFunction(data_);
			returnData.success(function(response){
				if (response && response != 0) {
					let replace_form = "<div class='wppb-popup-lead-form' data-form-id='"+form_id+"'>"+response+"</div>"; 
					if ( jQuery('.wppb-popup-lead-form[data-form-id]').length ) {
						jQuery('.wppb-popup-lead-form[data-form-id]').replaceWith(replace_form);
					}else{
						jQuery('#lf-business-popup').replaceWith(replace_form);
					}
				}
			});
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


		jQuery(document).on('click', '.prebulilt-popup-inner [data-layout]', Custom_popup_editor._chooseLayout);
		jQuery(document).on('click', '.wppb-popup-name-init', Custom_popup_editor._popupName);

	},
	_emToPxUnit:function(sum,param){
		if (param == 'px') {
			return sum * 10;
		}else if (param == 'em') {
			return sum % 10;
		}
	},
	_chooseImage:function(e){
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
		select_element.css('background-color',getColorValue);
		// Custom_popup_editor._setStyleColor(select_element,getColorValue,getColorProperty);

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
		  Custom_popup_editor._setStyleColor(clickedObj,color_,getColorProperty);
			  if (getColor && getColor[0].tagName == 'INPUT'){
					getColor.val(color_).change();		  	
			  }
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






// https://app.slack.com/client/T9BQYES21/DK4UD39SQ?cdn_fallback=2