<?php

class slider_captcha_cf7 extends sliderCaptchaModule {

	public $name = "Contact Form 7";

	public function __construct($machine_name, $instance) {
		parent::__construct($machine_name, $instance);

		add_action('init', array(&$this, 'add_slider_captcha_shortcode'));
		//Register Contact Form 7 shortcode
		add_action('admin_init', array(&$this, 'add_tag_generator'), 45);
	
	}

	public function init_hooks() {
		
	}

	public function is_enabled() {
		return class_exists('WPCF7_ContactForm');
	}

	public function add_slider_captcha_shortcode() {
		wpcf7_add_shortcode('slidercaptcha', array(&$this, 'slidercaptcha_shortcode'), true);
	}

	public function slidercaptcha_shortcode($tag) {
		return	'<p><div id="register_slider_captcha"></div></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#register_slider_captcha").sliderCaptcha('.  json_encode($this->sliderCaptcha->get_slider($this->machine_name)) .');
			});
		});
		</script>';
	}

	function add_tag_generator() {
		if(!function_exists('wpcf7_add_tag_generator'))
			return;

		wpcf7_add_tag_generator('slidercaptcha', __('Slider CAPTCHA', 'slider_captcha'), 'slider-captcha', array($this, 'tag_generator_rendering'));
	}

	function tag_generator_rendering(&$contact_form) {
		echo '<div id="slider-captcha" class="hidden">
			<form action="">
				<table>
					<tr>
						<td>
							' . __("To custumize the Slider Captcha you must go to the Slider CAPTCHA's settings panel and change the layout.", 'slider_captcha') .' 
						</td>
					</tr>
				</table>
				<p>
				<p>
				<div class="tg-tag">
					'.esc_html(__('Copy this code and paste it into the form on the left.', 'slider-captcha')).'<br />
					<input value="[slidercaptcha]" type="text" readonly="readonly" onfocus="this.select()" />
				</div>
			</form>
		</div>';
	}

}