<?php
/*----------------------------------------------------------------------------------------------------------*/
/* Add Plugin Settings Page to Admin Menu */
/*----------------------------------------------------------------------------------------------------------*/
function undermode_add_option_page() {
	 add_menu_page( 'UnderMode Settings', 'UnderMode', 'manage_options', __FILE__, 'undermode_options_page', 'dashicons-lock', 90 );

	// Call register settings function
	add_action( 'admin_init', 'undermode_option_init' );
}

/*----------------------------------------------------------------------------------------------------------*/
/* Define default option settings */
function undermode_add_default_settings() {
	$tmp = get_option('undermode_option');
	if( $tmp['undermode_preserve'] !== 'on' || !is_array($tmp) ) {
		$arr = array(
			'undermode_page_title' => 'Site Under Maintenance',
			'undermode_preserve'   => 'on'
		);
		update_option('undermode_option', $arr);
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/* Remove plugin option settings */
function undermode_remove_default_settings() {
	$tmp = get_option('undermode_option');
	if( $tmp['undermode_preserve'] !== 'on' || !is_array($tmp) ) {
		delete_option('undermode_option');
	}
}

/*----------------------------------------------------------------------------------------------------------*/
/**
 * Register Settings
 * Add the settings section and settings fields
 */
function undermode_option_init(){
	register_setting('undermode_option', 'undermode_option', 'undermode_option_validate' );
	add_settings_section('main_section', 'Main Settings', 'section_main_html', __FILE__);
	add_settings_section('style_section', 'Style Settings', 'section_style_html', __FILE__);
	add_settings_section('contact_section', 'Contact', 'section_contact_html', __FILE__);
	add_settings_section('social_section', 'Social Links', 'section_social_html', __FILE__);
	add_settings_section('adv_section', 'Advanced Settings', 'section_adv_html', __FILE__);

	// MAIN
	add_settings_field('undermode_active', 'Activate UnderMode?', 'setting_undermode_active', __FILE__, 'main_section', array( 'Check to activate Undermode'));
	add_settings_field('undermode_page_title', 'Page Title', 'setting_undermode_page_title', __FILE__, 'main_section');
	add_settings_field('undermode_page_logo', 'Logo', 'setting_undermode_page_logo', __FILE__, 'main_section');
	add_settings_field('undermode_page_txt', 'Page Content', 'setting_undermode_page_txt', __FILE__, 'main_section');
	// add_settings_field('undermode_news_form', 'Newsletter Form', 'setting_undermode_news_form', __FILE__, 'main_section');
	// STYLE
	add_settings_field('undermode_page_bg_img', 'Background Image', 'setting_undermode_page_bg_img', __FILE__, 'style_section');
	add_settings_field('undermode_page_bg_color', 'Main Background Color', 'setting_undermode_page_bg_color', __FILE__, 'style_section');
	add_settings_field('undermode_page_content_color', 'Content Color', 'setting_undermode_page_content_color', __FILE__, 'style_section');
	add_settings_field('undermode_page_title_color', 'Title and Links Color', 'setting_undermode_page_title_color', __FILE__, 'style_section');
	add_settings_field('undermode_page_elements_color', 'Footer and Login Form Background Color', 'setting_undermode_page_elements_color', __FILE__, 'style_section');
	add_settings_field('undermode_form_text_color', 'Login Form Text Color', 'setting_undermode_form_text_color', __FILE__, 'style_section');
	add_settings_field('undermode_page_custom_css', 'Custom CSS', 'setting_undermode_page_custom_css', __FILE__, 'style_section');
	// CONTACT
	add_settings_field('undermode_address', 'Address', 'setting_undermode_address', __FILE__, 'contact_section');
	add_settings_field('undermode_phone', 'Phone', 'setting_undermode_phone', __FILE__, 'contact_section');
	add_settings_field('undermode_mobile', 'Mobile Phone', 'setting_undermode_mobile', __FILE__, 'contact_section');
	add_settings_field('undermode_fax', 'Fax', 'setting_undermode_fax', __FILE__, 'contact_section');
	add_settings_field('undermode_skype', 'Skype', 'setting_undermode_skype', __FILE__, 'contact_section');
	add_settings_field('undermode_email', 'E-mail', 'setting_undermode_email', __FILE__, 'contact_section');
	add_settings_field('undermode_hours', 'Hours', 'setting_undermode_hours', __FILE__, 'contact_section');
	// SOCIAL
	add_settings_field('undermode_fb', 'Facebook', 'setting_undermode_fb', __FILE__, 'social_section');
	add_settings_field('undermode_gram', 'Instagram', 'setting_undermode_gram', __FILE__, 'social_section');
	add_settings_field('undermode_tw', 'Twitter', 'setting_undermode_tw', __FILE__, 'social_section');
	add_settings_field('undermode_linkedin', 'Linkedin', 'setting_undermode_in', __FILE__, 'social_section');
	add_settings_field('undermode_yt', 'YouTube', 'setting_undermode_yt', __FILE__, 'social_section');
	// ADV
	add_settings_field('undermode_ga_code', 'Google Analytics Code', 'setting_undermode_ga_code', __FILE__, 'adv_section');
	add_settings_field('undermode_preserve', 'Preserve settings on plugin deactivation?', 'setting_undermode_preserve', __FILE__, 'adv_section');
}


/*----------------------------------------------------------------------------------------------------------*/
/**
 * Callback functions
 * Display settings fields
 */
/*----------------------------------------------------------------------------------------------------------*/
// Section MAIN HTML displayed before the first option
function  section_main_html() {
	echo '<p>'.__('Set UnderMode Page title, logo and content', 'undermode').'</p>';
}

/*----------------------------------------------------------------------------------------------------------*/
// Section STYLE HTML displayed before the first option
function  section_style_html() {
	echo '<p>'.__('Set UnderMode Page colors and background', 'undermode').'</p>';
}

/*----------------------------------------------------------------------------------------------------------*/
// Section CONTACT HTML displayed before the first option
function  section_contact_html() {
	echo '<p>'.__('Set your contacts', 'undermode').'</p>';
}

/*----------------------------------------------------------------------------------------------------------*/
// Section SOCIAL HTML displayed before the first option
function  section_social_html() {
	echo '<p>'.__('Set your social profile links', 'undermode').'</p>';
}

/*----------------------------------------------------------------------------------------------------------*/
// Section ADV HTML displayed before the first option
function  section_adv_html() {
	echo '<p>'.__('Include Google Analytics tracking code and choose if preserve settings', 'undermode').'</p>';
}

/*----------------------------------------------------------------------------------------------------------*/
// ACTIVATE
function setting_undermode_active($args) {
	$options = get_option('undermode_option');
	$active = 'off';
	if(array_key_exists('undermode_active', $options)) {
		$active  = $options['undermode_active'];
	}
	if($active == 'on') { $checked = ' checked="checked" '; }
	else { $checked = ''; }
	echo "<input ".$checked." id='undermode_active' name='undermode_option[undermode_active]' type='checkbox' />";
	echo "<label for='undermode_active'><small>" . $args[0] . "</small></label>";
}

/*----------------------------------------------------------------------------------------------------------*/
// TITLE
function setting_undermode_page_title() {
	$options = get_option('undermode_option');
	$title   = isset( $options['undermode_page_title'] ) ? $options['undermode_page_title'] : '';
	echo "<input id='undermode_page_title' name='undermode_option[undermode_page_title]' size='40' type='text' value='{$title}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// LOGO 
function setting_undermode_page_logo() {
	// Set variables
	$options = get_option('undermode_option');
	$logo    = isset( $options['undermode_page_logo'] ) ? $options['undermode_page_logo'] : '';

	if ( !empty( $options['undermode_page_logo'] ) ) {
		$image_attributes = wp_get_attachment_image_src( $options['undermode_page_logo'], 'thumb' );
		$src   = $image_attributes[0];
		$value = $options['undermode_page_logo'];
	} else {
		$src = 'http://via.placeholder.com/100x100';
	}

	echo '<div class="upload">
			<img src="' . $src . '" width="100" height="100" style="width: 100px; height: auto;" />
            <div>
                <input type="hidden" id="undermode_page_logo" name="undermode_option[undermode_page_logo]" value="' . $logo . '" />
                <button type="submit" class="upload_image_button button">' . __( 'Upload' ) . '</button>
                <button type="submit" class="remove_image_button button">&times;</button>
            </div>
        </div>';
}

/*----------------------------------------------------------------------------------------------------------*/
// CONTENT
function setting_undermode_page_txt() {
	$options  = get_option('undermode_option');
	$text     = isset( $options['undermode_page_txt'] ) ? $options['undermode_page_txt'] : '';
	$settings = array(
		'wpautop' => true,
		'media_buttons' => false,
		'textarea_name' => 'undermode_option[undermode_page_txt]',
		'textarea_rows' => 8,
		'tabindex' => '',
		'tabfocus_elements' => ':prev,:next', 
		'editor_css' => '', 
		'editor_class' => '',
		'teeny' => false,
		'dfw' => false,
		'tinymce' => true,
		'quicktags' => true
	);
	wp_editor( $text, "undermode_page_txt", $settings );
}

/*----------------------------------------------------------------------------------------------------------*/
// FORM
// function setting_undermode_news_form() {
// 	$options = get_option('undermode_option');
// 	echo "<input id='undermode_news_form' name='undermode_option[undermode_news_form]' size='40' type='text' placeholder='[contact-form-7]' value='{$options['undermode_news_form']}' />";
// }

/*----------------------------------------------------------------------------------------------------------*/
/// STYLES
// BG IMAGE
function setting_undermode_page_bg_img() {
	// Set variables
	$options = get_option('undermode_option');

	if ( !empty( $options['undermode_page_bg_img'] ) ) {
		$image_attributes = wp_get_attachment_image_src( $options['undermode_page_bg_img'], 'full' );
		$src   = $image_attributes[0];
		$value = isset( $options['undermode_page_bg_img'] ) ? $options['undermode_page_bg_img'] : '';
	}  else {
		$value = '';
		$src   = 'http://via.placeholder.com/300x150';
	}

	echo '<div class="upload">
			<img src="' . $src . '" width="300" height="150" style="width: 300px; height: auto;" />
            <div>
                <input type="hidden" id="undermode_page_bg_img" name="undermode_option[undermode_page_bg_img]" value="' . $value . '" />
                <button type="submit" class="upload_image_button button">' . __( 'Upload' ) . '</button>
                <button type="submit" class="remove_image_button button">&times;</button>
            </div>
        </div>';
}

/*----------------------------------------------------------------------------------------------------------*/
// BG COLOR
function setting_undermode_page_bg_color() {
	$options  = get_option('undermode_option');
	$bg_color = isset( $options['undermode_page_bg_color'] ) ? $options['undermode_page_bg_color'] : '';
	echo "<input id='undermode_page_bg_color' class='color-picker' data-alpha='true' name='undermode_option[undermode_page_bg_color]' size='40' type='text' value='{$bg_color}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// CONTENT COLOR
function setting_undermode_page_content_color() {
	$options       = get_option('undermode_option');
	$content_color = isset( $options['undermode_page_content_color'] ) ? $options['undermode_page_content_color'] : '';
	echo "<input id='undermode_page_content_color' class='color-picker' name='undermode_option[undermode_page_content_color]' size='40' type='text' value='{$content_color}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// TITLE & LINKS COLOR
function setting_undermode_page_title_color() {
	$options     = get_option('undermode_option');
	$title_color = isset( $options['undermode_page_title_color'] ) ? $options['undermode_page_title_color'] : '';
	echo "<input id='undermode_page_title_color' class='color-picker' name='undermode_option[undermode_page_title_color]' size='40' type='text' value='{$title_color}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// ELEMENTS BACKGROUND COLOR
function setting_undermode_page_elements_color() {
	$options    = get_option('undermode_option');
	$elem_color = isset( $options['undermode_page_elements_color'] ) ? $options['undermode_page_elements_color'] : '';
	echo "<input id='undermode_page_elements_color' class='color-picker' data-alpha='true' name='undermode_option[undermode_page_elements_color]' size='40' type='text' value='{$elem_color}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// FORM TEXT COLOR
function setting_undermode_form_text_color() {
	$options = get_option('undermode_option');
	$txt_color = isset( $options['undermode_form_text_color'] ) ? $options['undermode_form_text_color'] : '';
	echo "<input id='undermode_form_text_color' class='color-picker' data-alpha='true' name='undermode_option[undermode_form_text_color]' size='40' type='text' value='{$txt_color}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// CUSTOM CSS
function setting_undermode_page_custom_css() {
	$options = get_option('undermode_option');
	$css     = isset( $options['undermode_page_custom_css'] ) ? $options['undermode_page_custom_css'] : '';
	echo "<textarea id='undermode_page_custom_css' name='undermode_option[undermode_page_custom_css]' rows='7' cols='50' type='textarea'>{$css}</textarea>";
}

/*----------------------------------------------------------------------------------------------------------*/
/// CONTACTS
/*----------------------------------------------------------------------------------------------------------*/
// ADDRESS
function setting_undermode_address() {
	$options = get_option('undermode_option');
	$address = isset( $options['undermode_address'] ) ? $options['undermode_address'] : '';
	$settings = array(
		'wpautop' => true,
		'media_buttons' => false,
		'textarea_name' => 'undermode_option[undermode_address]',
		'textarea_rows' => 8,
		'tabindex' => '',
		'tabfocus_elements' => ':prev,:next', 
		'editor_css' => '', 
		'editor_class' => '',
		'editor_height' => '100',
		'teeny' => true,
		'dfw' => false,
		'tinymce' => true,
		'quicktags' => true
	);
	wp_editor( $address, "undermode_address", $settings );
}

/*----------------------------------------------------------------------------------------------------------*/
// PHONE
function setting_undermode_phone() {
	$options = get_option('undermode_option');
	$phone   = isset( $options['undermode_phone'] ) ? $options['undermode_phone'] : '';
	echo "<input id='undermode_phone' name='undermode_option[undermode_phone]' size='40' type='text' value='{$phone}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// MOBILE PHONE
function setting_undermode_mobile() {
	$options = get_option('undermode_option');
	$mobile  = isset( $options['undermode_mobile'] ) ? $options['undermode_mobile'] : '';
	echo "<input id='undermode_mobile' name='undermode_option[undermode_mobile]' size='40' type='text' value='{$mobile}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// FAX
function setting_undermode_fax() {
	$options = get_option('undermode_option');
	$fax     = isset( $options['undermode_fax'] ) ? $options['undermode_fax'] : '';
	echo "<input id='undermode_fax' name='undermode_option[undermode_fax]' size='40' type='text' value='{$fax}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// SKYPE
function setting_undermode_skype() {
	$options = get_option('undermode_option');
	$skype   = isset( $options['undermode_skype'] ) ? $options['undermode_skype'] : '';
	echo "<input id='undermode_skype' name='undermode_option[undermode_skype]' size='40' type='text' value='{$skype}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// EMAIL
function setting_undermode_email() {
	$options = get_option('undermode_option');
	$email   = isset( $options['undermode_email'] ) ? $options['undermode_email'] : '';
	echo "<input id='undermode_email' name='undermode_option[undermode_email]' size='40' type='email' value='{$email}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// HOURS
function setting_undermode_hours() {
	$options  = get_option('undermode_option');
	$hours    = isset( $options['undermode_hours'] ) ? $options['undermode_hours'] : '';
	$settings = array(
		'wpautop' => true,
		'media_buttons' => false,
		'textarea_name' => 'undermode_option[undermode_hours]',
		'textarea_rows' => 8,
		'tabindex' => '',
		'tabfocus_elements' => ':prev,:next', 
		'editor_css' => '', 
		'editor_class' => '',
		'editor_height' => '100',
		'teeny' => true,
		'dfw' => false,
		'tinymce' => true,
		'quicktags' => true
	);
	wp_editor( $hours, "undermode_hours", $settings );
}

/*----------------------------------------------------------------------------------------------------------*/
/// SOCIALS
// FB
function setting_undermode_fb() {
	$options = get_option('undermode_option');
	$fb      = isset( $options['undermode_fb'] ) ? $options['undermode_fb'] : '';
	echo "<input id='undermode_fb' name='undermode_option[undermode_fb]' size='40' type='url' value='{$fb}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// INSTAGRAM
function setting_undermode_gram() {
	$options = get_option('undermode_option');
	$gram    = isset( $options['undermode_gram'] ) ? $options['undermode_gram'] : '';
	echo "<input id='undermode_gram' name='undermode_option[undermode_gram]' size='40' type='url' value='{$gram}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// TW
function setting_undermode_tw() {
	$options = get_option('undermode_option');
	$tw      = isset( $options['undermode_tw'] ) ? $options['undermode_tw'] : '';
	echo "<input id='undermode_tw' name='undermode_option[undermode_tw]' size='40' type='url' value='{$tw}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// IN
function setting_undermode_in() {
	$options = get_option('undermode_option');
	$in      = isset( $options['undermode_linkedin'] ) ? $options['undermode_linkedin'] : '';
	echo "<input id='undermode_linkedin' name='undermode_option[undermode_linkedin]' size='40' type='url' value='{$in}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// YT
function setting_undermode_yt() {
	$options = get_option('undermode_option');
	$yt      = isset( $options['undermode_yt'] ) ? $options['undermode_yt'] : '';
	echo "<input id='undermode_yt' name='undermode_option[undermode_yt]' size='40' type='url' value='{$yt}' />";
}

/*----------------------------------------------------------------------------------------------------------*/
// GA CODE
function setting_undermode_ga_code() {
	$options = get_option('undermode_option');
	$ga_code = isset( $options['undermode_ga_code'] ) ? $options['undermode_ga_code'] : '';
	echo "<textarea id='undermode_ga_code' name='undermode_option[undermode_ga_code]' rows='7' cols='50' type='textarea'>{$ga_code}</textarea>";
}

/*----------------------------------------------------------------------------------------------------------*/
// PRESERVE
function setting_undermode_preserve() {
	$options  = get_option('undermode_option');
	$preserve = isset($options['undermode_preserve']) ? $options['undermode_preserve'] : '';
	if( $preserve ) { $checked = ' checked="checked" '; }
	else { $checked = ''; }
	echo "<input ".$checked." id='undermode_preserve' name='undermode_option[undermode_preserve]' type='checkbox' />";
}


/*----------------------------------------------------------------------------------------------------------*/
/* Validate user data for some/all of your input fields */
/*----------------------------------------------------------------------------------------------------------*/
function undermode_option_validate($input) {
	$input['undermode_page_title'] =  wp_filter_nohtml_kses($input['undermode_page_title']);

	return $input;
}


/*----------------------------------------------------------------------------------------------------------*/
/* Display the admin options page */
/*----------------------------------------------------------------------------------------------------------*/
function undermode_options_page() {
?>
	<div class="wrap undermode">
		<h1><span style="font-size: 28px; margin-right: 10px;" class="dashicons dashicons-lock"></span>UnderMode Settings</h1>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php if ( function_exists('wp_nonce_field') ) wp_nonce_field('undermode-action_' . "yep"); ?>
			<?php
				settings_fields('undermode_option');
				do_settings_sections(__FILE__);
			?>
			<p class="submit"><input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
		</form>
	</div>
<?php
}

/*----------------------------------------------------------------------------------------------------------*/
/* Display custom Admin Notice */
function undermode_print_admin_notice() {
	$active = undermode_is_active();

	if( $active ) {
?>
		<div class="notice notice-error">
			<p><?php _e('<strong>UnderMode</strong> is activated! Your site is not visible to logged out users, remember to disable it when you are ready.'); ?></p>
		</div>	
<?php
	}
}
add_action('admin_notices', 'undermode_print_admin_notice');
?>