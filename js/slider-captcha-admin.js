(function( $ ) {
	$(document).ready( function () {

		$('select').select2();

		$('.color_input').css('vertical-align', 'middle').wpColorPicker({
			change: function(event, ui) {
				$( '#slider_captcha_form_selector' ).change();
			},
			clear: function() {
				$( '#slider_captcha_form_selector' ).change();
			},
			palettes: false
		});

		$( '#live_preview_container p' ).eq(2).click( function () {
			$( '#slider_captcha_form_selector' ).change();

			return !1;
		});

		$( '#slider_captcha_form_selector' ).change(function () {				
			var general_options = parseSliderCaptchaSettings( $( '#form_options_container > fieldset' ).eq(0) ),
				individual_options = parseSliderCaptchaSettings( $( '#form_options_container > fieldset#' +  $(this).val() + '_options_container' ) );

			$( '#form_options_container > fieldset' ).removeClass('active').css({'visibility': 'hidden', 'position': 'absolute'}).height( 0 );
			$( '#' + $(this).val() + '_options_container' ).addClass('active').css({'visibility': 'visible', 'position': 'relative'}).height( 'auto' );

			$( '#general_slider' ).next().slideUp();
			$( '#general_slider' ).empty().sliderCaptcha( $.extend( true, {}, general_options, individual_options , {events: {afterUnlock: function () { $( '#general_slider' ).next().slideDown();}}} ) );

			if( 'custom' == $(this).val() )
				$('#custom_export_container').show()
			else
				$('#custom_export_container').hide()

			if ( $( '#custom_options_container' ).hasClass( 'active' ) )
				$( '#custom_export_container span.active a' ).click();

		}).change();

		$( '#form_options_container fieldset input, #form_options_container fieldset select').change(function () {
			$( '#slider_captcha_form_selector' ).change();
		});

		$( 'input[name*="[slider_type]"]' ).change(function () {
			if( 'filled' == $( this ).val() ) {
				$( this ).closest( 'p' ).next().slideDown().next().slideDown();
			} else {
				$( this ).closest( 'p' ).next().slideUp().next().slideUp();
			}
		})

		// Custom slider functions

		function getTemplateCode( template ) {
			return function getTemplateCodeWithParams ( params ) {
					return template.replace( '$1',  params);
			}
		}

		$( '#custom_export_container textarea').focus(function () {
			var $this = $(this);
			$this.select();

			$this.mouseup(function() {
				$this.unbind("mouseup");
				return false;
			});
		})

		var getTemplateCodePHP = getTemplateCode( '<?php if(function_exists("slider_captcha")) slider_captcha( "general", "p", $1); ?>' ),
			getTemplateCodeJS = getTemplateCode( '<script>(function($){jQuery(document).ready(function(){jQuery("#custom_slider_captcha").sliderCaptcha($1)})})(jQuery);</script><p id="custom_slider_captcha"></p>' ),
			getTemplateCodeSC = getTemplateCode( '[sliderCaptcha$1]' );

		$( '#custom_export_container span a' ).click(function () {

			var $textArea = $(this).parent().parent().find( 'textarea' );
			var general_options = parseSliderCaptchaSettings( $( '#form_options_container > fieldset' ).eq(0) ),
				individual_options = parseSliderCaptchaSettings( $( '#form_options_container > fieldset.active' ) ),
				merged_options = $.extend(true, {}, general_options, individual_options );

			$(this).parent().parent().find('span.active').removeClass( 'active' );
			$(this).parent().addClass( 'active' );

			switch( $(this).data( 'code' ) ) {
				case 'php':
					$textArea.val( getTemplateCodePHP( jsObj2phpObj( merged_options ) ) );
				break;
				case 'js':
					$textArea.val( getTemplateCodeJS( JSON.stringify( merged_options ) ) );
				break;
				case 'sc':
					$textArea.val( getTemplateCodeSC( jsObj2shortcode( merged_options ) ) );
				break;
			}

			return !1;
		}).eq(0).click();
	})

	var parseSliderCaptchaSettings = function ( el ) {
		var $el = el,
			el_id = $el.attr( 'id' ),
			key = el_id.replace( '_options_container', '' ),
			form_object = $( '#' + key + '_options_container' ), 
			obj = {},
			styles = {},
			face = {},
			events = {};

			obj['type'] = form_object.find( '[name*="[slider_type]"]:checked' ).val();
			obj['textFeedbackAnimation'] = form_object.find( '[name*="[slider_animation_type]"]:checked' ).val();
			
			if( '' != form_object.find( '[name*="[hint_text_before_unlock]"]' ).val() )
				obj['hintText'] = form_object.find( '[name*="[hint_text_before_unlock]"]' ).val();
			
			if( '' != form_object.find( '[name*="[hint_text_size_unlock]"]' ).val() )
				obj['hintTextSize'] = form_object.find( '[name*="[hint_text_size_unlock]"]' ).val();
			
			if ( '' != form_object.find( '[name*="[hint_text_after_unlock]"]' ).val() ) 
				obj['hintTextAfterUnlock'] = form_object.find( '[name*="[hint_text_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_color_before_unlock]"]' ).val() ) 
				styles['knobColor'] = form_object.find( '[name*="[knob_color_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_color_after_unlock]"]' ).val() )
				styles['knobColorAfterUnlock'] = form_object.find( '[name*="[knob_color_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[slider_background_color]"]' ).val() )
				styles['backgroundColor'] = form_object.find( '[name*="[slider_background_color]"]' ).val();

			if ( '' != form_object.find( '[name*="[hint_text_color_before_unlock]"]' ).val() )
				styles['textColor'] = form_object.find( '[name*="[hint_text_color_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[hint_text_color_after_unlock]"]' ).val() )
				styles['textColorAfterUnlock'] = form_object.find( '[name*="[hint_text_color_after_unlock]"]' ).val();
			
			if ( '' != form_object.find( '[name*="[slider_width]"]' ).val() )
				obj['width'] = form_object.find( '[name*="[slider_width]"]' ).val();

			if ( '' != form_object.find( '[name*="[slider_height]"]' ).val() )
				obj['height'] = form_object.find( '[name*="[slider_height]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_text_size_before_unlock]"]' ).val() )
				face['textSize'] = form_object.find( '[name*="[knob_text_size_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_top_offset_before_unlock]"]' ).val() )
				face['top'] = form_object.find( '[name*="[knob_top_offset_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_right_offset_before_unlock]"]' ).val() )
				face['right'] = form_object.find( '[name*="[knob_right_offset_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_icon_face_before_unlock]"]' ).val() )
				face['icon'] = form_object.find( '[name*="[knob_icon_face_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_text_color_before_unlock]"]' ).val() )
				face['textColor'] = form_object.find( '[name*="[knob_text_color_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_text_size_after_unlock]"]' ).val() )
				face['textSizeAfterUnlock'] = form_object.find( '[name*="[knob_text_size_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_text_color_after_unlock]"]' ).val() )
				face['textColorAfterUnlock'] = form_object.find( '[name*="[knob_text_color_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_top_offset_after_unlock]"]' ).val() )
				face['topAfterUnlock'] = form_object.find( '[name*="[knob_top_offset_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_right_offset_after_unlock]"]' ).val() )
				face['rightAfterUnlock'] = form_object.find( '[name*="[knob_right_offset_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_icon_face_after_unlock]"]' ).val() )
				face['iconAfterUnlock'] = form_object.find( '[name*="[knob_icon_face_after_unlock]"]' ).val();
			
			events['validateOnServer'] = 1;
			
			obj['styles'] = styles;
			obj['face'] = face;
			obj['events'] = events;

			return obj;
	}

	function jsObj2phpObj( obj ) {
		var php = '';
	
		for(property in obj) {
			var val = obj[property];
	
			if( "string" == typeof(val) || "number" == typeof(val) )
				php += '"' + property + '" => "' + val + '",';
			else if( !val[0] )
				php += '"' + property + '" => ' + jsObj2phpObj( val ) + ',';
			else {
				php += '"' + property + '" => array(';
				for(prop in val)
					php += '"' + val[prop] + '",';
				php = php.slice(0,-1) + '),';
			}
		}
	
		return 'array(' + php.slice(0,-1) + ')';
	}

	function jsObj2shortcode( obj ) {
		var sc = '';
	
		for(property in obj) {
			var val = obj[property];

			if( "string" == typeof(val) || "number" == typeof(val) )
				sc += " " + property + '="' + val + '"';
			else if( !val[0] ) {
				var parent_prop = property;
				sc += jsObj2shortcode( val ).replace(/\s/g, ' ' + parent_prop + '_');
			}
			else {
				sc += ' ' + property + '="';
				for(prop in val)
					sc += val[prop] + ',';
				sc = sc.slice(0,-1) + '"';
			}
		}	
		return sc;
	}

})(jQuery)