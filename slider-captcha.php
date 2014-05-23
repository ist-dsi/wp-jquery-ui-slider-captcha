<?php
/*
Plugin Name: Slider Captcha
Plugin URL: http://nme.ist.utl.pt
Description: Slider Captcha is a module that will replace all the captcha from WordPress. 
Version: 1.3.3
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


include SLIDER_CAPTCHA_PATH.'modules/sliderCaptchaModule.class.php'; //Load the abstract module class

class SliderCaptcha {

	/* Private */
	public $plugin_version = '1.3.4';

	private $load_modules; //Modules to be loaded
	private $modules; //Loaded modules classes

	/* Public */

	public $js_settings;
	public $settings;

	public $captcha_locations;
	private $sliders; //Array where the sliders will be structured. 

	private $last_version;

	function __construct() {

		// Load the languages
		add_action('init' ,array(&$this, 'lang_init'));

		// Load all the scripts required
		add_action( 'wp_enqueue_scripts', array(&$this, 'register_scripts' ));

		// Admin register function
		add_action( 'admin_menu', array( $this, 'register_menus' ), 49);
		add_action( 'admin_head', array( $this, 'admin_color_scheme'));

		// Load front-end srcipts for live preview		
		add_action( 'admin_enqueue_scripts', array(&$this, 'register_scripts' ));
		add_action( 'admin_enqueue_scripts', array(&$this, 'register_admin_scripts'));


		//Slider Captcha modules. @TODO add a filter
		$this->load_modules = array(
				'slider_captcha_cf7' => SLIDER_CAPTCHA_PATH . 'modules/contact-form-7.php',
				'slider_captcha_mailpress' => SLIDER_CAPTCHA_PATH . 'modules/mailpress.php',
				'sliderCaptchaShortCode' => SLIDER_CAPTCHA_PATH . 'modules/shortcode.php'
			);

		/**
		 * Modules loading
		 */
		$this->modules = array();
		foreach($this->load_modules as $module_name => $module_path) {
			if(file_exists($module_path)) {
				include $module_path;
				if(class_exists($module_name)) {
					//Load the module
					$this->modules[$module_name] = new $module_name($module_name, $this);
				}
			}
		}

		$this->last_version = get_option('slider_captcha_last_version',false);

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
			if(class_exists('BuddyPress')) {
				//Hooks related to the buddypress plugin.
				add_action('bp_before_registration_submit_buttons', array(&$this, 'render_slider_on_register'));
                add_action('bp_signup_validate', array(&$this, 'validate_register_slider_buddypress'));
			}
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
			$this->is_slider_enabled('reset_password')) {
			add_action( 'login_enqueue_scripts', array(&$this, 'register_scripts' ));
			add_action( 'login_enqueue_scripts', array(&$this, 'register_admin_scripts'));
		}

		//Modules hooks
		foreach($this->modules as $module)
			if($module->is_enabled())
				$module->init_hooks();

	}

	function init_default() {
		//Slider default settings
		$this->js_settings = array(
			'events' => array(
				'validateOnServer' => 1,
				'highValidationOnServer' => 1,
				),
			);
		$this->settings = array(
			'containerClass' => null,
			);

		$default_sliders = array(
			'general' => array_merge( 
				$this->js_settings,
				$this->settings,
				array('enabled' => 0)
				),
			);

		$default_sliders['comments'] = array_merge($default_sliders['general'], array(
				'enabled' => 1,
			));

		$this->captcha_locations = array(
				'general' 	    	=> __( 'General' ,'slider_captcha'),
				'comments'			=> __( 'Comments form' ,'slider_captcha'),
				'registration'		=> __( 'Registration form' ,'slider_captcha'),
				'reset_password' 	=> __( 'Reset password form' ,'slider_captcha'),
				'login' 			=> __( 'Login form', 'slider_captcha'),
			);

		//Get the settings
		$this->sliders = get_option('slider-captcha-sliders', $default_sliders);

		//Setup the modules
		foreach($this->modules as $module_name => $module) {
			//Add to the locations if enabled
			if($module->is_enabled() && $module->is_a_type()) {
				$this->captcha_locations[$module_name] = __( $module->name, 'slider_captcha');
				if($module->has_defaults())
					$this->update_slider($module_name, $module->defaults);
			}				
		}

		//The custom must be the last location to be generated.
		$this->captcha_locations['custom'] = __( 'Custom form', 'slider_captcha');

		// Init all the hooks
		$this->init_hooks();

		//Check if there was a update
		if($this->last_version == false || version_compare($this->last_version, $this->plugin_version, '<'))
			$this->on_update();

	}

	function on_update() {
		//First update the version
		#$this->last_version = $this->plugin_version;
		#update_option('slider_captcha_last_version',$this->plugin_version);
		//Add new defaults
		foreach($this->sliders as $slider_name=>$values)
			$this->update_slider($slider_name, array_merge($this->js_settings, $this->settings));
	}

	function admin_color_scheme() {
   		global $_wp_admin_css_colors;
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
		wp_enqueue_script('jquery-ui-touch-punch', plugins_url( '/js/jquery.ui.touch-punch-improved.js', __FILE__ ), array('jquery'), '0.3.1',false);
	
		wp_enqueue_script('jquery-slider-captcha', plugins_url( '/js/slider-captcha.js', __FILE__ ), array('jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-droppable', 'jquery-ui-draggable', 'jquery-ui-touch-punch'), $this->plugin_version, false);

		wp_enqueue_script('json2');
		
		wp_enqueue_style('slider-captcha-css', plugins_url( '/css/slider-captcha.css', __FILE__ ), $this->plugin_version );

		//Register modules scripts
		foreach($this->modules as $module)
			$module->init_scripts();
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
					$("#auto_slidercaptcha").sliderCaptcha(<?php echo json_encode($this->get_slider('comments'))?>);
				}
			});
		});
		</script>
		<?php
	}

	public function validate_comment_slider($comment_data) {
		$validateOnServer = $_POST['slider_captcha_validated'];
		if( $validateOnServer != 1)
			wp_die(__("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation. Please make sure you have JavaScript enabled on your browser.",'slider_captcha'));
		return $comment_data;
	}


	public function render_slider_on_register() {
		?>
		<p><div id="register_slider_captcha"></div></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#register_slider_captcha").sliderCaptcha(<?php echo json_encode($this->get_slider('registration'))?>);
			});
		});
		</script>
		<?php

		return true;
	} 
	
	public function validate_register_slider($login, $email, $errors) {
	
		/* If someone tryies to hack */
		if ( $_REQUEST['slider_captcha_validated'] != 1 ) {
			$errors->add( 'slider_captcha_missing', __("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation. Please make sure you have JavaScript enabled on your browser.",'slider_captcha') );
			return $errors;
		}

		return $errors ;
	}

	public function validate_register_slider_buddypress($result) {
	
		/* If someone tryies to hack */
		if ( $_REQUEST['slider_captcha_validated'] != 1 ) {
        	wp_die(__("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation. Please make sure you have JavaScript enabled on your browser.",'slider_captcha'));
		}

		return $result ;
	}

	public function render_slider_on_lost_password() {
		?>
		<p style="margin-bottom: 10px" id="lostpass_slider_captcha"></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#lostpass_slider_captcha").sliderCaptcha(<?php echo json_encode($this->get_slider('reset_password'))?>);
			});
		});
		</script>
		<?php

		return true;
	}

	public function validate_lost_password_slider() {
		//ignore validation if user_login is empty
		if( isset( $_REQUEST['user_login'] ) && $_REQUEST['user_login']=="" )
			return;

		$validateOnServer = $_POST['slider_captcha_validated'];
		if( $validateOnServer != 1)
			wp_die(__("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation. Please make sure you have JavaScript enabled on your browser.",'slider_captcha'));

	}

	public function render_slider_on_login() {
		?>
		<p style="margin-bottom: 10px" id="login_slider_captcha"></p>
		<script type="text/javascript">
		jQuery(function($) {
			$( document ).ready(function() {
					//Load the slider captcha
					$("#login_slider_captcha").sliderCaptcha(<?php echo json_encode($this->get_slider('login'))?>);
			});
		});
		</script>
		<?php

		return true;
	}

	public function validate_login_slider($user) {

		if ( "" == session_id() )
			@session_start();

		if(isset($_REQUEST['wp-submit'])) {
			$valid = false;
			//INICIO DA VALIDACAO: REFACTORIZAR
			$matrix_det = $_POST['m'];
			$slider_name =  $_POST['sliderName'];
			$validation_hash =  $_POST['slider_captcha_validated'];
			$cookie_hash = $_COOKIE['sh_'.$slider_name];
			//Okey, we have the matrix, lets calculate the determinant
			preg_match("/((-*[0-9]+),(-*[0-9]+),-*[0-9]+,(-*[0-9]+),(-*[0-9]+),-*[0-9]+,-*[0-9]+,-*[0-9]+,-*[0-9]+),(-*[0-9]+)/", 
				$matrix_det, $matrix_values);
			$matrix = $matrix_values[1];
			$a = $matrix_values[2];
			$b = $matrix_values[3];
			$c = $matrix_values[4];
			$d = $matrix_values[5];
			$determinant = $matrix_values[6];
			$calculated_det = $a * $d - ($b * $c);

			if($determinant != $calculated_det)
				die("validation failed"); //todo: return

			//Generate the md5 hash
			$generated_hash = md5("|$matrix|=$calculated_det;$cookie_hash");
			if($validation_hash != $generated_hash)
				die("validation failed"); //todo: return

			if( get_transient( "sct_$validation_hash" ) == $matrix) {
				die("validation failed");
			}

			set_transient("sct_$validation_hash",$matrix, 10 * DAY_IN_SECONDS);

			#var_dump($validateOnServer, $matrix,$slider_name,$validation_hash, $generated_hash ,$cookie_hash, $determinant, $calculated_det);
			$valid = true;

			if( !$valid ) {
				wp_clear_auth_cookie();
				$error = new WP_Error();
				$error->add( 'slider_captcha_missing', __("<strong>ERROR:</strong> Something went wrong with the CAPTCHA validation. Please make sure you have JavaScript enabled on your browser.",'slider_captcha') );
				return $error;
			} else {
				return $user;
			}
		}

		return $user;
	}

	/**
	 * Admin interface functions 
	 */
	public function register_menus() {
		// This page will be under "Settings"
		add_options_page(
			__('Slider CAPTCHA Settings', 'slider_captcha'), 
			'Slider CAPTCHA', 
			'manage_options', 
			'slider-captcha-settings', 
			array( $this, 'create_admin_page' )
		);
	}

	public function create_admin_page() {
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e('Slider CAPTCHA Settings', 'slider_captcha') ?></h2>
			<form method="post" action="">
				<?php include( "views/slider-captcha-admin.php" ); ?>
			</form>
		</div>
		<?php
	}

	public function register_admin_scripts($hook) {
		if( $hook == "settings_page_slider-captcha-settings" ) {

			wp_enqueue_script('wp-color-picker');
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script( 'select2-script', plugins_url('/js/select2/select2.js', __FILE__));
			wp_enqueue_style( 'select2', plugins_url('/js/select2/select2.css', __FILE__));

			wp_enqueue_script( 'slider-captcha-admin', plugins_url( '/js/slider-captcha-admin.js', __FILE__), array( 'jquery' ), $this->plugin_version );

			//Register CSS files
			wp_register_style( 'slider-captcha-admin-css', plugins_url( '/css/slider-captcha-admin.css', __FILE__), array(), $this->plugin_version );
			wp_enqueue_style( 'slider-captcha-admin-css' );
		}
	}

	/**
	 * Public functions to manage the sliders
	 */
	public function get_slider($slider_name) {
		if( !isset($this->sliders[$slider_name]) )
			return $this->sliders['general'];

		$curr_slide = _slider_array_filter_recursive($this->sliders[$slider_name]);
		return array_merge($this->sliders['general'], $curr_slide);
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
		return update_option('slider-captcha-sliders', $s);
	}

	public function add_to_sliders($slide_name, array $options) {
		$sliders = $this->get_sliders();
		$sliders[$slide_name] = $options;
		return $this->set_sliders($sliders);
	}

	public function get_json_settings($slider) {
		return json_encode($this->get_slider($slider));
	}

	public function is_slider_enabled($slider_name) {
		$slider = $this->get_slider($slider_name);
		return isset($slider['enabled']) && $slider['enabled'] == 1; 
	}

	public function remove_general_setting($setting_name, $child_setting = false) {
		$sliders = $this->get_sliders();
		if(!$child_setting)
			unset($sliders['general'][$setting_name]);
		else 
			unset($sliders['general'][$setting_name][$child_setting]);

		$this->set_sliders($sliders);

	}
}

$GLOBALS['sliderCaptcha'] = new SliderCaptcha();

include "functions.php";