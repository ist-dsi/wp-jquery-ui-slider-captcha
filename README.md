WordPress jQuery UI Slider Captcha
===========================

The WordPress jQuery UI Slider Captcha is a WordPress plugin that will allow you to replace or add a CAPTCHA field to the comment form.

Using the [jQuery UI Slider Captcha](https://github.com/tecnicolisboa/jquery-ui-slider-captcha "jQuery UI Slider Captcha"), we provide an easy way to implement this new method of CAPTCHA interaction on your WordPress.

This plugin was developed by the Computer and Network Services of Técnico Lisboa due to usability concerns with the traditional captcha tool. We wanted to provide a more fluid and quick interaction to the user, while maintaining the validation pattern that a web form requires. This plugin was inspired in similar approaches found in the web.

This plugin is currently on WordPress plugins repository, and it is called [Slider Captcha](http://wordpress.org/plugins/slider-captcha/).

## Usage

After the plugin initialization, the CAPTCHA should appear *automagically* on your theme's comment form. If not, of if you want to use the captcha in other part of your template/plugin, you may do like this:

```php
<?php if(function_exists('slider_captcha'))
	slider_captcha();
?>
```

This function have two arguments, both optional. The first one is the CAPTCHA container, and by default is a `<p></p>`. The second argument is a array of settings, that will JSON encoded to the original [jQuery UI Slider Captcha](https://github.com/tecnicolisboa/jquery-ui-slider-captcha "jQuery UI Slider Captcha") (check the settings over there).

You can also change the default settings on the [wp-slider-captcha.php](wp-slider-captcha.php) file.

In a future version, there will be a settings panel where you can costumize the appearance and the behave of this plugin.

## Installation

Just download and extract slider-captcha to your `wp-content/plugins` directory.

## Changelog

### 1.2
 - New feature that allows to add a slider in a template by php or JavaScript code or through shortcode in content editor
 - Bug fixed for more than one form in contact form 7 

### 1.1.1
 - Fixed Contact Form bug when plugin not installed.

### 1.1
 - Contact Form 7 support added
 - Abstract class for other plugins support in the future created.
 - Bug fixes

### 1.0.1 
 - Bug fixed with saves and settings override
 - jQuery Slider Captcha version updated

### 1.0
 - Code refactorization
 - Multiple sliders on the same page are now possible
 - Settings page included with live preview
 - Updated jQuery Slider Captcha to the latest version with new properties names
 - Added three extra sliders (register form; login form; lost password form.)
 - Bug fixes

### 0.5.4
 - Version 0.5.4 added, fixed major bug
 
###  0.5.2
 - Added `containerClass` setting to allow a custom class name to the container
 - Fixed bug with Entypo on Windows deviced
 - Added new version of jQuery UI Slider Captcha

### 0.5.1
* jQuery Slider Captcha version updated with bugfix in HTML5 form validations

### 0.5
 - Initial release.

## License

This plugin is available under the [GPLv3 license](https://www.gnu.org/copyleft/gpl.html).
