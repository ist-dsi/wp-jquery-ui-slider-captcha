<?php

class slider_captcha_mailpress extends sliderCaptchaModule {

	public $name = "MailPress";
	/**
	 * Default settings for the mailpress slider
	 */
	public $defaults = array(
		"events" => array(
			"validateOnServer" => "1", 
			"submitAfterUnlock" => "1")
		);

	public $instance_number = 0;

	public function __construct($machine_name, &$instance) {
		parent::__construct($machine_name, $instance);	
	}

	public function init_hooks() {
		if($this->sliderCaptcha->is_slider_enabled($this->machine_name)) {
			add_action('MailPress_form',array(&$this, 'draw_slider'),10,2);
			add_filter('MailPress_form_defaults', array(&$this,'turn_js_css_on'));
		}

	}

	public function is_enabled() {
		return class_exists('MailPress');
	}

	public function draw_slider($email, &$options) {
		$options['jq'] = false;
		$options['js'] = false;
		$container = "p";
		?>
		<<?php echo $container?> id="slidercaptcha-mailpress-<?php echo $this->instance_number?>"> </<?php echo $container?>>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
				//Load the slider captcha
				$("#slidercaptcha-mailpress-<?php echo $this->instance_number?>").sliderCaptcha(
					<?php echo json_encode($this->sliderCaptcha->get_slider($this->machine_name))?>);
			});
		});
		</script>
		<?
	}

	public function turn_js_css_on($defaults) {
		$defaults['jq'] = true;
		$defaults['js'] = true;

		return $defaults;
	}

}