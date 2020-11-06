<?php
/**
 * UnderMode Hooks
 * 
 * @package undermode
 */
/*-------------------------------------------------------------------------------------*/
/**
 * Init UnderMode
 *
 * @uses add_filter
 */
function undermode_init() {
	if (undermode_is_active() && !is_user_logged_in()) {
		add_filter('status_header', 'undermode_change_status', 10, 4);
		add_filter('wp_headers', 'undermode_headers');
		add_filter('template_include', 'undermode_template');
	}
}

/*-------------------------------------------------------------------------------------*/
/**
 * Check in UnderMode is Active
 * 
 * @see undermode_init
 */
function undermode_is_active(){
	$options = get_option( 'undermode_option' );
	$active = 'off';

	if( array_key_exists( 'undermode_active', $options ) ) {
		$active  = $options['undermode_active'];
	}

	if( $active == 'on' ) { return true; }
	else { return false; }
}

/*-------------------------------------------------------------------------------------*/
/**
 * Changes the status header to 503.
 *
 * @uses get_status_header_desc
 * @return string The status header
 */
function undermode_change_status( $header, $status_code, $text, $proto ){
	$text = get_status_header_desc(503);
	return "{$proto} 503 {$text}";
}

/*-------------------------------------------------------------------------------------*/
/**
 * Hooked into `wp_headers`.  Adds the `Retry-After` header
 *
 * @return array The array of HTTP headers
 */
function undermode_headers( $headers ){
	$headers['Retry-After'] = 3600;
	return $headers;
}

/*-------------------------------------------------------------------------------------*/
/**
 * Hooked into `template_include`, returns a new template for all the pages
 *
 * @return string The full path to the template file
 */
function undermode_template( $t ) {
	return UM_PLUGIN_PATH . 'views/maintenance.php';
}

/*-------------------------------------------------------------------------------------*/
/**
 * Redirect after Login
 * 
 * @uses login_redirect
 */
function undermode_login_redirect() {
	if ( undermode_is_active() ) {
		return get_site_url( get_current_blog_id() );
	}
}
add_filter('login_redirect', 'undermode_login_redirect');

/*-------------------------------------------------------------------------------------*/
/**
 * Redirect after Logout
 * 
 * @uses wp_logout
 * @see  wp_logout_url()
 */
function undermode_logout_redirect() {
	if ( undermode_is_active() ) {
	    $redirect = get_site_url( get_current_blog_id() );

	    wp_redirect( $redirect );
    	exit();
    }
}
add_action( 'wp_logout', 'undermode_logout_redirect');

/*-------------------------------------------------------------------------------------*/
/* Login Failed Redirect */
function undermode_login_failed() {
	if ( undermode_is_active() ) {
	    $is_login_page = $GLOBALS['pagenow'] == 'wp-login.php' ? true : false;
	    $login_page_x  = "?login=failed";
	    if ( $is_login_page ) $login_page_x = "?login=required";

	    $login_page = get_site_url( get_current_blog_id() );
	    wp_redirect($login_page . $login_page_x);
	    exit;
	}
}
add_action('wp_login_failed', 'undermode_login_failed');

/*-------------------------------------------------------------------------------------*/
/* Login Empty Redirect */
function undermode_verify_user_pass($user, $username, $password) {
	if ( undermode_is_active() ) {
		$is_login_page = $GLOBALS['pagenow'] == 'wp-login.php' ? true : false;
		$login_page = get_site_url( get_current_blog_id() );
		$login_page_x  = "?login=empty";
		if ( $is_login_page ) $login_page_x = "?login=required";

		if( $username == "" || $password == "" ) {
			wp_redirect( $login_page . $login_page_x );
			exit;
		}
	}
}
add_filter('authenticate', 'undermode_verify_user_pass', 1, 3);

/*-------------------------------------------------------------------------------------*/
/**
 * Add Google Analytics Tracking Code
 * 
 * @uses wp_head
 */
function undermode_google_analytics_code(){
	$options = get_option( 'undermode_option' );
	if ( isset($options["undermode_ga_code"]) ) {
		$ga_code = $options["undermode_ga_code"];
	}

	if( undermode_is_active() && $ga_code ) {
		echo $ga_code;
	}
}
add_action( 'wp_head', 'undermode_google_analytics_code' );

