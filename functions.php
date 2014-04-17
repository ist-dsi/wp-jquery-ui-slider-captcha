<?php
/**
 * Include the slider captcha on any place
 */
function slider_captcha($container = 'p', $settings = null) {
	global $sliderCaptcha;
	if($settings == null)
		$settings = array_merge($sliderCaptcha->js_settings, $sliderCaptcha->settings);
	else
		$settings = array_merge($sliderCaptcha->js_settings, $sliderCaptcha->settings, $settings);

	$container_class = (isset($settings['containerClass']) && $settings['containerClass']!=NULL 
		? 'class="' . $settings['containerClass'] . '"' : '');

	?>
		<<?=$container?> <?=$container_class?> id="slidercaptcha"> </<?=$container?>>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
				//Load the slider captcha
				$("#slidercaptcha").sliderCaptcha(<?=json_encode($settings)?>);
			});
		});
		</script>
	<?

}


function _slider_draw_fontface_options($selected='') {
	include SLIDER_CAPTCHA_PATH . 'font_face_options.php';
}