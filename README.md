WordPress jQuery UI Slider Captcha
===========================

The WordPress jQuery UI Slider Captcha is a WordPress plugin that will allow you to replace or add a CAPTCHA field to the comment form.

Using the [jQuery UI Slider Captcha](https://github.com/tecnicolisboa/jquery-ui-slider-captcha "jQuery UI Slider Captcha"), we provide an easy way to implement this new method of CAPTCHA interaction on your WordPress.

This plugin was developed by the Computer and Network Services of Técnico Lisboa due to usability concerns with the traditional captcha tool. We wanted to provide a more fluid and quick interaction to the user, while maintaining the validation pattern that a web form requires. This plugin was inspired in similar approaches found in the web.

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

### 0.5
 - Initial release.

## License

This plugin is available under the [GPLv3 license](https://www.gnu.org/copyleft/gpl.html).
