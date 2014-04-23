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
	<p><?php _e( 'Slider activation should take place in individual form option. Individual slider settings will overide general options for each form. By default, comments form slider CAPTCHA is active. All other slider CAPTCHA still disabled until individual activation.', 'slider_captcha' ); ?></p>
	<h3><?= __( 'Slider options', 'slider_captcha'); ?></h3>
	<select name="curr_slider" id="slider_captcha_form_selector" style="width: 200px;">
		<?foreach($this->captcha_locations as $machine=>$location):?>
			<option value="<?=$machine?>" <?=selected($_POST['curr_slider'],$machine)?> ><?=$location?></option>
		<?endforeach?>
	</select>
</fieldset>
<fieldset id="form_options_container">
	<?foreach($this->captcha_locations as $machine=>$location):
		$slider = slider_get_slider_options($machine)
		?>
		<fieldset id="<?=$machine?>_options_container">
			<fieldset class="general_settings_container">
				<?php if ( $i ) : ?>
				<h3><?=sprintf( __( '%s activation', 'slider_captcha'), $location )?></h3>
				<p>
					<label for="<?=$machine?>_slider_enable" class="label-radio">
						<input value="1" type="radio" name="<?=$machine?>[slider_enable]" id="<?=$machine?>_slider_enable" <?checked($slider['enabled'],1)?>> <span><?php _e( 'Enabled' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_slider_disable" class="label-radio">
						<input value="0" type="radio" name="<?=$machine?>[slider_enable]" id="<?=$machine?>_slider_disable" <?=($slider['enabled']=='0') ? 'checked="checked"' : ''?>> <span><?php _e( 'Disabled' ,'slider_captcha'); ?></span>
					</label>
				</p>
				<?php else: $i = 1; endif; ?>

				<h3><?php _e( 'Type', 'slider_captcha' ); ?></h3>
				<p>
					<label for="<?=$machine?>_slider_type_normal" class="label-radio">
						<input value="normal" type="radio" name="<?=$machine?>[slider_type]" id="<?=$machine?>_slider_type_normal" <?=($slider['type']=='normal' || ($slider['type']=='' || $machine=='general')) ? 'checked="checked"' : ''?>> <span><?php _e( 'Normal' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_slider_type_filled" class="label-radio">
						<input value="filled" type="radio" name="<?=$machine?>[slider_type]" id="<?=$machine?>_slider_type_filled" <?checked($slider['type'],'filled')?>> <span><?php _e( 'Filled' ,'slider_captcha'); ?></span>
					</label>
				</p>
				<h4 <?=($slider['type'] != 'filled' ? 'style="display: none;"' : '')?> ><?php _e( 'Animation type', 'slider_captcha' ); ?></h4>
				<p <?=($slider['type'] != 'filled' ? 'style="display: none;"' : '')?>>
					<label for="<?=$machine?>_slider_animation_type_overlap" class="label-radio">
						<input value="overlap" type="radio" name="<?=$machine?>[slider_animation_type]" id="<?=$machine?>_slider_animation_type_overlap" <?=($slider['textFeedbackAnimation']=='overlap' || ($slider['textFeedbackAnimation']=='' || $machine=='general')) ? 'checked="checked"' : ''?>> <span><?php _e( 'Overlap' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_slider_animation_type_swipe" class="label-radio">
						<input value="swipe" type="radio" name="<?=$machine?>[slider_animation_type]" id="<?=$machine?>_slider_animation_type_swipe" <?checked($slider['textFeedbackAnimation'],'swipe')?>> <span><?php _e( 'Swipe' ,'slider_captcha'); ?></span>
					</label>					
					<label for="<?=$machine?>_slider_animation_type_overlap_swipe" class="label-radio">
						<input value="swipe_overlap" type="radio" name="<?=$machine?>[slider_animation_type]" id="<?=$machine?>_slider_animation_type_overlap_swipe" <?checked($slider['textFeedbackAnimation'],'swipe_overlap')?>> <span><?php _e( 'Swipe & overlap' ,'slider_captcha'); ?></span>
					</label>
				</p>				
				<h3><?php _e( 'Dimensions', 'slider_captcha' ); ?></h3>
				<p>
					<label for="<?=$machine?>_slider_width"><?php _e( 'Width', 'slider_captcha') ?></label> &times; <label for="<?=$machine?>_slider_height"><?php _e( 'height:', 'slider_captcha') ?></label>
					<input value="<?=$slider['width']?>" class="number_input" type="text" name="<?=$machine?>[slider_width]" id="<?=$machine?>_slider_width" placeholder="<?php _e( '100%', 'slider_captcha') ?>">
					<span class="units"><?php _e( 'px (or %)', 'slider_captcha') ?></span>
					&times;
					<input value="<?=$slider['height']?>" class="number_input" type="number" name="<?=$machine?>[slider_height]" id="<?=$machine?>_slider_height" placeholder="<?php _e( '46', 'slider_captcha') ?>">
					<span class="units"><?php _e( 'px', 'slider_captcha') ?></span>
				</p>
				<h3><?php _e( 'Hint text', 'slider_captcha' ); ?></h3>
				<p class="hint_text">
					<label for="<?=$machine?>_hint_text_before_unlock"><?php _e( 'Before unlock', 'slider_captcha' ); ?></label>
					<input value="<?=$slider['hintText']?>" type="text" name="<?=$machine?>[hint_text_before_unlock]" id="<?=$machine?>_hint_text_before_unlock" placeholder="<?php _e( 'Swipe to Unlock', 'slider_captcha') ?>">
				</p>
				<p class="hint_text">
					<label for="<?=$machine?>_hint_text_after_unlock"><?php _e( 'and after unlock', 'slider_captcha') ?></label>
					<input value="<?=$slider['hintTextAfterUnlock']?>" type="text" name="<?=$machine?>[hint_text_after_unlock]" id="<?=$machine?>_hint_text_after_unlock" placeholder="<?php _e( 'Unlocked', 'slider_captcha') ?>">
				</p>
			</fieldset>
			<fieldset class="slider_styles_container">
				<h3><?php _e( 'Styles', 'slider_captcha' ); ?></h3>
				<fieldset>
					<p>
						<label for="<?=$machine?>_slider_background_color"><?php _e( 'Background color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['styles']['backgroundColor']?>" class="color_input" type="text" name="<?=$machine?>[slider_background_color]" id="<?=$machine?>_slider_background_color" placeholder="">
					</p>
					<p>
						<label for="<?=$machine?>_hint_text_size_unlock"><?php _e( 'Hint text size', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['hintTextSize']?>" type="number" class="number_input" name="<?=$machine?>[hint_text_size_unlock]" id="<?=$machine?>_hint_text_size_unlock" placeholder="16">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>
				</fieldset>
				<fieldset class="column_presentation">
					<h4><?php _e( 'Before unlock', 'slider_captcha' ); ?></h4>
					<p>
						<label for="<?=$machine?>_knob_icon_face_before_unlock"><?php _e( 'Icon face', 'slider_captcha' ); ?></label>
						<select name="<?=$machine?>[knob_icon_face_before_unlock]" id="<?=$machine?>_knob_icon_face_before_unlock" style="width: 180px;">
							<?php _slider_draw_fontface_options('icon',$slider) ?>
						</select>
					</p>
					<p>
						<label for="<?=$machine?>_knob_color_before_unlock"><?php _e( 'Knob color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['styles']['knobColor']?>" class="color_input" type="text" name="<?=$machine?>[knob_color_before_unlock]" id="<?=$machine?>_knob_color_before_unlock" placeholder="">
					</p>
					<p>
						<label for="<?=$machine?>_knob_text_color_before_unlock"><?php _e( 'Knob text color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['face']['textColor']?>" type="text" class="color_input" name="<?=$machine?>[knob_text_color_before_unlock]" id="<?=$machine?>_knob_text_color_before_unlock" placeholder="">
					</p>
					<!--<p>
						<label for="<?=$machine?>_knob_text_size_before_unlock"><?php _e( 'Knob text size', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['face']['textSize']?>" type="number" class="number_input" name="<?=$machine?>[knob_text_size_before_unlock]" id="<?=$machine?>_knob_text_size_before_unlock" placeholder="">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>-->
					<p>
						<label for="<?=$machine?>_knob_top_offset_before_unlock"><?php _e( 'Offset ( top &times; right)', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['face']['top']?>" type="number" class="number_input" name="<?=$machine?>[knob_top_offset_before_unlock]" id="<?=$machine?>_knob_top_offset_before_unlock" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
						&times;
						<input value="<?=$slider['face']['right']?>" type="number" class="number_input" name="<?=$machine?>[knob_right_offset_before_unlock]" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_hint_text_color_before_unlock"><?php _e( 'Hint text color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['styles']['textColor']?>" type="text" class="color_input" name="<?=$machine?>[hint_text_color_before_unlock]" id="<?=$machine?>_hint_text_color_before_unlock" placeholder="">
					</p>
				</fieldset>
				<fieldset class="column_presentation">
					<h4><?php _e( 'After unlock', 'slider_captcha' ); ?></h4>
					<p>
						<label for="<?=$machine?>_knob_icon_face_after_unlock"><?php _e( 'Icon face', 'slider_captcha' ); ?></label>
						<select name="<?=$machine?>[knob_icon_face_after_unlock]" id="<?=$machine?>_knob_icon_face_after_unlock" style="width: 180px;">
							<?php _slider_draw_fontface_options('iconAfterUnlock',$slider) ?>
						</select>
					</p>
					<p>
						<label for="<?=$machine?>_knob_color_after_unlock"><?php _e( 'Knob color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['styles']['knobColorAfterUnlock']?>" class="color_input" type="text" name="<?=$machine?>[knob_color_after_unlock]" id="<?=$machine?>_knob_color_after_unlock" placeholder="">
					</p>
					<p>
						<label for="<?=$machine?>_knob_text_color_after_unlock"><?php _e( 'Knob text color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['face']['textColorAfterUnlock']?>" type="text" class="color_input" name="<?=$machine?>[knob_text_color_after_unlock]" id="<?=$machine?>_knob_text_color_after_unlock" placeholder="">
					</p>
					<!--<p>
						<label for="<?=$machine?>_knob_text_size_after_unlock"><?php _e( 'Knob text size', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['face']['textSizeAfterUnlock']?>" type="text" class="number_input" name="<?=$machine?>[knob_text_size_after_unlock]" id="<?=$machine?>_knob_text_size_after_unlock" placeholder="">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>-->
					<p>
						<label for="<?=$machine?>_knob_top_offset_after_unlock"><?php _e( 'Offset ( top &times; right)', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['face']['topAfterUnlock']?>" type="number" class="number_input" name="<?=$machine?>[knob_top_offset_after_unlock]" id="<?=$machine?>_knob_top_offset_after_unlock" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
						&times;
						<input value="<?=$slider['face']['rightAfterUnlock']?>" type="number" class="number_input" name="<?=$machine?>[knob_right_offset_after_unlock]" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider_captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_hint_text_color_after_unlock"><?php _e( 'Hint text color', 'slider_captcha' ); ?></label>
						<input value="<?=$slider['styles']['textColorAfterUnlock']?>" type="text" class="color_input" name="<?=$machine?>[hint_text_color_after_unlock]" id="<?=$machine?>_hint_text_color_after_unlock" placeholder="">
					</p>
				</fieldset>
			</fieldset>
		</fieldset>
	<?endforeach?>
</fieldset>

<fieldset id="live_preview_container">
	<h3><?php _e( 'Live preview', 'slider_captcha' ); ?></h3>
	<p><?php _e( 'This preview may differ from the theme, because css backoffice and theme aren\'t the same.', 'slider_captcha' ); ?></p>
	<p id="general_slider"></p>
	<p><?php _e( 'Do you want to <a href="#">test slider captcha again</a>?', 'slider_captcha'); ?></p>
	<input type="hidden" name="submited" value="1" />
</fieldset>
<?php 
	global $_wp_admin_css_colors;
	$colors = $_wp_admin_css_colors[ get_user_option( 'admin_color', get_current_user_id() ) ]->colors;

	$settings = array(
		'hintText' => 'Swipe to save changes',
		'hintTextAfterUnlock' => 'Saving changes',
		'hintTextSize' => '13px',
		'styles' => array(
			'width' => '300px',
			'height' => '38px',
			'knobColorAfterUnlock' => $colors[0],
			'knobColor' => $colors[1],
			'backgroundColor' => $colors[2],
			'textColor' => '#fff',
			'textColorAfterUnlock' => '#fff'
		),
		'events' => array( 'submitAfterUnlock' => '1')
	);

	slider_captcha( 'general', $container = 'p', $settings );
?>
