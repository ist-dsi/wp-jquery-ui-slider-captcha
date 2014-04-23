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

		$( '#slider_captcha_form_selector' ).change(function () {
			$( '#form_options_container > fieldset' ).css({'visibility': 'hidden', 'position': 'absolute'}).height( 0 );
			$( '#' + $(this).val() + '_options_container' ).css({'visibility': 'visible', 'position': 'relative'}).height( 'auto' );
		});
		
		$( '#live_preview_container p' ).eq(2).click( function () {
			
			$( '#slider_captcha_form_selector' ).change();

			return !1;
		})

		$( '#general_slider' ).sliderCaptcha( parseSliderCaptchaSettings( $( '#form_options_container > fieldset' ).eq(0) ) );

		$( '#slider_captcha_form_selector' ).change(function () {
			var general_options = parseSliderCaptchaSettings( $( '#form_options_container > fieldset' ).eq(0) ),
				individual_options = parseSliderCaptchaSettings( $( '#form_options_container > fieldset#' +  $(this).val() + '_options_container' ) );

			$( '#general_slider' ).next().slideUp();
			$( '#general_slider' ).empty().sliderCaptcha( $.extend(true, {}, general_options, individual_options ) );

		});

		$( '#form_options_container input, #form_options_container select').change(function () {
			$( '#slider_captcha_form_selector' ).change();
		});

		$( '[name*="[slider_type]"]' ).change(function () {
			if( 'filled' == $( this ).val() ) {
				$( this ).closest( 'p' ).next().slideDown().next().slideDown();
			} else {
				$( this ).closest( 'p' ).next().slideUp().next().slideUp();
			}
		})
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
				obj['hintTextSize'] = form_object.find( '[name*="[hint_text_size_unlock]"]' ).val() + 'px';
			
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
				styles['width'] = form_object.find( '[name*="[slider_width]"]' ).val();

			if ( '' != form_object.find( '[name*="[slider_height]"]' ).val() )
				styles['height'] = form_object.find( '[name*="[slider_height]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_text_size_before_unlock]"]' ).val() )
				face['textSize'] = form_object.find( '[name*="[knob_text_size_before_unlock]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_top_offset_before_unlock]"]' ).val() )
				face['top'] = form_object.find( '[name*="[knob_top_offset_before_unlock]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_right_offset_before_unlock]"]' ).val() )
				face['right'] = form_object.find( '[name*="[knob_right_offset_before_unlock]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_icon_face_before_unlock]"]' ).val() )
				face['icon'] = form_object.find( '[name*="[knob_icon_face_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_text_color_before_unlock]"]' ).val() )
				face['textColor'] = form_object.find( '[name*="[knob_text_color_before_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_text_size_after_unlock]"]' ).val() )
				face['textSizeAfterUnlock'] = form_object.find( '[name*="[knob_text_size_after_unlock]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_text_color_after_unlock]"]' ).val() )
				face['textColorAfterUnlock'] = form_object.find( '[name*="[knob_text_color_after_unlock]"]' ).val();

			if ( '' != form_object.find( '[name*="[knob_top_offset_after_unlock]"]' ).val() )
				face['topAfterUnlock'] = form_object.find( '[name*="[knob_top_offset_after_unlock]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_right_offset_after_unlock]"]' ).val() )
				face['rightAfterUnlock'] = form_object.find( '[name*="[knob_right_offset_after_unlock]"]' ).val() + 'px';

			if ( '' != form_object.find( '[name*="[knob_icon_face_after_unlock]"]' ).val() )
				face['iconAfterUnlock'] = form_object.find( '[name*="[knob_icon_face_after_unlock]"]' ).val();
			
			events['validateOnServer'] = 1;
			events['afterUnlock'] = function () {
				$( '#general_slider' ).next().slideDown();
			};
			
			obj['styles'] = styles;
			obj['face'] = face;
			obj['events'] = events;

			//console.log( obj );

			return obj;
	}

})(jQuery)