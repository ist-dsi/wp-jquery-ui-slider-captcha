<?php


class sliderCaptchaShortCode extends sliderCaptchaModule {
	
	public $name = "Shortcode";
	public $instance_number = 0;


	private $attributes = array(
		"type" => "type",
		"textfeedbackanimation" => "textFeedbackAnimation",
		"hinttext" => "hintText",
		"hinttextsize" => "hintTextSize",
		"hinttextafterunlock" => "hintTextAfterUnlock",
		"knobcolor" => "knobColor",
		"knobcolorafterunlock" => "knobColorAfterUnlock",
		"backgroundcolor" => "backgroundColor",
		"textcolor" => "textColor",
		"textcolorafterunlock" => "textColorAfterUnlock",
		"width" => "width",
		"height" => "height",
		"top" => "top",
		"right" => "right",
		"icon" => "icon",
		"textcolor" => "textColor",
		"textcolorafterunlock" => "textColorAfterUnlock",
		"topafterunlock" => "topAfterUnlock",
		"rightafterunlock" => "rightAfterUnlock",
		"iconafterunlock" => "iconAfterUnlock",
		"afterunlock" => "afterUnlock",
		"beforeunlock" => "beforeUnlock",
		"beforesubmit" => "beforeSubmit",
		"submitafterunlock" => "submitAfterUnlock",
		"validateonserver" => "validateOnServer",
		"validateonserverparamname" => "validateOnServerParamName"
		);

	public function __construct($machine_name, &$instance) {
		parent::__construct($machine_name, $instance);
	}

	/**
	 * Returns true if the  module is a type of slider
	 */
	public function is_a_type() {
		return false;
	}

	/**
	 * Init the WordPress hooks
	 */
	function init_hooks() {
		add_shortcode("sliderCaptcha",array(&$this,'draw_shorttag'));

	}	

	public function draw_shorttag($attr, $content = null) {
		$instance = $this->instance_number++;
		ob_start();
		slider_captcha('custom_short_'.$instance,'p',$this->translate_array($attr));
		$output_string = ob_get_contents();
		ob_end_clean();

		return $output_string;
	}

	private function translate_array($array) {
		$result = array();
		foreach($array as $key => $value) {
			$exploded = explode('_',$key);
			if(sizeof($exploded) == 1 && isset($this->attributes[$exploded[0]]))
				$result[ $this->attributes[$exploded[0]] ] = $value;
			else if (sizeof($exploded) == 2 && isset($this->attributes[$exploded[1]]))
				$result[ $exploded[0] ][ $this->attributes[$exploded[1]] ] = $value;
			
		}
		return $result;
	}
}