<?php
/**
 * Include the slider captcha on any place
 */
function slider_captcha($slider_name = 'general', $container = 'p', $settings = null) {
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

function slider_get_slider_options($slider_name) {
	global $sliderCaptcha;
	return $sliderCaptcha->get_slider($slider_name);
}

/**
 * Update a slider with a $slider_name.
 * If doesn't exist, create a new slide
 */
function slider_update_slider($slider_name, array $options) {
	global $sliderCaptcha;
	return $sliderCaptcha->update_slider($slider_name, $options);

}


function _slider_draw_fontface_options($field='',$options) {
	include SLIDER_CAPTCHA_PATH . 'font_face_options.php';
}