(function(jQuery){
	Business_front = {
		init:function(){
			// console.log(window.location.search);
			let forBlockElementor = window.location.search;
			var getFilterUrl = [];
			if (forBlockElementor) {
				forBlockElementor = forBlockElementor.replace("?",'');
				forBlockElementor = forBlockElementor.split('&');
				forBlockElementor.forEach(function(value){
						let valueSplited = value.split('=');
						if(valueSplited[0])  getFilterUrl.push(valueSplited[0]);
						if(valueSplited[0])  getFilterUrl.push(valueSplited[1]);
					});
			}
			if (!getFilterUrl.includes("elementor-preview")){
				Business_front._show_popup();
			}
			
			Business_front._commonScript();
			Business_front._bind();
		},
		_show_popup:function(){

			let getPopup = jQuery('.wppb-popup-open.popup.active')[0];	

			if (getPopup) {
				getPopup = jQuery(getPopup);

				getPopup.hide();

				 let getHTml  = getPopup.html();
				 let setting_ = getPopup.find('input[name="popup-setting-front"]');				
					 setting_ = JSON.parse( setting_.val() );

				 let getOutSideColor = 'outside-color' in setting_ ? setting_['outside-color'] : '#535353f2';
				 let getEffect       = 'effect' in setting_ ? setting_['effect'] : 1;
				 let popupOpenTime       = 'popup-delay-open' in setting_ ? setting_['popup-delay-open'] : 4;
				 popupOpenTime  = popupOpenTime * 1000;
				 let popupAutoClose       = 'popup-delay-close' in setting_ ? parseInt(setting_['popup-delay-close']) : 0;

				 let effectClass = 'wppb-effect-one';
				 switch ( getEffect ){
			 		case 2:
			 		effectClass = 'wppb-effect-two';
			 			break;
			 		case 3:
			 		effectClass = 'wppb-effect-3';
			 			break;
			 		case 4:
			 		effectClass = 'wppb-effect-two';
				 }
				 let renderTohtml = '<div id="wppbPopupShow" class="wppb-popup-main-wrap '+effectClass+'"><div>';
				 renderTohtml += getHTml;
				 renderTohtml += '</div></div>';
				 
				 function addActivePopup(){
				 	jQuery('body').append(renderTohtml);
				 	let wppbPopupShow = jQuery('#wppbPopupShow'); 
				 	// set auto height
				 	let getContentHeight = wppbPopupShow.find('.wppb-popup-custom-content');
				 	if (getContentHeight.outerHeight() > (window.innerHeight - 150) ) {
				 		getContentHeight.css({'height':(window.innerHeight - 100) + 'px','overflow-y':'scroll'});
				 	}else if (getContentHeight.innerHeight() < getContentHeight.children().outerHeight() ) {
				 		getContentHeight.css({'overflow-y':'scroll'});
				 	}
				 	wppbPopupShow.css('background-color',getOutSideColor);
				 	wppbPopupShow.addClass('wppb_popup_active');
				 	jQuery('body').addClass('wppbPopupActive');

					// getPopup.removeClass('active');
					getPopup.remove();


					if (popupAutoClose > 0) {
						popupAutoClose = popupAutoClose * 1000;
						setTimeout(function(){
				 			Business_front._popupAutoClose(wppbPopupShow);
						},popupAutoClose);
				 	}
				 }

				 setTimeout(addActivePopup,popupOpenTime);
				 
			}
		},
		_validJsonStr:function(str){
			try {JSON.parse(str);} 
		    catch (e) {return false;}
		    return true;
		},
		_commonScript:function(){
				// close by out side function
				jQuery(document).mouseup(function(e){
				var businessPopupDemo = jQuery('#wppbPopupShow .wppb-popup-custom-wrapper');
				let setting_ = businessPopupDemo.find('input[name="popup-setting-front"]');		

				setting_ = Business_front._validJsonStr( setting_.val() ) ?JSON.parse( setting_.val() ):{};

				let getCloseParam = 'close-type' in setting_ ? setting_['close-type'] : 3;				
				if (getCloseParam == 2 || getCloseParam == 3) {
					 if (!businessPopupDemo.is(e.target) && businessPopupDemo.has(e.target).length === 0){
						jQuery('#wppbPopupShow.wppb_popup_active').removeClass('wppb_popup_active');
						jQuery('#wppbPopupShow').addClass('wppb_popup_shut');
				 		jQuery('body').removeClass('wppbPopupActive');
				 		var remove_modal = function(){
				 			jQuery('#wppbPopupShow').remove();
				 			if (jQuery('.wppb-popup-open.active').length) {
								Business_front._show_popup();
				 			}
				 		}
				 		setTimeout(remove_modal,500);
	                 }
				}
			});
		},
		_popupAutoClose:function(element_){
				element_.removeClass('wppb_popup_active');
				element_.addClass('wppb_popup_shut');
			 	jQuery('body').removeClass('wppbPopupActive');
			 	var remove_modal = function(){
			 			element_.remove();
			 			if (jQuery('.wppb-popup-open.active').length) {
							Business_front._show_popup();
			 			}
			 		}
			 setTimeout(remove_modal,500);
		},
		_closeFunctionByIcon:function(e){
			e.preventDefault();
				let button = jQuery(this);
						button.closest('#wppbPopupShow.wppb_popup_active').removeClass('wppb_popup_active');
					jQuery('#wppbPopupShow').addClass('wppb_popup_shut');
				 	jQuery('body').removeClass('wppbPopupActive');
				 	var remove_modal = function(){
				 			jQuery('#wppbPopupShow').remove();
				 			if (jQuery('.wppb-popup-open.active').length) {
								Business_front._show_popup();
				 			}
				 		}
				 setTimeout(remove_modal,500);
		},
		_bind:function(){
			jQuery(document).on('click', '.wppb-popup-close-btn', Business_front._closeFunctionByIcon);
		}
	}
	Business_front.init();
})(jQuery);