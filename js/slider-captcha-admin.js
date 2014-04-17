(function( $ ) {

	$(document).ready( function () {

		$( '#slider_captcha_form_selector' ).change(function () {
			$( '#form_options_container > fieldset' ).css({'visibility': 'hidden', 'position': 'absolute'}).height( 0 );
			$( '#' + $(this).val() + '_options_container' ).css({'visibility': 'visible', 'position': 'relative'}).height( 'auto' );
		});

		$( '#general_slider' ).sliderCaptcha();
		
		$( '#live_preview_container p' ).eq(2).click( function () {
			
			$( this ).prev().empty().sliderCaptcha();

			return !1;
		})
	})

})(jQuery)