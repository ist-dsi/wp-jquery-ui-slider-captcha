(function( $ ) {

	$(document).ready( function () {
		$( '#general_slider' ).sliderCaptcha();
		
		$( '#live_preview_container p' ).eq(2).click( function () {
			
			$( this ).prev().empty().sliderCaptcha();

			return !1;
		})
	})

})(jQuery)