/*-------------------------------------------------------------------------------------*/
/* UnderMode Custom Styles */
function undermode_custom_styles(){
	$options       = get_option('undermode_option');
	if ( isset($options["undermode_page_bg_img"]) ) {
		$bg_img         = $options["undermode_page_bg_img"];
		$bg_img         = wp_get_attachment_image_src( $bg_img, 'full' );
	}
	if ( isset($options["undermode_page_bg_color"]) ) {
		$main_bg_color  = $options["undermode_page_bg_color"];
	}
	if ( isset($options["undermode_page_content_color"]) ) {
		$txt_color      = $options["undermode_page_content_color"];
	}
	if ( isset($options["undermode_form_text_color"]) ) {
		$form_txt_color = $options["undermode_form_text_color"];
	}
	if ( isset($options["undermode_page_title_color"]) ) {
		$title_color    = $options["undermode_page_title_color"];
	}
	if ( isset($options["undermode_page_elements_color"]) ) {
		$bg_color       = $options["undermode_page_elements_color"];
	}

	if ( undermode_is_active() ) {
		$style  = '<style id="undermode-custom-style" type="text/css">';
		if ( $bg_img ) $style .= '#um-masthead { background: url('.$bg_img[0].') no-repeat center center; background-size: cover; } ';

		if ( $main_bg_color ) $style .= '
			#um-masthead:after,
			#um-login .um-login-form input[type=text],
			#um-login .um-login-form input[type=email],
			#um-login .um-login-form input[type=password] {
				background-color: '.$main_bg_color.';
				border-color: '.$main_bg_color.';
			}

			#um-login .um-login-form input[type=submit],
			#um-login .um-login-form input[type=submit]:hover,
			#um-login .um-login-form input[type=submit]:focus { color: '.$main_bg_color.' }

			#um-login .um-login-form input[type=text]:-webkit-autofill,
			#um-login .um-login-form input[type=email]:-webkit-autofill,
			#um-login .um-login-form input[type=password]:-webkit-autofill {
				-webkit-box-shadow: 0 0 0px 1000px '.$main_bg_color.' inset !important;
			}';
		
		if ( $txt_color ) $style .= '
			#page-content { color: '.$txt_color.'!important; } ';

		if ( $form_txt_color ) $style .= '
			#um-login .um-login-form .login-content > p { color: '.$form_txt_color.'!important; } ';
		
		if ( $title_color ) $style .= '
			body.page-undermode a:hover,
			body.page-undermode a:focus,
			#um-login .um-login-form .login-content h2,
			#um-login .um-login-form input[type=text],
			#um-login .um-login-form input[type=email],
			#um-login .um-login-form input[type=password],
			.um-site-content #page-content h1,
			.um-site-content #page-content h2,
			.um-site-content #page-content h3,
			.um-site-content #page-content h4,
			.um-site-content #page-content h5,
			.um-site-content #page-content h6,
			.um-site-content ul.site-socials li a,
			.um-site-content ul.site-socials li a:visited,
			.um-autentication-link #um-login-link,
			#um-login .um-login-form a.lost-password { color: '.$title_color.'!important; }

			#um-login .um-login-form input[type=submit],
			#um-login .um-login-form input[type=submit]:hover,
			#um-login .um-login-form input[type=submit]:focus {
				background-color: '.$title_color.';
				border-color: '.$title_color.';
			}
			#um-login .um-login-form input[type=text]:-webkit-autofill,
			#um-login .um-login-form input[type=email]:-webkit-autofill,
			#um-login .um-login-form input[type=password]:-webkit-autofill {
				-webkit-text-fill-color: '.$title_color.'!important;
			}';

		if ( $bg_color ) $style .= '
			#um-login,
			#um-colophon { background-color: '.$bg_color.'!important; } ';
		$style .= '</style>';

		echo $style;
	}
}
add_action('wp_head', 'undermode_custom_styles');

/*-------------------------------------------------------------------------------------*/
/**
 * Add Custom CSS Code
 * 
 * @uses wp_head
 */
function undermode_custom_css_code(){
	$options = get_option( 'undermode_option' );
	if ( isset($options["undermode_page_custom_css"]) ) {
		$css = $options["undermode_page_custom_css"];
	}

	if( undermode_is_active() && $css ) {
		echo '<style type="text/css" id="undermode-custom-css">';
			echo $css;
		echo '</style>';
	}
}
add_action( 'wp_head', 'undermode_custom_css_code' );
?>