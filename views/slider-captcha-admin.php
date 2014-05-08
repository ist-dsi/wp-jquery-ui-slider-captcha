<?php
if(isset($_POST['submited'])):
/**************************************
 *        SAVING ALL THE SETTINGS     *
 **************************************/
foreach($_POST as $machine => $post) {
	//If its not a valid slider, just skip it
	if(!is_array($post) || !isset($post['hint_text_before_unlock']))
		continue;
	$new_array = array();
	//First, save the enable settings
	if(isset($post['slider_enable']))
		$new_array['enabled'] = (bool)$post['slider_enable'];
	//Now save the type
	$new_array['type'] = $post['slider_type'];
	if( isset( $post['slider_animation_type'] ) )
		$new_array['textFeedbackAnimation'] = $post['slider_animation_type'];

	//Save the dimensions
	$new_array['width'] = $post['slider_width'];
	$new_array['height'] = $post['slider_height'];

	//Save the texts
	if($post['hint_text_before_unlock'] != '' || $machine!= 'general')
		$new_array['hintText'] = $post['hint_text_before_unlock'];
	else if ($machine == 'general' && $post['hint_text_before_unlock']=='')
		$this->remove_general_setting('hintText');

	if($post['hint_text_after_unlock'] != '' || $machine!= 'general')
		$new_array['hintTextAfterUnlock'] = $post['hint_text_after_unlock'];
	else if ($machine == 'general' && $post['hint_text_after_unlock']=='')
		$this->remove_general_setting('hintTextAfterUnlock');


	//Save the general styles
	if($post['slider_background_color'] != '' || $machine!= 'general')
		$new_array['styles']['backgroundColor'] = $post['slider_background_color'];
	else if ($machine == 'general' && $post['slider_background_color']=='')
		$this->remove_general_setting('styles','backgroundColor');

	$new_array['hintTextSize'] = $post['hint_text_size_unlock'];

	//Save before unlock styles
	if($post['knob_icon_face_before_unlock'] != '' || $machine!= 'general')
		$new_array['face']['icon'] = $post['knob_icon_face_before_unlock'];
	else if ($machine == 'general' && $post['knob_icon_face_before_unlock']=='')
		$this->remove_general_setting('face','icon');

	if($post['knob_color_before_unlock'] != '' || $machine!= 'general')
		$new_array['styles']['knobColor'] = $post['knob_color_before_unlock'];
	else if ($machine == 'general' && $post['knob_color_before_unlock']=='')
		$this->remove_general_setting('styles','knobColor');
	
	if($post['knob_text_color_before_unlock'] != '' || $machine!= 'general')
		$new_array['face']['textColor'] = $post['knob_text_color_before_unlock'];
	else if ($machine == 'general' && $post['knob_text_color_before_unlock']=='')
		$this->remove_general_setting('face','textColor');

	if($post['knob_text_size_before_unlock'] != '' || $machine!= 'general')
		$new_array['face']['textSize'] = $post['knob_text_size_before_unlock'];
	else if ($machine == 'general' && $post['knob_text_size_before_unlock']=='')
		$this->remove_general_setting('face','textSize');
	if($post['knob_top_offset_before_unlock'] != '' || $machine!= 'general')
		$new_array['face']['top'] = $post['knob_top_offset_before_unlock'];
	else if ($machine == 'general' && $post['knob_top_offset_before_unlock']=='')
		$this->remove_general_setting('face','top');
	if($post['knob_right_offset_before_unlock'] != '' || $machine!= 'general')
		$new_array['face']['right'] = $post['knob_right_offset_before_unlock'];
	else if ($machine == 'general' && $post['knob_right_offset_before_unlock']=='')
		$this->remove_general_setting('face','right');
	if($post['hint_text_color_before_unlock'] != '' || $machine!= 'general')
		$new_array['styles']['textColor'] = $post['hint_text_color_before_unlock'];
	else if ($machine == 'general' && $post['hint_text_color_before_unlock']=='')
		$this->remove_general_setting('styles','textColor');

	//Save after unlock styles
	if($post['knob_icon_face_after_unlock'] != '' || $machine!= 'general')
		$new_array['face']['iconAfterUnlock'] = $post['knob_icon_face_after_unlock'];
	else if ($machine == 'general' && $post['knob_icon_face_after_unlock']=='')
		$this->remove_general_setting('face','iconAfterUnlock');

	if($post['knob_color_after_unlock'] != '' || $machine!= 'general')
		$new_array['styles']['knobColorAfterUnlock'] = $post['knob_color_after_unlock'];
	else if ($machine == 'general' && $post['knob_color_after_unlock']=='')
		$this->remove_general_setting('styles','knobColorAfterUnlock');

	if($post['knob_text_color_after_unlock'] != '' || $machine!= 'general')
		$new_array['face']['textColorAfterUnlock'] = $post['knob_text_color_after_unlock'];
	else if ($machine == 'general' && $post['knob_text_color_after_unlock']=='')
		$this->remove_general_setting('face','textColorAfterUnlock');

	if($post['knob_text_size_after_unlock'] != '' || $machine!= 'general')
		$new_array['face']['textSizeAfterUnlock'] = $post['knob_text_size_after_unlock'];
	else if ($machine == 'general' && $post['knob_text_size_after_unlock']=='')
		$this->remove_general_setting('face','textSizeAfterUnlock');

	if($post['knob_top_offset_after_unlock'] != '' || $machine!= 'general')
		$new_array['face']['topAfterUnlock'] = $post['knob_top_offset_after_unlock'];
	else if ($machine == 'general' && $post['knob_top_offset_after_unlock']=='')
		$this->remove_general_setting('face','topAfterUnlock');

	if($post['knob_right_offset_after_unlock'] != '' || $machine!= 'general')
		$new_array['face']['rightAfterUnlock'] = $post['knob_right_offset_after_unlock'];
	else if ($machine == 'general' && $post['knob_right_offset_after_unlock']=='')
		$this->remove_general_setting('face','rightAfterUnlock');

	if($post['hint_text_color_after_unlock'] != '' || $machine!= 'general')
		$new_array['styles']['textColorAfterUnlock'] = $post['hint_text_color_after_unlock'];
	else if ($machine == 'general' && $post['hint_text_color_after_unlock']=='')
		$this->remove_general_setting('styles','textColorAfterUnlock');

	slider_update_slider($machine,$new_array);
}
	echo "<div class='updated below-h2'><p>" . __('All the settings have been successfully saved.','slider_captcha') . "</p></div>";

