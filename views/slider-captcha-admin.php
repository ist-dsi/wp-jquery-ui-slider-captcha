<fieldset>
	<h3><?php _e( 'Select the option to configure form' ,'slider-captcha') ?></h3>
	<p><?php _e( 'Slider activation should take place in individual form option. Individual slider settings will overide general options for each form.', 'slider-captcha' ); ?></p>
   	<select id="slider_captcha_form_selector">
		<?foreach($this->captcha_locations as $machine=>$location):?>
			<option value="<?=$machine?>"><?=$location?></option>
		<?endforeach?>
	</select>
</fieldset>
<fieldset id="form_options_container">
	<?foreach($this->captcha_locations as $machine=>$location):?>
		<fieldset id="<?=$machine?>_options_container">
			<fieldset class="general_settings_container">
				<h3><?php _e( 'Type', 'slider-captcha' ); ?></h3>
				<p>
					<label for="<?=$machine?>_admin_slider_type_normal" class="label-radio">
						<input type="radio" name="slider_type_normal[<?=$machine?>]" id="<?=$machine?>_slider_type_normal" value="sidebar" checked="checked"> <span><?php _e( 'Normal' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_admin_slider_type_filled" class="label-radio">
						<input type="radio" name="slider_type_filled[<?=$machine?>]" id="<?=$machine?>_slider_type_filled" value="sidebar"> <span><?php _e( 'Filled' ,'slider_captcha'); ?></span>
					</label>
				</p>			
				<h3><?php _e( 'Dimensions', 'slider-captcha' ); ?></h3>
				<p>
					<label for="<?=$machine?>_slider_width"><?php _e( 'Width', 'slider-captcha') ?></label> &times; <label for="<?=$machine?>_slider_height"><?php _e( 'height:', 'slider-captcha') ?></label>
					<input class="number_input" type="text" name="slider_width[<?=$machine?>][<?=$machine?>]" id="<?=$machine?>_slider_width" value="" placeholder="<?php _e( '100%', 'slider-captcha') ?>">
					<span class="units"><?php _e( 'px (or %)', 'slider-captcha') ?></span>
					&times;
					<input class="number_input" type="number" name="slider_height[<?=$machine?>][<?=$machine?>]" id="<?=$machine?>_slider_height" value="" placeholder="<?php _e( '46', 'slider-captcha') ?>">
					<span class="units"><?php _e( 'px', 'slider-captcha') ?></span>
				</p>
				<h3><?php _e( 'Hint text', 'slider-captcha' ); ?></h3>
				<p class="hint_text">
					<label for="<?=$machine?>_hint_text_before_unlock"><?php _e( 'Before unlock', 'slider-captcha' ); ?></label>
					<input type="text" name="hint_text_before_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_before_unlock" value="" placeholder="<?php _e( 'Swipe to Unlock', 'slider-captcha') ?>">
				</p>
				<p class="hint_text">
					<label for="<?=$machine?>_hint_text_after_unlock"><?php _e( 'and after unlock', 'slider-captcha') ?></label>
					<input type="text" name="hint_text_after_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_after_unlock" value="" placeholder="<?php _e( 'Unlocked', 'slider-captcha') ?>">
				</p>
			</fieldset>
			<fieldset class="slider_styles_container">
				<h3><?php _e( 'Styles', 'slider-captcha' ); ?></h3>
				<fieldset>
					<h4><?php _e( 'Before unlock', 'slider-captcha' ); ?></h4>
					<p>
						<label for="<?=$machine?>_knob_icon_face_before_unlock"><?php _e( 'Icon face', 'slider-captcha' ); ?></label>
						<select name="knob_icon_face_before_unlock[<?=$machine?>]" id="<?=$machine?>_knob_icon_face_before_unlock">
							<?php _slider_draw_fontface_options() ?>
						</select>
					</p>
					<p>
						<label for="<?=$machine?>_knob_color_before_unlock"><?php _e( 'Knob color', 'slider-captcha' ); ?></label>
						<input class="color_input" type="text" name="knob_color_before_unlock[<?=$machine?>]" id="<?=$machine?>_knob_color_before_unlock" value="" placeholder="">
						<span class="units"><?php _e( '(hex)', 'slider-captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_knob_text_color_before_unlock"><?php _e( 'Text color', 'slider-captcha' ); ?></label>
						<input type="text" class="color_input" name="knob_text_color_before_unlock[<?=$machine?>]" id="<?=$machine?>_knob_text_color_before_unlock" value="" placeholder="">
						<span class="units"><?php _e( '(hex)', 'slider-captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_knob_top_offset_before_unlock"><?php _e( 'Offset ( top &times; right)', 'slider-captcha' ); ?></label>
						<input type="number" class="number_input" name="knob_top_offset_before_unlock[<?=$machine?>]" id="<?=$machine?>_knob_top_offset_before_unlock" value="" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider-captcha' ); ?></span>
						&times;
						<input type="number" class="number_input" name="knob_right_offset_before_unlock[<?=$machine?>]" value="" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider-captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_hint_text_size_before_unlock"><?php _e( 'Hint text size', 'slider-captcha' ); ?></label>
						<input type="number" class="number_input" name="hint_text_size_before_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_size_before_unlock" value="" placeholder="">
						<span class="units"><?php _e( 'px', 'slider-captcha' ); ?></span>
					<p>
						<label for="<?=$machine?>_hint_text_color_before_unlock"><?php _e( 'Hint text color', 'slider-captcha' ); ?></label>
						<input type="text" class="color_input" name="hint_text_color_before_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_color_before_unlock" value="" placeholder="">
						<span class="units"><?php _e( '(hex)', 'slider-captcha' ); ?></span>
					</p>
				</fieldset>
				<fieldset>
					<h4><?php _e( 'After unlock', 'slider-captcha' ); ?></h4>
					<p>
						<label for="<?=$machine?>_knob_icon_face_after_unlock"><?php _e( 'Icon face', 'slider-captcha' ); ?></label>
						<select name="knob_icon_face_after_unlock[<?=$machine?>]" id="<?=$machine?>_knob_icon_face_after_unlock">
							<?php _slider_draw_fontface_options() ?>
						</select>
					</p>
					<p>
						<label for="<?=$machine?>_knob_color_after_unlock"><?php _e( 'Knob color', 'slider-captcha' ); ?></label>
						<input class="color_input" type="text" name="knob_color_after_unlock[<?=$machine?>]" id="<?=$machine?>_knob_color_after_unlock" value="" placeholder="">
						<span class="units"><?php _e( '(hex)', 'slider-captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_knob_text_color_after_unlock"><?php _e( 'Text color', 'slider-captcha' ); ?></label>
						<input type="text" class="color_input" name="knob_text_color_after_unlock[<?=$machine?>]" id="<?=$machine?>_knob_text_color_after_unlock" value="" placeholder="">
						<span class="units"><?php _e( '(hex)', 'slider-captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_knob_top_offset_after_unlock"><?php _e( 'Offset ( top &times; right)', 'slider-captcha' ); ?></label>
						<input type="number" class="number_input" name="knob_top_offset_after_unlock[<?=$machine?>]" id="<?=$machine?>_knob_top_offset_after_unlock" value="" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider-captcha' ); ?></span>
						&times;
						<input type="number" class="number_input" name="knob_right_offset_after_unlock[<?=$machine?>]" value="" placeholder="0">
						<span class="units"><?php _e( 'px', 'slider-captcha' ); ?></span>
					</p>
					<p>
						<label for="<?=$machine?>_hint_text_size_after_unlock"><?php _e( 'Hint text size', 'slider-captcha' ); ?></label>
						<input type="number" class="number_input" name="hint_text_size_after_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_size_after_unlock" value="" placeholder="">
						<span class="units"><?php _e( 'px', 'slider-captcha' ); ?></span>
					<p>
						<label for="<?=$machine?>_hint_text_color_after_unlock"><?php _e( 'Hint text color', 'slider-captcha' ); ?></label>
						<input type="text" class="color_input" name="hint_text_color_after_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_color_after_unlock" value="" placeholder="">
						<span class="units"><?php _e( '(hex)', 'slider-captcha' ); ?></span>
					</p>
				</fieldset>
			</fieldset>
		</fieldset>
	<?endforeach?>
</fieldset>

<fieldset id="live_preview_container">
	<h3><?php _e( 'Live preview', 'slider-captcha' ); ?></h3>
	<p><?php _e( 'This preview could differ of the theme, because css backoffice and theme are differents.', 'slider-captcha' ); ?></p>
	<p id="general_slider"></p>
	<p><a href="#"><?php _e( 'Test slider again', 'slider-captcha'); ?></a></p>
</fieldset>
<?php 
	global $_wp_admin_css_colors;
	$colors = $_wp_admin_css_colors[ get_user_option( 'admin_color', get_current_user_id() ) ]->colors;

	$settings = array(
		'hintText' => 'Swipe to save changes',
		'textAfterUnlock' => 'Saving changes',
		'hintTextSize' => '13px',
		'styles' => array(
			'width' => '300px',
			'height' => '38px',
			'disabledKnobColor' => $colors[0],
			'knobColor' => $colors[1],
			'backgroundColor' => $colors[2],
			'textColor' => '#fff',
			'unlockTextColor' => '#fff'
		),
		'events' => array( 'submitAfterUnlock' => '1')
	);

	slider_captcha($container = 'p', $settings );

?>
