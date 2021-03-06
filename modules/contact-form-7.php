<?php

class slider_captcha_cf7 extends sliderCaptchaModule {

	public $name = "Contact Form 7";

	public $instance_number = 0;

	public function __construct($machine_name, &$instance) {
		parent::__construct($machine_name, $instance);

		if($this->is_enabled()) {
			add_action('init', array(&$this, 'add_slider_captcha_shortcode'));
			//Register Contact Form 7 shortcode
			add_action('admin_init', array(&$this, 'add_tag_generator'), 45);
		}	
	
	}

	public function init_hooks() {
		if($this->sliderCaptcha->is_slider_enabled($this->machine_name)) {
			//Load the messages
			add_filter('wpcf7_messages', array(&$this,'cf7_messages'));
			//Validate the captcha
			add_filter('wpcf7_validate_slidercaptcha', array(&$this, 'cf7_validate_captcha'), 10, 2);
		}

	}

	public function is_enabled() {
		return class_exists('WPCF7_ContactForm');
	}

	public function add_slider_captcha_shortcode() {
		wpcf7_add_shortcode('slidercaptcha', array(&$this, 'slidercaptcha_shortcode'), true);
	}

	public function slidercaptcha_shortcode($tag) {

		$validation_error = wpcf7_get_validation_error($tag['type']);
		$class = wpcf7_form_controls_class($tag['type']);
		
		//Generate the instance number, to allow multiple sliders on same form.
		$instance = $this->instance_number++;

		if($validation_error)
			$validation = "<span role='alert' class='wpcf7-not-valid-tip'>$validation_error</span>";

		return	'<span class="wpcf7-form-control-wrap slidercaptcha"><div id="'.$tag['type'].$instance.'"></div></p>' . $validation . '
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#'.$tag['type'].$instance.'").sliderCaptcha('.  json_encode($this->sliderCaptcha->get_slider($this->machine_name)) .');
			});
		});
		</script></span>';
	}

	function add_tag_generator() {
		if(!function_exists('wpcf7_add_tag_generator'))
			return;

		wpcf7_add_tag_generator(
			'slidercaptcha', 
			__('Slider CAPTCHA', 'slider_captcha'), 
			'slider-captcha', 
			array($this, 'tag_generator_rendering'));
	}

	function tag_generator_rendering(&$contact_form) {
		echo '<div id="slider-captcha" class="hidden">
			<form action="">
				<table>
					<tr>
						<td>
							' . __("To custumize the Slider CAPTCHA you must go to the Slider CAPTCHA's settings panel and change the layout.", 'slider_captcha') .' 
						</td>
					</tr>
				</table>
				<p>
				<p>
				<div class="tg-tag">
					'.esc_html(__('Copy this code and paste it into the form on the left.', 'slider_captcha')).'<br />
					<input value="[slidercaptcha]" type="text" readonly="readonly" onfocus="this.select()" />
				</div>
			</form>
		</div>';
	}


	function cf7_messages($messages){
		return array_replace_recursive(
			$messages,
			array(
				'bypassed' => array(
					'description' => __('Invalid CAPTCHA value.', 'slider-captcha'),
					'default' => __("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation. Please make sure you have JavaScript & Cookies enabled on your browser.",'slider_captcha')
				)
			)
		);
	}

	function cf7_validate_captcha($result, $tag) {
		if(!is_admin())	{
			if(!$this->sliderCaptcha->valid_request()) {
				$result['valid'] = FALSE;
				// TODO: Send the error message.
				// $result['reason'][$tag] = wpcf7_get_message('bypassed');
			}
		}
		return $result;
	}

}