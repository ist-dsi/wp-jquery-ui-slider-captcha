(function( $ ) {

	$(document).ready( function () {

		$( '#slider_captcha_form_selector' ).change(function () {
			$( '#form_options_container > fieldset' ).css({'visibility': 'hidden', 'position': 'absolute'}).height( 0 );
			$( '#' + $(this).val() + '_options_container' ).css({'visibility': 'visible', 'position': 'relative'}).height( 'auto' );
		});

		//$( '#general_slider' ).sliderCaptcha();
		
		$( '#live_preview_container p' ).eq(2).click( function () {
			
			$( this ).prev().empty().sliderCaptcha();

			return !1;
		})

		parseSliderCaptchaSettings( $( '#form_options_container > fieldset' ).eq(0) );
	})


	var parseSliderCaptchaSettings = function ( el ) {
		var $el = el,
			el_id = $el.attr( 'id' ),
			key = el_id.replace( '_options_container', '' ),
			form_object = $( '#' + key + '_options_container' ), obj = {};

			obj['type'] = form_object.find( '[name^=slider_type]' ).val();
			obj['textFeedbackAnimation'] = form_object.find( '[name^=slider_animation_type]' ).val();
			obj['hintText'] = form_object.find( '[name^=hint_text_before_unlock]' ).val();
			obj['hintTextSize'] = form_object.find( '[name^=hintTextSize]' ).val();
			obj['textAfterUnlock'] = form_object.find( '[name^=hint_text_after_unlock]' ).val();


			form_object.find( '[name^=slider_width]' );
			form_object.find( '[name^=slider_height]' );

			
			form_object.find( '[name^=knob_icon_face_before_unlock]' );
			form_object.find( '[name^=knob_color_before_unlock]' );
			form_object.find( '[name^=knob_text_color_before_unlock]' );
			form_object.find( '[name^=knob_top_offset_before_unlock]' );
			form_object.find( '[name^=knob_right_offset_before_unlock]' );
			form_object.find( '[name^=hint_text_size_before_unlock]' );
			form_object.find( '[name^=hint_text_color_before_unlock]' );

			form_object.find( '[name^=knob_icon_face_after_unlock]' );
			form_object.find( '[name^=knob_color_after_unlock]' );
			form_object.find( '[name^=knob_text_color_after_unlock]' );
			form_object.find( '[name^=knob_top_offset_after_unlock]' );
			form_object.find( '[name^=knob_right_offset_after_unlock]' );
			
			form_object.find( '[name^=hint_text_color_after_unlock]' );


			console.log( obj );
	}

})(jQuery)