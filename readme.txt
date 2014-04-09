=== Slider CAPTCHA ===
Contributors: vaurdan, jpargana
Donate link: https://dsi.tecnico.ulisboa.pt
Tags: slider, captcha, comment, spam
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 0.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Slider CAPTCHA is a WordPress plugin that will allow you to replace or add a CAPTCHA field to the comment form.

== Description ==

Using Slider CAPTCHA, you can replace or add a CAPTCHA to your WordPress forms. By default, Slider CAPTCHA will try to add a CAPTCHA to your templates' comment form.

You can also use `slider_captcha()` function to insert a CAPTCHA wherever you want, and fully costumize your CAPTCHA.

At the moment, this plugin is really simple and basic, but in the upcoming versions, a Settings page will be added and you will be able to create your own sliders.

== Installation ==

1. Install Slider CAPTCHA either via the WordPress.org plugin directory, or by uploading the files to your server (`/wp-content/plugins/`) 
2. Activation can be made in 'Plugins' menu
3. Have fun.

**Did you know...** If you can't see any CAPTCHA on your Comment's page, you must edit comments.php of your template and add the following code in the position that you want to have your CAPTCHA.
`<?php if(function_exists('slider_captcha'))
	slider_captcha();
?>`

== Frequently Asked Questions ==

= I've activated the plugin, but I can't see any CAPTCHA... What can I do? =

That's probabily because of the way your theme is built. You will have to edit your comments.php of your template and add the following code in the position that you want to have your CAPTCHA.
`<?php if(function_exists('slider_captcha'))
	slider_captcha();
?>`

= What if I want to add another Slider? Can I costumize it? =
Sure, you can use the `slider_captcha($container, $params)` function to insert a new Slider Captcha.
The `$container` is the container where your CAPTCHA will be placed. By default it is "p".
The `$params` is an array where you can costumize the Slider Captcha, acording to this:
`{
	type: "filled",
	textFeedbackAnimation: 'swipe_overlap',
	hintText: "Swipe to submit",
	hintTextSize: '12px',
	textAfterUnlock: 'You can submit now',
	styles: {
		knobColor: "#5CDF3B",
		disabledKnobColor: "#000000",
		backgroundColor: "#444",
		textColor: "#fff",
		unlockTextColor: "#fff",
		width: '90%',
		height: '35px'
	},
	face: {
		topStart: 4,
		rightStart: 9,
		entypoStart: 'right-thin',
		textColorStart: '#ddd',
		textColorEnd: '#5CDF3B',
		topEnd: 3,
		rightEnd: 9,				
		entypoEnd: 'flag'
	},
	events: {
		afterUnlock: function () {
			console.log("afterUnlock event");
		},
		beforeUnlock: function () {
			console.log("afterSubmit event");
		},
		beforeSubmit: function () {
			console.log("beforeSubmit event");
		},
		submitAfterUnlock: 0,
		validateOnServer: 1,
		validateOnServerParamName: "my_form_param_name"
	}
}`

For instance, if you want to change your hint text and your width, you must send the following array:
`$param = array(
	'hintText' => 'your new hint text',
	'styles' => array(
		'width' => '300px' //this can be a %
	),
);`

To add a class to the container, you can use `'containerClass' => 'nameoftheclass' on your $params array.

= How do I change the appearence of the comment form Slider Captcha? =
If you want to change the appearance of your default CAPTCHA, at the moment you need to, either edit the .css (.scss provided), or to edit the slider_captcha.php's default values.

In the upcoming versions, a Settings panel will be added to allow easy costumization of the CAPTCHA.


== Screenshots ==

1. The default slider on the WordPress Twenty Fourteen theme.

== Changelog ==

= 0.5.2 =
* Added `containerClass` setting to allow a custom class name to the container
* Fixed bug with Entypo on Windows deviced
* Added new version of jQuery UI Slider Captcha

= 0.5.1 =
* jQuery Slider Captcha version updated with bugfix in HTML5 form validations

= 0.5 =
* Initial release.

== Upgrade Notice ==

= 0.5 =
Initial release
