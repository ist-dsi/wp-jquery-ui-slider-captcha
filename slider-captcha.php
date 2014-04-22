<?php
/*
Plugin Name: Slider Captcha
Plugin URL: http://nme.ist.utl.pt
Description: Slider Captcha is a module that will replace all the captcha from WordPress. 
Version: 0.6
Author: NME - Núcleo de Multimédia e E-Learning.
Author URI: http://nme.ist.utl.pt
Text Domain: slider_captcha
*/

// plugin folder url
if(!defined('SLIDER_CAPTCHA_URL')) {
	define('SLIDER_CAPTCHA_URL', plugin_dir_url( __FILE__ ));
}

if(!defined('SLIDER_CAPTCHA_PATH')) {
	define('SLIDER_CAPTCHA_PATH', plugin_dir_path( __FILE__ ));
}

class SliderCaptcha {

	/* Private */

	private $options;
	private $plugin_version = '0.6';

	/* Public */

	public $js_settings;
	public $settings;

	public $captcha_locations;
	private $sliders; //Array where the sliders will be structured. 

	function __construct() {

		// Load the languages
		add_action('init' ,array(&$this, 'lang_init'));

		// Load all the scripts required
		add_action( 'wp_enqueue_scripts', array(&$this, 'register_scripts' ));

		// Draw the captcha on the comment form
		add_action('comment_form', array($this,'render_slider_on_comments'));

		// Validate the captcha after comment is made
		add_filter('preprocess_comment', array($this, 'hook_validate_slider'));

		// Admin register function
		add_action( 'admin_menu', array( $this, 'register_menus' ), 49);
		add_action( 'admin_head', 'admin_color_scheme');

		// Load front-end srcipts for live preview		
		add_action( 'admin_enqueue_scripts', array(&$this, 'register_scripts' ));
		add_action( 'admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));

	}

	function init_default() {
		//Slider default settings
		$this->js_settings = array(
			'hintText' => __('Swipe to Validate','slider_captcha'),
			'textAfterUnlock' => __("You can now Submit",'slider_captcha'),
			'events' => array(
				'validateOnServer' => true,
				),
			);
		$this->settings = array(
			'containerClass' => null,
			'enabled' => 1,
			);

		$default_sliders = array(
			'general' => array_merge($this->js_settings, $this->settings),
			);

		$this->sliders = get_option('slider_captcha_sliders',$default_sliders);

		$this->captcha_locations = array(
				'general' 	    	=> __( 'General options' ,'slider-captcha'),
				'comments'			=> __( 'Comments form' ,'slider-captcha'),
				'registration'		=> __( 'Registration form' ,'slider-captcha'),
				'reset_password' 	=> __( 'Reset password form' ,'slider-captcha'),
				'login' 			=> __( 'Login form', 'slider-captcha'),
			);
	}

	function admin_color_scheme() {
   		global $_wp_admin_css_colors;
   		//$_wp_admin_css_colors = 0;
	}

	/**
	 * Initialize the language domain of the plugin
	 */
	function lang_init() {
	   if (function_exists('load_plugin_textdomain')) {
	       load_plugin_textdomain( 'slider_captcha', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/');
	   }
	   // Initialize the default settings
       $this->init_default();

	}

	public function register_scripts() {

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-touch-punch', plugins_url( '/js/jquery.ui.touch-punch-improved.js', __FILE__ ), array('jquery-ui-core','jquery-ui-mouse','jquery'), '0.3.1',false);
	
		wp_enqueue_script('jquery-slider-captcha', plugins_url( '/js/slider-captcha.min.js', __FILE__ ), array('jquery-ui-core','jquery-ui-touch-punch'), $plugin_version,false);
		
		wp_enqueue_style('slider-captcha-css', plugins_url( '/css/slider-captcha.css', __FILE__ ), $plugin_version );
	}

	/**
	 * Function that will render the Slider Captcha
	 * @return echos the code
	 */
	public function render_slider_on_comments($post_id) {

		?>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {

				if($("#commentform .form-submit").before('<p id="auto_slidercaptcha"></p>')) {
					//Load the slider captcha
					$("#auto_slidercaptcha").sliderCaptcha(<?=json_encode($this->settings)?>);
				}
			});
		});
		</script>
		<?
	}
	

	public function hook_validate_slider($comment_data) {
		$validateOnServer = $_POST['slider_captcha_validated'];
		if( $validateOnServer != 1)
			wp_die(__("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation... Please make sure you have Javascript enabled on your browser.",'slider_captcha'));
		return $comment_data;
	}

	/**
	 * Admin interface functions 
	 */
	public function register_menus() {
		// This page will be under "Settings"
		add_options_page(
			'options-general.php', 
			'Slider Captcha', 
			'manage_options', 
			'slider-captcha-setting', 
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page() {
	    //$this->options = get_option( 'my_option_name' );
	    ?>
	    <div class="wrap">
	        <?php screen_icon(); ?>
			<h2><?php _e( 'Slider Captcha Settings', 'slider_captcha' ) ?></h2>
	        <form method="post" action="#">
				<?php include( "views/slider-captcha-admin.php" ); ?>
	        </form>
		</div>
		<?php
	}

	public function register_admin_scripts($hook) {
		if( $hook == "settings_page_slider-captcha-setting" ) {

			wp_enqueue_script( 'slider-captcha-admin', plugins_url( '/js/slider-captcha-admin.js', __FILE__), array( 'jquery' ), $plugin_version );

			//Register CSS files
			wp_register_style( 'slider-captcha-admin-css', plugins_url( '/css/slider-captcha-admin.css', __FILE__), array(), $plugin_version );
			wp_enqueue_style( 'slider-captcha-admin-css' );
		}
	}

	/**
	 * Public functions to manage the sliders
	 */
	public function get_slider($slider_name) {
		if( !isset($this->sliders[$slider_name]) )
			return $this->sliders['general'];
		return $this->sliders[$slider_name];
	}

	public function update_slider($slider_name, $options) {
		$curr_slide = $this->get_slider($slider_name);
		$options = array_merge($curr_slide, $options);

		return $this->add_to_sliders($slider_name, $options);
	}

	public function get_sliders() {
		return $this->sliders;
	}

	public function set_sliders(array $s) {
		$this->sliders = $s;
		return update_option('slider_captcha_sliders', $s);
	}

	public function add_to_sliders($slide_name, array $options) {
		$sliders = $this->get_sliders();
		$sliders[$slide_name] = $options;
		return $this->set_sliders($sliders);
	}

	public function get_json_settings($slider) {
		return json_encode($this->get_slider($slider));
	}
}

$GLOBALS['sliderCaptcha'] = new SliderCaptcha();

include "functions.php";