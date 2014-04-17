<?php
var_dump(slider_get_slider_options('general'));
slider_update_slider("comments" , array('width'=>"100px", 'face'=>array('entypoStart'=>'user')));
var_dump(slider_get_slider_options('comments'));

?>
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
	<?foreach($this->captcha_locations as $machine=>$location):
		$slider = slider_get_slider_options($machine)
		?>
		<fieldset id="<?=$machine?>_options_container">
			<fieldset class="general_settings_container">
				<?php if ( $i ) : ?>
				<h3><?=sprintf( __( '%s %s activation', 'slider-captcha'), $location, __('Slider Captcha', 'slider-captcha') ); ?></h3>
				<p>
					<label for="<?=$machine?>_slider_enable" class="label-radio">
						<input value="1" type="radio" name="slider_enable_[<?=$machine?>]" id="<?=$machine?>_slider_enable" checked="checked"> <span><?php _e( 'Enabled' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_slider_disable" class="label-radio">
						<input value="0" type="radio" name="slider_enable_[<?=$machine?>]" id="<?=$machine?>_slider_disable"> <span><?php _e( 'Disabled' ,'slider_captcha'); ?></span>
					</label>
				</p>
				<?php else: $i = 1; endif; ?>

				<h3><?php _e( 'Type', 'slider-captcha' ); ?></h3>
				<p>
					<label for="<?=$machine?>_admin_slider_type_normal" class="label-radio">
						<input value="normal" type="radio" name="slider_type_normal[<?=$machine?>]" id="<?=$machine?>_slider_type_normal" value="sidebar" <?=($slider['type']=='normal'|| !isset($slider['type'])) ? 'checked="checked"' : ''?>> <span><?php _e( 'Normal' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_admin_slider_type_filled" class="label-radio">
						<input value="filled" type="radio" name="slider_type_filled[<?=$machine?>]" id="<?=$machine?>_slider_type_filled" value="sidebar" <?=checked($slider['type'],'filled')?> <span><?php _e( 'Filled' ,'slider_captcha'); ?></span>
					</label>
				</p>
				<h4><?php _e( 'Animation type', 'slider-captcha' ); ?></h4>
				<p>
					<label for="<?=$machine?>_slider_animation_type_swipe" class="label-radio">
						<input value="swipe" type="radio" name="slider_animation_type_[<?=$machine?>]" id="<?=$machine?>_slider_animation_type_swipe" checked="checked"> <span><?php _e( 'Swipe' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_slider_animation_type_overlap" class="label-radio">
						<input value="overlap" type="radio" name="slider_animation_type_[<?=$machine?>]" id="<?=$machine?>_slider_animation_type_overlap"> <span><?php _e( 'Overlap' ,'slider_captcha'); ?></span>
					</label>
					<label for="<?=$machine?>_slider_animation_type_overlap_swipe" class="label-radio">
						<input value="swipe_overlap" type="radio" name="slider_animation_type_[<?=$machine?>]" id="<?=$machine?>_slider_animation_type_overlap_swipe"> <span><?php _e( 'Swipe & overlap' ,'slider_captcha'); ?></span>
					</label>
				</p>				
				<h3><?php _e( 'Dimensions', 'slider-captcha' ); ?></h3>
				<p>
					<label for="<?=$machine?>_slider_width"><?php _e( 'Width', 'slider-captcha') ?></label> &times; <label for="<?=$machine?>_slider_height"><?php _e( 'height:', 'slider-captcha') ?></label>
					<input value="<?=$slider['width']?>" class="number_input" type="text" name="slider_width[<?=$machine?>][<?=$machine?>]" id="<?=$machine?>_slider_width" value="" placeholder="<?php _e( '100%', 'slider-captcha') ?>">
					<span class="units"><?php _e( 'px (or %)', 'slider-captcha') ?></span>
					&times;
					<input value="<?=$slider['height']?>" class="number_input" type="number" name="slider_height[<?=$machine?>][<?=$machine?>]" id="<?=$machine?>_slider_height" value="" placeholder="<?php _e( '46', 'slider-captcha') ?>">
					<span class="units"><?php _e( 'px', 'slider-captcha') ?></span>
				</p>
				<h3><?php _e( 'Hint text', 'slider-captcha' ); ?></h3>
				<p class="hint_text">
					<label for="<?=$machine?>_hint_text_before_unlock"><?php _e( 'Before unlock', 'slider-captcha' ); ?></label>
					<input value="<?=$slider['hintText']?>" type="text" name="hint_text_before_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_before_unlock" value="" placeholder="<?php _e( 'Swipe to Unlock', 'slider-captcha') ?>">
				</p>
				<p class="hint_text">
					<label for="<?=$machine?>_hint_text_after_unlock"><?php _e( 'and after unlock', 'slider-captcha') ?></label>
					<input value="<?=$slider['textAfterUnlock']?>" type="text" name="hint_text_after_unlock[<?=$machine?>]" id="<?=$machine?>_hint_text_after_unlock" value="" placeholder="<?php _e( 'Unlocked', 'slider-captcha') ?>">
				</p>
			</fieldset>
			<fieldset class="slider_styles_container">
				<h3><?php _e( 'Styles', 'slider-captcha' ); ?></h3>
				<fieldset>
					<h4><?php _e( 'Before unlock', 'slider-captcha' ); ?></h4>
					<p>
						<label for="<?=$machine?>_knob_icon_face_before_unlock"><?php _e( 'Icon face', 'slider-captcha' ); ?></label>
						<select name="knob_icon_face_before_unlock[<?=$machine?>]" id="<?=$machine?>_knob_icon_face_before_unlock">
							<?php _slider_draw_fontface_options('entypoStart',$slider) ?>
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
							<?php _slider_draw_fontface_options('entypoStart',$slider) ?>
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
					</p>
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

	slider_captcha( 'general', $container = 'p', $settings );

?>