endif;?>
<fieldset>
	<p><?php _e( 'By default the only place were the slider is applied is in the comments form. If you want to activate the slider for other kinds of forms (registration form, reset password form, login form or others) you need to activate them individually. The general settings apply to all kinds of forms. If you want to customize a slider for a specific kind of form you can do it. You just need to sellect the type of form (under "Slider options") and change the settings.', 'slider_captcha' ); ?></p>

	<h3><?php echo  __( 'Slider options', 'slider_captcha'); ?></h3>
	<?php $curr_slider = (isset($_POST['curr_slider']) ? $_POST['curr_slider'] : 'general' ); ?>
	<select name="curr_slider" id="slider_captcha_form_selector" style="width: 200px;">
		<?php foreach($this->captcha_locations as $machine=>$location):?>
			<option value="<?php echo $machine?>" <?php echo selected($curr_slider,$machine)?> ><?php echo $location?></option>
		<?php endforeach?>
	</select>
</fieldset>
<fieldset id="form_options_container">
	<?php foreach($this->captcha_locations as $machine=>$location):
		$slider_raw = slider_get_raw_slider_options($machine);
		$slider_merged = slider_get_slider_options($machine);
		?>
		<fieldset id="<?php echo $machine?>_options_container"
			<?php if($curr_slider!=$machine):?>
			style="visibility: hidden; position: absolute; height: 0px;"
			<?php endif;?>
			>
			<fieldset class="general_settings_container">
				<?php if ( $i && $machine!='custom') : ?>
				<h3><?php echo sprintf( __( '%s activation', 'slider_captcha'), $location )?></h3>
				<p>
					<label for="<?php echo $machine?>_slider_enable" class="label-radio">
						<input value="1" type="radio" name="<?php echo $machine?>[slider_enable]" id="<?php echo $machine?>_slider_enable" <?php checked($slider_merged['enabled'],1)?>> <span><?php _e( 'Enabled' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?php echo $machine?>_slider_disable" class="label-radio">
						<input value="0" type="radio" name="<?php echo $machine?>[slider_enable]" id="<?php echo $machine?>_slider_disable" <?php echo ($slider_merged['enabled']==0) ? 'checked="checked"' : ''?>> <span><?php _e( 'Disabled' ,'slider_captcha'); ?></span>
					</label>
				</p>
				<?php else: $i = 1; endif; ?>

				<h3><?php _e( 'Type', 'slider_captcha' ); ?></h3>
				<p>
					<label for="<?php echo $machine?>_slider_type_normal" class="label-radio">
						<input value="normal" type="radio" name="<?php echo $machine?>[slider_type]" id="<?php echo $machine?>_slider_type_normal" <?php echo ($slider_raw['type']=='normal' || ($slider_merged['type']=='' && $machine=='general')) ? 'checked="checked"' : ''?>> <span><?php _e( 'Normal' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?php echo $machine?>_slider_type_filled" class="label-radio">
						<input value="filled" type="radio" name="<?php echo $machine?>[slider_type]" id="<?php echo $machine?>_slider_type_filled" <?php checked($slider_merged['type'],'filled')?>> <span><?php _e( 'Filled' ,'slider_captcha'); ?></span>
					</label>
				</p>
				<h4 <?php echo ($slider_merged['type'] != 'filled' ? 'style="display: none;"' : '')?> ><?php _e( 'Animation type', 'slider_captcha' ); ?></h4>
				<p <?php echo ($slider_merged['type'] != 'filled' ? 'style="display: none;"' : '')?>>
					<label for="<?php echo $machine?>_slider_animation_type_overlap" class="label-radio">
						<input value="overlap" type="radio" name="<?php echo $machine?>[slider_animation_type]" id="<?php echo $machine?>_slider_animation_type_overlap" <?php echo ($slider_merged['textFeedbackAnimation']=='overlap' || ($slider_merged['textFeedbackAnimation']=='' || $machine=='general')) ? 'checked="checked"' : ''?>> <span><?php _e( 'Overlap text' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?php echo $machine?>_slider_animation_type_swipe" class="label-radio">
						<input value="swipe" type="radio" name="<?php echo $machine?>[slider_animation_type]" id="<?php echo $machine?>_slider_animation_type_swipe" <?php checked($slider_raw['textFeedbackAnimation'],'swipe')?>> <span><?php _e( 'Swipe text' ,'slider_captcha'); ?></span>
					</label>					
					<label for="<?php echo $machine?>_slider_animation_type_overlap_swipe" class="label-radio">
						<input value="swipe_overlap" type="radio" name="<?php echo $machine?>[slider_animation_type]" id="<?php echo $machine?>_slider_animation_type_overlap_swipe" <?php checked($slider_raw['textFeedbackAnimation'],'swipe_overlap')?>> <span><?php _e( 'Swipe & overlap text' ,'slider_captcha'); ?></span>
					</label>
				</p>				
				<h3><?php _e( 'Dimensions', 'slider_captcha' ); ?></h3>
				<p>
					<label for="<?php echo $machine?>_slider_width"><?php _e( 'Width', 'slider_captcha') ?></label> &times; <label for="<?php echo $machine?>_slider_height"><?php _e( 'height:', 'slider_captcha') ?></label>
					<input value="<?php echo $slider_raw['width']?>" class="number_input" type="text" name="<?php echo $machine?>[slider_width]" id="<?php echo $machine?>_slider_width" placeholder="<?php _e( '100%', 'slider_captcha') ?>">
					<span class="units"><?php _e( 'px (or %)', 'slider_captcha') ?></span>
					&times;
					<input value="<?php echo $slider_raw['height']?>" class="number_input" type="number" name="<?php echo $machine?>[slider_height]" id="<?php echo $machine?>_slider_height" placeholder="<?php _e( '46', 'slider_captcha') ?>">
					<span class="units"><?php _e( 'px', 'slider_captcha') ?></span>
				</p>
				<h3><?php _e( 'Hint text', 'slider_captcha' ); ?></h3>
				<p class="hint_text">
					<label for="<?php echo $machine?>_hint_text_before_unlock"><?php _e( 'Before unlock', 'slider_captcha' ); ?></label>
					<input value="<?php echo $slider_raw['hintText']?>" type="text" name="<?php echo $machine?>[hint_text_before_unlock]" id="<?php echo $machine?>_hint_text_before_unlock" placeholder="<?php _e( 'Swipe to Unlock', 'slider_captcha') ?>">
				</p>
				<p class="hint_text">
					<label for="<?php echo $machine?>_hint_text_after_unlock"><?php _e( 'and after unlock', 'slider_captcha') ?></label>
					<input value="<?php echo $slider_raw['hintTextAfterUnlock']?>" type="text" name="<?php echo $machine?>[hint_text_after_unlock]" id="<?php echo $machine?>_hint_text_after_unlock" placeholder="<?php _e( 'Unlocked', 'slider_captcha') ?>">
				</p>
			</fieldset>
			<fieldset class="slider_styles_container">
				<h3><?php _e( 'Styles', 'slider_captcha' ); ?></h3>
				<fieldset>
					<p>
						<label for="<?php echo $machine?>_slider_background_color"><?php _e( 'Background color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['styles']['backgroundColor']?>" class="color_input" type="text" name="<?php echo $machine?>[slider_background_color]" id="<?php echo $machine?>_slider_background_color" placeholder="">
					</p>
					<p>
						<label for="<?php echo $machine?>_hint_text_size_unlock"><?php _e( 'Hint text size', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['hintTextSize']?>" type="number" class="number_input" name="<?php echo $machine?>[hint_text_size_unlock]" id="<?php echo $machine?>_hint_text_size_unlock" placeholder="16">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>
				</fieldset>
				<fieldset class="column_presentation">
					<h4><?php _e( 'Before unlock', 'slider_captcha' ); ?></h4>
					<p>
						<label for="<?php echo $machine?>_knob_color_before_unlock"><?php _e( 'Knob color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['styles']['knobColor']?>" class="color_input" type="text" name="<?php echo $machine?>[knob_color_before_unlock]" id="<?php echo $machine?>_knob_color_before_unlock" placeholder="">
					</p>					
					<p>
						<label for="<?php echo $machine?>_knob_icon_face_before_unlock"><?php _e( 'Icon', 'slider_captcha' ); ?></label>
						<select name="<?php echo $machine?>[knob_icon_face_before_unlock]" id="<?php echo $machine?>_knob_icon_face_before_unlock" style="width: 180px;">
							<?php _slider_draw_fontface_options('icon',$slider_raw) ?>
						</select>
					</p>
					<p>
						<label for="<?php echo $machine?>_knob_text_color_before_unlock"><?php _e( 'Icon color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['face']['textColor']?>" type="text" class="color_input" name="<?php echo $machine?>[knob_text_color_before_unlock]" id="<?php echo $machine?>_knob_text_color_before_unlock" placeholder="">
					</p>
					<!--<p>
						<label for="<?php echo $machine?>_knob_text_size_before_unlock"><?php _e( 'Knob text size', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['face']['textSize']?>" type="number" class="number_input" name="<?php echo $machine?>[knob_text_size_before_unlock]" id="<?php echo $machine?>_knob_text_size_before_unlock" placeholder="">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>-->
					<p>
						<label for="<?php echo $machine?>_knob_top_offset_before_unlock"><?php _e( 'Icon position ( top &times; right)', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['face']['top']?>" type="number" class="number_input" name="<?php echo $machine?>[knob_top_offset_before_unlock]" id="<?php echo $machine?>_knob_top_offset_before_unlock" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
						&times;
						<input value="<?php echo $slider_raw['face']['right']?>" type="number" class="number_input" name="<?php echo $machine?>[knob_right_offset_before_unlock]" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>
					<p>
						<label for="<?php echo $machine?>_hint_text_color_before_unlock"><?php _e( 'Hint text color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['styles']['textColor']?>" type="text" class="color_input" name="<?php echo $machine?>[hint_text_color_before_unlock]" id="<?php echo $machine?>_hint_text_color_before_unlock" placeholder="">
					</p>
				</fieldset>
				<fieldset class="column_presentation">
					<h4><?php _e( 'After unlock', 'slider_captcha' ); ?></h4>
					<p>
						<label for="<?php echo $machine?>_knob_color_after_unlock"><?php _e( 'Knob color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['styles']['knobColorAfterUnlock']?>" class="color_input" type="text" name="<?php echo $machine?>[knob_color_after_unlock]" id="<?php echo $machine?>_knob_color_after_unlock" placeholder="">
					</p>					
					<p>
						<label for="<?php echo $machine?>_knob_icon_face_after_unlock"><?php _e( 'Icon', 'slider_captcha' ); ?></label>
						<select name="<?php echo $machine?>[knob_icon_face_after_unlock]" id="<?php echo $machine?>_knob_icon_face_after_unlock" style="width: 180px;">
							<?php _slider_draw_fontface_options('iconAfterUnlock',$slider_raw) ?>
						</select>
					</p>
					<p>
						<label for="<?php echo $machine?>_knob_text_color_after_unlock"><?php _e( 'Icon color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['face']['textColorAfterUnlock']?>" type="text" class="color_input" name="<?php echo $machine?>[knob_text_color_after_unlock]" id="<?php echo $machine?>_knob_text_color_after_unlock" placeholder="">
					</p>
					<!--<p>
						<label for="<?php echo $machine?>_knob_text_size_after_unlock"><?php _e( 'Knob text size', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['face']['textSizeAfterUnlock']?>" type="text" class="number_input" name="<?php echo $machine?>[knob_text_size_after_unlock]" id="<?php echo $machine?>_knob_text_size_after_unlock" placeholder="">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>-->
					<p>
						<label for="<?php echo $machine?>_knob_top_offset_after_unlock"><?php _e( 'Icon position ( top &times; right)', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['face']['topAfterUnlock']?>" type="number" class="number_input" name="<?php echo $machine?>[knob_top_offset_after_unlock]" id="<?php echo $machine?>_knob_top_offset_after_unlock" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
						&times;
						<input value="<?php echo $slider_raw['face']['rightAfterUnlock']?>" type="number" class="number_input" name="<?php echo $machine?>[knob_right_offset_after_unlock]" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>
					<p>
						<label for="<?php echo $machine?>_hint_text_color_after_unlock"><?php _e( 'Hint text color', 'slider_captcha' ); ?></label>
						<input value="<?php echo $slider_raw['styles']['textColorAfterUnlock']?>" type="text" class="color_input" name="<?php echo $machine?>[hint_text_color_after_unlock]" id="<?php echo $machine?>_hint_text_color_after_unlock" placeholder="">
					</p>
				</fieldset>
			</fieldset>
		</fieldset>
	<?php endforeach?>
</fieldset>

<fieldset id="live_preview_container">
	<h3><?php _e( 'Live preview', 'slider_captcha' ); ?></h3>
	<p><?php _e( 'This preview may differ from the one published on your website. Since the styles of the theme may override the settings of the plugin you should always check the slider appearance by browsing a page that requires validation.', 'slider_captcha' ); ?></p>
	<p id="general_slider"></p>
	<p><?php _e( 'Do you want to <a href="#">test slider captcha again</a>?', 'slider_captcha'); ?></p>
	<input type="hidden" name="submited" value="1" />
</fieldset>

<fieldset id="custom_export_container">
	<h3><?php _e('Export your Slider','slider_captcha'); ?></h3>
	<p><?php _e( 'Copy the next code of this custom slider, and apply it wherever you want. You have three options: php code, JavaScript code and shortcode (this one can be inserted into content editor, others into templates pages).', 'slider_captcha'); ?></p>
	<p>
		<textarea readonly id="code_generator"></textarea>
		<span><a href="#" title="php code" data-code="php">php code</a></span>
		<span><a href="#" title="JavaScript code" data-code="js">JavaScript code</a></span>
		<span><a href="#" title="shortcode" data-code="sc">shortcode</a></span>
	</p>
</fieldset>

<?php 
	global $_wp_admin_css_colors;
	$colors = $_wp_admin_css_colors[ get_user_option( 'admin_color', get_current_user_id() ) ]->colors;

	$settings = array(
		'type' => 'normal',
		'styles' => array(
			'knobColor' => $colors[1],
			'knobColorAfterUnlock' => $colors[0],
			'backgroundColor' => $colors[2],
			'textColor' => '#fff',
			'textColorAfterUnlock' => '#fff'
		),
		'width' => '300',
		'height' => '38',
		'hintText' => __('Swipe to save changes','slider_captcha'),
		'hintTextAfterUnlock' => __('Saving changes','slider_captcha'),
		'hintTextSize' => '13',
		'face' => array(
            'icon' => '',
            'top' => '',
            'right' => '',
            'textColor' => '',
            'iconAfterUnlock' => '',
            'topAfterUnlock' => '',
            'rightAfterUnlock' => '',
            'textColorAfterUnlock' => '',
		),
		'events' => array( 'submitAfterUnlock' => '1')
	);

	slider_captcha( 'general', $container = 'p', $settings );
?>
