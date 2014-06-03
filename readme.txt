=== Slider CAPTCHA ===
Contributors: vaurdan, jpargana, playoutpt
Donate link: https://dsi.tecnico.ulisboa.pt
Tags: slider, captcha, ui, comment, comments, responsive, spam, antispam, anti-spam, jquery, jquery-ui, plugin, registration, login, form, password reset, security, secure
Requires at least: 3.5
Tested up to: 3.9.1
Stable tag: 1.4.1
License: GPLv3
License URI: https://www.gnu.org/copyleft/gpl.html

Slider CAPTCHA is a WordPress plugin that will allow you to replace or add a CAPTCHA field to any WordPress form. 

== Description ==

Using Slider CAPTCHA, you can replace or add a CAPTCHA to your WordPress forms. By default, Slider CAPTCHA will add a CAPTCHA to your templates' comment form. You can also add sliders to the Registration form, Password Recovery form and the Login form.

Besides, you can use the `slider_captcha()` function to insert a Slider CAPTCHA wherever you want, and fully costumize it.

With our brand new Settings page, you can now fully custumize every Slider on your WordPress installation and live preview the result. In the upcoming version, you will be able to create your own slider. At the moment, if you want to create your own custom slider you should use the `slider_captcha()`. Check the FAQ for more info.

**Current possible Slider CAPTCHA locations:**

* Comments page
* Login page
* Registration page
* Lost Password page
* Custom localization
* Contact Form 7
* MailPress

== Installation ==

1. Install Slider CAPTCHA either via the WordPress.org plugin directory, or by uploading the files to your server (`/wp-content/plugins/`) 
2. Activation can be made in 'Plugins' menu
3. Configure and enable the sliders you want to have on your website.
4. Have fun.

**Did you know...** If you can't see any CAPTCHA on your Comment's page, you must edit comments.<?php of your template and add the following code in the position that you want to have your CAPTCHA.
`<?php if(function_exists('slider_captcha'))
	slider_captcha('comments');
?>`

== Frequently Asked Questions ==

= I've activated the plugin, but I can't see any CAPTCHA... What can I do? =

That's probabily because of the way your theme is built. You will have to edit your comments.php of your template and add the following code in the position that you want to have your CAPTCHA.
`<?php if(function_exists('slider_captcha'))
	slider_captcha('comments');
?>`

Be sure that your theme is calling `wp_head()` and `wp_footer()` functions.

= What if I want to add another Slider? Can I costumize it? =
Yes, at the moment you have four places where you can place automatically your Slider CAPTCHA. On the other hand, you can use it in Contact Form 7 and wherever you want with Custom Slider options.

* The comment form, enabled by default;
* The user registration form;
* The lost password form;
* The user login form;
* Wherever you want, just use export code into any template or in content editor.

You can costumize each of this sliders, or use the General Settings to have your settings all across your sliders.

= How do I change the appearence of the comment form Slider Captcha? =
If you want to change the appearance of your default CAPTCHA, you can play with the settings panel.

= I can't see Sliders on the Login/Registration/Password Lost page... What is the problem? =
If you are not seeing the sliders, probabily they are disabled on the settings page. If you still can't see any slider after the activation, please submit a support thread so we can help you.

= Oh dear, I've updated from 0.5 and my custom sliders are with a weird look/behave. What should I do? =
One of the changes from the 0.5 to the 1.0 was the `slider_captcha()` function. We added an new argument and the function signature is now `slider_captcha($slider_name = 'general', $container = 'p', $settings = null)`. Because of that, you may have to add a new argument on the first position, with the name of your slider.

Also, the name of the `$params keys also have changed. Please verify if your `$params` array is updated.

== Screenshots ==

1. The default slider on the WordPress Twenty Fourteen theme.

2. Settings panel 

3. The live preview

4. Export options

== Changelog ==

= 1.4.1 =
* Fixed bug with JS minified version not being enqueued

= 1.4 =
* Server side validation enhanced
* Resolved a conflict with css Foundation
* Fixed bugs

= 1.3.3 =
* Fixed error with MailPress

= 1.3.2 =
* Bug fixes with Unexpected end of file

= 1.3 =
* Added MailPress support
* Added Buddypress registration form support
* Fixed bugs

= 1.2 =
* New feature that allows to add a slider in a template by php or JavaScript code or through shortcode in content editor
* Bug fixed for more than one form in Contact Form 7 
* WordPress 3.9.1 compatibility checked

= 1.1.1 =
* Fixed Contact Form bug when plugin not installed.

= 1.1 =
* Contact Form 7 support added
* Abstract class for other plugins support in the future created.
* Bug fixes

= 1.0.1 =
* Bug fixed with saves and settings override

= 1.0 =
* Code refactorization
* Multiple sliders on the same page are now possible
* Settings page included with live preview
* Updated jQuery Slider Captcha to the latest version with new properties names
* Added three extra sliders (register form; login form; lost password form.)
* Bug fixes

= 0.5.4 =
* Fixed bug with wrong settings on Comment Form captcha.

= 0.5.2 =
* Added `containerClass` setting to allow a custom class name to the container
* Fixed bug with Entypo on Windows deviced
* Added new version of jQuery UI Slider Captcha

= 0.5.1 =
* jQuery Slider Captcha version updated with bugfix in HTML5 form validations

= 0.5 =
* Initial release.

== Upgrade Notice ==

= Update now! Version 1.3 released =   
Now with MailPress support!