<?php
/**
 * @package TeamCTG
 * The parent theme functions are at /buddyboss-theme/inc/theme/functions.php
 */

/****************************** THEME SETUP ******************************/


define ('TEAMCTG_THEME_VERSION', '1.5.3');
define ('THEME_HOOK_PREFIX', 'cb');

require_once 'editor-permissions.php';

function do_the_translations() {

	load_theme_textdomain( 'buddyboss-theme', get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'do_the_translations' );


function confettify_the_theme() {

	wp_enqueue_style( 
		'cb-fonts',
		'https://use.typekit.net/tnv7tsi.css', 
		TEAMCTG_THEME_VERSION 
	);

	wp_enqueue_style( 
		'cb-hub-styles',
		get_stylesheet_directory_uri().
		'/assets/css/cb-hub.css', 
		TEAMCTG_THEME_VERSION 
	);

	wp_enqueue_script( 
		'cb-js', 
		get_stylesheet_directory_uri().
		'/assets/js/cb-hub.js', 
		'jquery,customize-preview', 
		'null',
		'all'
	);

}


function confettify_the_login () {
	
	wp_enqueue_style( 
		'cb-fonts',
		'https://use.typekit.net/tnv7tsi.css', 
		TEAMCTG_THEME_VERSION 
	);
	
	wp_enqueue_style( 
		'teamctg-login', 
		get_stylesheet_directory_uri().
		'/assets/css/login-type.css',
		TEAMCTG_THEME_VERSION, 
		'all'
	);
	
}


add_action( 'login_enqueue_scripts', 'confettify_the_login', 15 );
add_action( 'wp_enqueue_scripts', 'confettify_the_theme', 999 );
//add_action('wp_head', 'get_the_fonts');

function is_this_dustin() {
	$current_person = get_current_user_id();
	if ( $current_person === 1 ) {
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



