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

		// Admin register function
		add_action( 'admin_menu', array( $this, 'register_menus' ), 49);
		add_action( 'admin_head', 'admin_color_scheme');

		// Load front-end srcipts for live preview		
		add_action( 'admin_enqueue_scripts', array(&$this, 'register_scripts' ));
		add_action( 'admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));

	}

	function init_hooks() {
		//Comments hook
		if( $this->is_slider_enabled('comments') ) {
			// Draw the captcha on the comment form
			add_action('comment_form', array($this,'render_slider_on_comments'));
			// Validate the captcha after comment is made
			add_filter('preprocess_comment', array($this, 'validate_comment_slider'));
		}

		//Registration hook
		if( $this->is_slider_enabled('registration') ) {
			add_action( 'register_form', array(&$this, 'render_slider_on_register') );
			add_action( 'register_post', array(&$this, 'validate_register_slider'),  10, 3 );
			add_action( 'signup_extra_fields', array(&$this, 'render_slider_on_register') );
		}
		
		//Lost password
		if ($this->is_slider_enabled('reset_password')) {
			add_action( 'lostpassword_form', array(&$this, 'render_slider_on_lost_password') );
			add_action( 'lostpassword_post', array(&$this, 'validate_lost_password_slider'),  10, 3 );
		}

		//Login password
		if ($this->is_slider_enabled('login')) {
			add_action( 'login_form', array(&$this, 'render_slider_on_login') );
			add_action( 'authenticate', array(&$this, 'validate_login_slider'),  30, 1);
		}

		//Load the css and styles on the login form	
		if ($this->is_slider_enabled('login') || $this->is_slider_enabled('registration') ||
			$this>is_slider_enabled('reset_password')) {
			add_action( 'login_enqueue_scripts', array(&$this, 'register_scripts' ));
			add_action( 'login_enqueue_scripts', array(&$this, 'register_admin_scripts'));
		}


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
			'general' => array_merge( 
				array_merge($this->js_settings, $this->settings),
				array('enabled' => 0)),
			);

		$default_sliders['comments'] = array_merge($default_sliders['general'], array(
				'enabled' => 1,
			));

		$this->sliders = get_option('slider_captcha_sliders',$default_sliders);

		$this->captcha_locations = array(
				'general' 	    	=> __( 'General options' ,'slider_captcha'),
				'comments'			=> __( 'Comments form' ,'slider_captcha'),
				'registration'		=> __( 'Registration form' ,'slider_captcha'),
				'reset_password' 	=> __( 'Reset password form' ,'slider_captcha'),
				'login' 			=> __( 'Login form', 'slider_captcha'),
			);

		// Init all the hooks
		$this->init_hooks();
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
					$("#auto_slidercaptcha").sliderCaptcha(<?=json_encode($this->get_slider('comments'))?>);
				}
			});
		});
		</script>
		<?
	}

	public function validate_comment_slider($comment_data) {
		$validateOnServer = $_POST['slider_captcha_validated'];
		if( $validateOnServer != 1)
			wp_die(__("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation... Please make sure you have Javascript enabled on your browser.",'slider_captcha'));
		return $comment_data;
	}


	public function render_slider_on_register() {
		?>
		<p><div id="register_slider_captcha"></div></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#register_slider_captcha").sliderCaptcha(<?=json_encode($this->get_slider('registration'))?>);
			});
		});
		</script>
		<?

		return true;
	} 
	
	public function validate_register_slider($login, $email, $errors) {
	
		/* If someone tryies to hack */
		if ( $_REQUEST['slider_captcha_validated'] != 1 ) {
			$errors->add( 'slider_captcha_missing', __("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation... Please make sure you have Javascript enabled on your browser.",'slider_captcha') );
			return $errors;
		}

		return $errors ;
	}

	public function render_slider_on_lost_password() {
		?>
		<p style="margin-bottom: 10px" id="lostpass_slider_captcha"></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#lostpass_slider_captcha").sliderCaptcha(<?=json_encode($this->get_slider('reset_password'))?>);
			});
		});
		</script>
		<?

		return true;
	}

	public function validate_lost_password_slider() {
		//ignore validation if user_login is empty
		if( isset( $_REQUEST['user_login'] ) && $_REQUEST['user_login']=="" )
			return;

		$validateOnServer = $_POST['slider_captcha_validated'];
		if( $validateOnServer != 1)
			wp_die(__("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation... Please make sure you have Javascript enabled on your browser.",'slider_captcha'));

	}

	public function render_slider_on_login() {
		?>
		<p style="margin-bottom: 10px" id="lostpass_slider_captcha"></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#lostpass_slider_captcha").sliderCaptcha(<?=json_encode($this->get_slider('login'))?>);
			});
		});
		</script>
		<?

		return true;
	}

	public function validate_login_slider($user) {

		if ( "" == session_id() )
			@session_start();

		if(isset($_REQUEST['wp-submit'])) {

			$validateOnServer = $_REQUEST['slider_captcha_validated'];
			if( $validateOnServer != 1) {
				wp_clear_auth_cookie();
				$error = new WP_Error();
				$error->add( 'slider_captcha_missing', __("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation... Please make sure you have Javascript enabled on your browser.",'slider_captcha') );
				return $error;
			} else {
				return $user;
			}

		}
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

	public function is_slider_enabled($slider) {
		$sliders = $this->get_sliders();
		return isset($sliders[$slider]['enabled']) && $sliders[$slider]['enabled'] == 1; 
	}
}

$GLOBALS['sliderCaptcha'] = new SliderCaptcha();

include "functions.php";