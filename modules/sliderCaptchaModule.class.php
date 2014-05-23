<?php


abstract class sliderCaptchaModule {

	public $name = "Unknown name";

	public $defaults = null;

	protected $sliderCaptcha;
	protected $machine_name;

	public function __construct($machine_name, &$instance) {
		$this->sliderCaptcha = $instance;
		$this->machine_name = $machine_name;
	}

	/**
	 * If this module should be enabled (if meets the requerements)
	 */
	public function is_enabled() {
		return true;
	}

	/**
	 * Returns true if the  module is a type of slider
	 */
	public function is_a_type() {
		return true;
	}

	/**
	 * Init the WordPress hooks
	 */
	public abstract function init_hooks();	

	/*
	 * Init the scripts
	 */
	public function init_scripts() {
		return true;
	}

	public function has_defaults() {
		return $this->defaults != NULL && is_array($this->defaults) && count($this->defaults) > 0;
	}
}