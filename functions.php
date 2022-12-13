<?php
/**
 * @package TeamCTG
 * The parent theme functions are at /buddyboss-theme/inc/theme/functions.php
 */

/****************************** THEME SETUP ******************************/


define ('TEAMCTG_THEME_VERSION', '2.3.0');
//define ('THEME_HOOK_PREFIX', 'cb');

//require_once 'editor-permissions.php';

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
		'cb-type',
		get_stylesheet_directory_uri().
		'/assets/css/cb-type.css',
		TEAMCTG_THEME_VERSION
	);

	wp_enqueue_style(
		'cb-hub-styles',
		get_stylesheet_directory_uri().
		'/assets/css/cb-hub.css',
		TEAMCTG_THEME_VERSION
	);

	wp_enqueue_style(
		'cb-form-styles',
		get_stylesheet_directory_uri().
		'/assets/css/cb-forms.css',
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

	if ( cb_is_user_confetti_bits() && cb_is_user_site_admin() ) {
		wp_enqueue_style(
			'cb-hub-admin-styles',
			get_stylesheet_directory_uri().
			'/assets/css/cb-hub-admin.css',
			TEAMCTG_THEME_VERSION
		);
		wp_enqueue_script(
			'cb-hub-admin-js',
			get_stylesheet_directory_uri().
			'/assets/js/cb-hub-admin.js',
			'jquery'
		);
	}
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
if ( is_page('confetti-bits' ) ) {
	add_action( THEME_HOOK_PREFIX . '_template_parts_content_top', 'cb_has_moved_notification' );
}


//add_action( 'login_enqueue_scripts', 'confettify_the_login', 15 );
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

function tctg_sender_email( $original_email_address ) {
	return 'dustin@mail.teamctg.com';
}
function tctg_sender_name( $original_email_from ) {
	return 'TeamCTG';
}
add_filter( 'wp_mail_from', 'tctg_sender_email' );
add_filter( 'wp_mail_from_name', 'tctg_sender_name' );

add_action( 'phpmailer_init', 'tctg_smtp_init' );
function tctg_smtp_init( $phpmailer ) {
	$phpmailer->Host		= SMTP_HOST;
	$phpmailer->Port		= SMTP_PORT;
	$phpmailer->Username	= SMTP_USER;
	$phpmailer->Password	= SMTP_PASS;
	$phpmailer->From		= SMTP_FROM;
	$phpmailer->FromName	= SMTP_NAME;
	$phpmailer->SMTPAuth	= true;
	$phpmailer->SMTPSecure = SMTP_SECURE;

	$phpmailer->IsSMTP();

}

function cb_has_moved_notification() {


	if (is_page('confetti-bits')) {
		$link = bp_loggedin_user_domain() . cb_get_transactions_slug();
?><div class="cb-module" ><h3 style="text-align:center;font-family:bree-serif;">
	The Confetti Bits Hub has <a style="text-decoration:underline;" href="<?php echo $link; ?>">moved to the profile page.</a>
	</h3>

</div>
<style>.entry-title {display:none;}</style>

<?php
	}

}

/*//*/

add_filter( 'buddyboss_theme_redux_is_theme', '__return_true', 999 );

/**
 * Get path from template directory to current file.
 *
 *
 * @param string $file_path Current file path
 *
 * @uses get_template() Get active template directory name.
 *
 * @return string
 */

function buddyboss_theme_dir_to_current_file_path( $file_path ) {
	// Format current file path with only right slash.
	$file_path = trailingslashit( $file_path );
	$file_path = str_replace( '\\', '/', $file_path );
	$file_path = str_replace( '//', '/', $file_path );
	$chunks    = explode( '/', $file_path );
	if ( ! is_array( $chunks ) ) {
		$chunks = array();
	}
	// Reverse array for child to parent or current file to template directory.
	$chunks   = array_reverse( $chunks );
	$template = get_template();
	$tmp_file = array();
	foreach ( $chunks as $path ) {
		if ( empty( $path ) ) {
			continue;
		}
		if ( $path == $template ) {
			break;
		}
		// Set all directory name from current file to template directory.
		$tmp_file[] = $path;
	}
	// Reverse array for parent to child or template directory to file directory.
	$tmp_file = array_reverse( $tmp_file );
	$tmp_file = implode( '/', $tmp_file );
	return $tmp_file;
}

/**
 * Filter Redux URL
 *
 * @param string $url Redux url.
 *
 * @uses buddyboss_theme_dir_to_current_file_path() Get relative path.
 *
 * @return string
 */
function buddyboss_theme_redux_url( $url ) {
	/**
     * When some parts of current file path and template directory path are match from the beginning.
     *
     * Example
     * current_path = /bitnami/wordpress/wp-content/
     * tmpdir_path  = /bitnami/wordpress/wp-content/themes/buddyboss-theme/inc/admin/framework/ReduxCore/
     */
	if ( strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( get_template_directory() ) ) !== false ) {
		return $url;
	} else if ( strpos( Redux_Helpers::cleanFilePath( __FILE__ ), Redux_Helpers::cleanFilePath( get_stylesheet_directory() ) ) !== false ) {
		return $url;
	}
	/**
     * When some parts of current file path and template directory path are not match from the beginning.
     *
     * Example
     * current_path = /opt/bitnami/wordpress/wp-content/
     * tmpdir_path  = /bitnami/wordpress/wp-content/themes/buddyboss-theme/inc/admin/framework/ReduxCore/
     */
	// Get template url.
	$tem_dir  = trailingslashit( get_template_directory_uri() );
	// Get template to current file directory path.
	$file_dir = buddyboss_theme_dir_to_current_file_path( $url );
	// Set url for ReduxCore directory
	$redux_url = trailingslashit( $tem_dir . $file_dir );
	// Check valid url
	if ( filter_var ( $redux_url, FILTER_VALIDATE_URL ) ) {
		return $redux_url;
	}
	return $url;
}
add_filter( 'redux/_url', 'buddyboss_theme_redux_url' );

add_filter( 'style_loader_src', 'bb_fix_theme_option_for_custom_wp_installation' );
add_filter( 'script_loader_src', 'bb_fix_theme_option_for_custom_wp_installation' );
function bb_fix_theme_option_for_custom_wp_installation( $url ) {
  if ( is_admin() ) {
    $url = str_replace( 'plugins/bitnami/wordpress/wp-content/themes/buddyboss-theme/', 'themes/buddyboss-theme/', $url );
  }
  return $url;
}