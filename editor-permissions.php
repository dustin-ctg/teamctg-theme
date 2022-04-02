<?php
/* 
 * Let Editors manage users, and run this only once.
 * Version: 1.0.0
 */
function editor_manage_users() {
 
	
    if ( get_option( 'give_editor_caps' ) != 'done' ) {
     
        // let editor manage users

        $user_editor = get_role('editor'); // Get the user role
		$user_editor->add_cap('manage_options');
        $user_editor->add_cap('edit_users');
        $user_editor->add_cap('list_users');
        $user_editor->add_cap('promote_users');
        $user_editor->add_cap('create_users');
        $user_editor->add_cap('add_users');
        $user_editor->add_cap('delete_users');
        $user_editor->add_cap('edit_courses');
		$user_editor->add_cap('edit_groups');
		$user_editor->add_cap('edit_assignments');

        update_option( 'give_editor_caps', 'done' );			

    } 
	
}

add_action( 'init', 'editor_manage_users' );

function get_rid_of_the_menus() {
	if ( is_user_logged_in() ) {
		$this_user = wp_get_current_user();
		if ($this_user->has_cap('manage_options') && (!is_this_dustin())) {
			wp_enqueue_script('hide_the_menus', get_stylesheet_directory_uri() . '/assets/js/hide-it.js', 'jquery');
		}
	}
}
add_action('admin_enqueue_scripts','get_rid_of_the_menus');

//prevent editor from deleting, editing, or creating an administrator
// only needed if the editor was given right to edit users

class TeamCTG_User_Caps {
 
  // Add our filters
  function __construct() {
    add_filter( 'editable_roles', array(&$this, 'editable_roles'));
    add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);
  }
  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
    if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
      unset( $roles['administrator']);
    }
    return $roles;
  }
  // If someone is trying to edit or delete an
  // admin and that user isn't an admin, don't allow it
  function map_meta_cap( $caps, $cap, $user_id, $args ){
    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        case 'delete_user':
        case 'delete_users':
            if( !isset($args[0]) )
                break;
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        default:
            break;
    }
    return $caps;
  }
 
}
 
$teamctg_user_cap_reset = new TeamCTG_User_Caps();

// Hide admin from user list
/*
add_action('pre_user_query','teamctg_pre_user_query');
function teamctg_pre_user_query($user_search) {
  $user = wp_get_current_user();
  if ($user->ID!=5) { // Is not administrator, remove administrator
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.ID<>5",$user_search->query_where);
  }
}
*/
// Hide specified users from user list.
/* 
add_action('pre_user_query','isa_pre_user_query');
function isa_pre_user_query($user_search) {
 
    $admin_ids = '1,5,7,9'; // REPLACE THESE NUMBERS WITH IDs TO HIDE.
     
    $user = wp_get_current_user();
    $admin_array = explode($admin_ids, ',');
    if ( ! in_array( $user->ID, $admin_array ) ) {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1', "WHERE 1=1 AND {$wpdb->users}.ID NOT IN($admin_ids)",$user_search->query_where);
     
    }
}

// Hide all administrators from user list.
 
add_action('pre_user_query','isa_pre_user_query');
function isa_pre_user_query($user_search) {
 
    $user = wp_get_current_user();
     
    if ( ! current_user_can( 'manage_options' ) ) {
   
        global $wpdb;
     
        $user_search->query_where = 
            str_replace('WHERE 1=1', 
            "WHERE 1=1 AND {$wpdb->users}.ID IN (
                 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta 
                    WHERE {$wpdb->usermeta}.meta_key = '{$wpdb->prefix}capabilities'
                    AND {$wpdb->usermeta}.meta_value NOT LIKE '%administrator%')", 
            $user_search->query_where
        );
 
    }
}*/