<?php
/**
 * @package TeamCTG
 * The parent theme functions are located at /buddyboss-theme/inc/theme/functions.php
 * Add your own functions at the bottom of this file.
 */


/****************************** THEME SETUP ******************************/


define ('TEAMCTG_THEME_VERSION', '1.5.1');

require_once 'editor-permissions.php';

/**
 * Sets up theme for translation
 *
 * @since TeamCTG 1.0.0
 */
function do_the_translations() {
  /**
   * Makes child theme available for translation.
   * Translations can be added into the /languages/ directory.
   */

  // Translate text from the PARENT theme.
  load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

}

add_action( 'after_setup_theme', 'do_the_translations' );

/**
 * Enqueues scripts and styles for child theme front-end.
 */


function confettify_the_theme() {
	
  /**
   * Scripts and Styles loaded by the parent theme can be unloaded if needed
   * using wp_deregister_script or wp_deregister_style.
   *
   * See the WordPress Codex for more information about those functions:
   * http://codex.wordpress.org/Function_Reference/wp_deregister_script
   * http://codex.wordpress.org/Function_Reference/wp_deregister_style
   **/

	wp_deregister_style( 'teamctg-css');
	wp_register_style( 'teamctg-css',
		get_stylesheet_directory_uri().'/assets/css/custom.css',
		array(),
		TEAMCTG_THEME_VERSION );
	
  // Styles
	wp_enqueue_style( 'teamctg-css', get_stylesheet_directory_uri().'/assets/css/custom.css', TEAMCTG_THEME_VERSION );

  // Javascript
  wp_enqueue_script( 'teamctg-js', get_stylesheet_directory_uri().'/assets/js/custom.js', 'jquery,customize-preview,videojs', 'null','all' );
}

function get_the_fonts() { ?>
	
<link rel="stylesheet" href="https://use.typekit.net/tnv7tsi.css">

<?php };

function confettify_the_login () {
	?><link rel="stylesheet" href="https://use.typekit.net/tnv7tsi.css"><?php
	wp_enqueue_style( 'teamctg-login', get_stylesheet_directory_uri().'/assets/css/login-type.css',TEAMCTG_THEME_VERSION, 'all');
}



add_action( 'login_enqueue_scripts', 'confettify_the_login', 15 );
add_action( 'wp_enqueue_scripts', 'confettify_the_theme', 999 );
add_action('wp_head', 'get_the_fonts');

function is_this_dustin() {
	$current_person = get_current_user_id();
	if ( $current_person === 5 ) {
		return true;
	} else {
		return false;
	}
}

function is_this_admins() {
	$current_person = get_current_user_id();
	if ( $current_person === 76 || $current_person === 4 ) {
		return true;
	} else {
		return false;
	}
}

function is_this_admin() {
	$current_person = get_current_user_id();
	if ( in_array( $current_person, array(97, 9, 6, 3, 4, 28) )  ) {
		
		return true;
		
	}
}


// Function to change email address
function tctg_sender_email( $original_email_address ) {
    return 'tctgdustin@ctgserver.teamctg.com';
}
 
// Function to change sender name
function tctg_sender_name( $original_email_from ) {
    return 'TeamCTG';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'tctg_sender_email' );
add_filter( 'wp_mail_from_name', 'tctg_sender_name' );