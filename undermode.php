<?php
/*
 * Plugin Name: UnderMode
 * Plugin URI:  https://nofrills.agency
 * Description: Displays a Coming Soon (Underconstruction / Maintenance) Page
 * Version:     2.0.0
 * Author:      SuPerGiu @ COM&C // NoFrills Agency
 * Author URI:  https://nofrills.agency
 * Text Domain: undermode
 * License:     GPL2
 *
 * @package undermode
 * @license GPL2+
*/
define('UM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('UM_PLUGIN_URL', plugin_dir_url(__FILE__));

/*----------------------------------------------------------------------------------------------------------*/
/* Require Dependecies */
/*----------------------------------------------------------------------------------------------------------*/
require_once UM_PLUGIN_PATH . '/inc/settings.php';
require_once UM_PLUGIN_PATH . '/inc/template-tags.php';
require_once UM_PLUGIN_PATH . '/inc/hooks.php';

/*----------------------------------------------------------------------------------------------------------*/
/* Hooks / Filters */
/*----------------------------------------------------------------------------------------------------------*/
add_action('init', 'undermode_init');
add_action('admin_menu', 'undermode_add_option_page');
register_activation_hook(__FILE__, 'undermode_add_default_settings');
register_deactivation_hook(__FILE__, 'undermode_remove_default_settings');

/*----------------------------------------------------------------------------------------------------------*/
/**
 * Load scripts and style for settings page
 */
/*----------------------------------------------------------------------------------------------------------*/
function undermode_load_scripts_admin() {
	// WordPress library
	wp_enqueue_media();
	// Color Picker
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker-alpha', UM_PLUGIN_URL . 'assets/js/vendor/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '2.1.2', true );
	// Media Upload Button JS
	wp_enqueue_script( 'undermode-media-button', UM_PLUGIN_URL . 'assets/js/mediaButton.js', array(), '', true );
	// Admin CSS
	wp_enqueue_style( 'undermode-admin-style', UM_PLUGIN_URL . 'assets/css/admin.css', array(), '' );
}
add_action( 'admin_enqueue_scripts', 'undermode_load_scripts_admin' );

/*----------------------------------------------------------------------------------------------------------*/
/**
 * Load scripts and style for maintenance tpl
 */
/*----------------------------------------------------------------------------------------------------------*/
function undermode_load_scripts() {
	if ( undermode_is_active() && !is_user_logged_in() ) {
		///* Styles
		// FontAwesome
		wp_enqueue_style( 'font-awesome', UM_PLUGIN_URL .'assets/css/vendor/font-awesome.min.css' );
		// IcoMoon
		wp_enqueue_style( 'icomoon', UM_PLUGIN_URL .'assets/css/vendor/icomoon.min.css' );
		// Main Style
		wp_enqueue_style( 'undermode-style', UM_PLUGIN_URL . 'assets/css/style.css' );

		///* Scripts
		// Main Script
		wp_enqueue_script( 'undermode-scripts', UM_PLUGIN_URL . 'assets/js/app.js', array('jquery'), '', true );
	}
}
add_action( 'wp_enqueue_scripts', 'undermode_load_scripts', 0 );

/*-----------------------------------------------------------------------------------------------*/
/**
 * Add Async Attribute to JS Scripts
 * 
 * @uses script_loader_tag
 */
/*-----------------------------------------------------------------------------------------------*/
function undermode_add_async_attribute($tag, $handle) {
   $scripts_to_async = array( 'undermode-scripts' );
   
   foreach($scripts_to_async as $async_script) {
      if ($async_script === $handle) {
         return str_replace(' src', ' async="async" src', $tag);
      }
   }
   return $tag;
}
add_filter('script_loader_tag', 'undermode_add_async_attribute', 10, 2);
?>