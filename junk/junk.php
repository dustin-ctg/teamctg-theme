<?php 
/*
			if ( is_this_admins() ) { ?>

			

			<?php 
			} else { */ 


















/**
 * Description: Template part for displaying page content in confetti-bits.php
 * Version: 1.2.1
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BuddyBoss_Theme
 */

//	ob_start();
//session_start();
//get_header();
/*

?>
<div id="primary" class="content-area bb-grid-cell">
	<main id="primary" class="site-main">
 		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
		
		<?php
		
		
//		cb_member_template_part();
	
//	bp_get_template_part('confetti-bits/template-parts/content' . 'admin-session');

//		cb_member_template_part();

/*		
		if ( have_posts() ) :
				do_action( THEME_HOOK_PREFIX . '_template_parts_content_top' );
/*/
			/* Start the Loop */
/*/			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
//				get_template_part( '/confetti-bits/template-parts/content', 'admin-session' );
//				get_template_part( '/confetti-bits/template-parts/content', 'dashboard' );

		
/*/			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
	/*/	
/*	?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
	
	}
//get_footer();
*/

/*
function cb_get_confetti_bits_cookie_notice() {

	$cookie_data = 0;

	if ( isset ( $_COOKIE['ConfettiBits'] ) ) {

		$cookie_data = $_COOKIE['ConfettiBits'];

	}

	if ( empty( $cookie_data ) ) {
		// bail if grandma didn't bake us cookies
		$notice = 'You\'ve sent 0 Confetti Bits so far today. You can send up to 20.';
	}

	if ( $cookie_data ) {

		if ( $_COOKIE['ConfettiBits'] > 1 && $_COOKIE['ConfettiBits'] < 20 ) {
			$cookie_notice = 'You\'ve sent ' . $_COOKIE['ConfettiBits'] . 
				' Confetti Bits so far today. You can send up to ' . 
				( 20 - $_COOKIE['ConfettiBits'] ) . ' more.';
		}

		if ( $_COOKIE['ConfettiBits'] == 1 ) {
			$cookie_notice = 'You\'ve sent ' . $_COOKIE['ConfettiBits'] . 
				' Confetti Bit so far today. You can send up to 19 more.';
		}

		if ( $_COOKIE['ConfettiBits'] >= 20 ) {
			$cookie_notice = 'You\'ve already sent ' . $_COOKIE['ConfettiBits'] . 
				' Confetti Bits today. Your counter should reset tomorrow!';
		}
	}

	return $cookie_notice;

}

function cb_confetti_bits_cookie_notice( $cookie_notice = '' ) {

	$cookie_notice = cb_get_confetti_bits_cookie_notice();

	echo $cookie_notice;

}
*/
/*
 * Some horse garbage that didn't work.
 * 
 * *//*
function transactions_new_transaction( $args = '' ) {
	global $wpdb, $bp;

	// Parse the default arguments.
	$r = bp_parse_args(
		$args,
		array(
			'sender_id'     => bp_loggedin_user_id(),
			'recipients'    => array(), 
			'log_entry'     => false,
			'date_sent'     => bp_core_current_time(),
			'error_type'    => 'bool',
		),
		'transactions_new_transaction'
	);

	// Bail if no sender or no content.
	if ( empty( $r['recipient_id'] ) || empty( $r['log_ref'] ) ) {
		if ( 'wp_error' === $r['error_type'] ) {
			if ( empty( $r['sender_id'] ) ) {
				$error_code = 'transaction_empty_recipient';
				$feedback   = __( 'We could not send your bits. Please add one or more recipients.', 'confetti-bits' );
			} else {
				$error_code = 'transaction_empty_log_entry';
				$feedback   = __( 'We could not send your bits. Please add a log entry.', 'confetti-bits' );
			}

			return new WP_Error( $error_code, $feedback );

		} else {
			return false;
		}
	}

	// Create a new message object.
	$transaction				= new Confetti_Bits_Transactions_Transaction();
	$transaction->sender_id		= $r['sender_id'];
	$transaction->log_entry		= $r['log_entry'];
	$transaction->date_sent		= $r['date_sent'];
	$transaction->recipients 	= $transaction->get_recipients();

	// Strip the sender from the recipient list
	if ( isset( $transaction->recipients[ $r['sender_id'] ] ) ) {
		unset( $transaction->recipients[ $r['sender_id'] ] );
	}

	// Filter out the suspended recipients.
	if ( function_exists( 'bp_moderation_is_user_suspended' ) && count( $transaction->recipients ) > 0 ) {
		foreach ( $transaction->recipients as $key => $recipient ) {
			if ( bp_moderation_is_user_suspended( $key ) ) {
				unset( $transaction->recipients[ $key ] );
			}
		}
	}

	// Bail if no recipients.
	if ( empty( $r['recipients'] ) ) {
		if ( 'wp_error' === $r['error_type'] ) {
			return new WP_Error( 'transaction_empty_recipient', __( 'We could not send your bits. Please add one or more recipients.', 'confetti-bits' ) );
		} else {
			return false;
		}
	}

	// Set a default log entry if none exists.
	if ( empty( $transaction->log_entry ) ) {
		$transaction->log_entry = __( 'No Log Entry', 'confetti-bits' );
	}

	// Setup the recipients array.
	$recipient_ids = array();

	// Invalid recipients are added to an array, for future enhancements.
	$invalid_recipients = array();

	// Loop the recipients and convert all usernames to user_ids where needed.
	foreach ( (array) $r['recipients'] as $recipient ) {

		// Trim spaces and skip if empty.
		$recipient = trim( $recipient );
		if ( empty( $recipient ) ) {
			continue;
		}

		// Check user_login / nicename columns first
		// @see http://buddypress.trac.wordpress.org/ticket/5151.
		if ( bp_is_username_compatibility_mode() ) {
			$recipient_id = bp_core_get_userid( urldecode( $recipient ) );
		} else {
			$recipient_id = bp_core_get_userid_from_nicename( $recipient );
		}

		// Check against user ID column if no match and if passed recipient is numeric.
		if ( empty( $recipient_id ) && is_numeric( $recipient ) ) {
			if ( bp_core_get_core_userdata( (int) $recipient ) ) {
				$recipient_id = (int) $recipient;
			}
		}

		// If $recipient_id still blank then try one last time to find a $recipient_id in the nickname field.
		if ( empty( $recipient_id ) ) {
			$recipient_id = bp_core_get_userid_from_nickname( $recipient );
		}

		// Decide which group to add this recipient to.
		if ( empty( $recipient_id ) ) {
			$invalid_recipients[] = $recipient;
		} else {
			$recipient_ids[] = (int) $recipient_id;
		}
	}

	// Strip the sender from the recipient list
	$self_send = array_search( $r['sender_id'], $recipient_ids );
	if ( ! empty( $self_send ) ) {
		unset( $recipient_ids[ $self_send ] );
	}

	// Remove duplicates & bail if no recipients.
	if ( empty( $recipient_ids ) ) {
		if ( 'wp_error' === $r['error_type'] ) {
			return new WP_Error( 'transaction_invalid_recipients', __( 'Confetti Bits could not be sent because you have entered invalid information. Please try again.', 'confetti-bits' ) );
		} else {
			return false;
		}
	}

	// Format this to match existing recipients.
	foreach ( (array) $recipient_ids as $i => $recipient_id ) {
		$transaction->recipients[ $i ]          = new stdClass();
		$transaction->recipients[ $i ]->user_id = $recipient_id;
	}

	// Bail if message failed to send.
	$send = $transaction->send_bits();
	if ( false === is_int( $send ) ) {
		if ( 'wp_error' === $r['error_type'] ) {
			if ( is_wp_error( $send ) ) {
				return $send;
			} else {
				return new WP_Error( 'message_generic_error', __( 'Your Confetti Bits were not sent. Please try again.', 'confetti-bits' ) );
			}
		}
		return false;
	}
*/
/**
	 * Fires after a message has been successfully sent.
	 *
	 * @since BuddyPress 1.1.0
	 *
	 * @param BP_Messages_Message $message Message object. Passed by reference.
	 *//*
	do_action_ref_array( 'transactions_transaction_sent', array( &$transaction ) );

	// Return the item ID.
	return $transaction->item_id;
}
*/

/*
function cb_count_member_search_results( $member_search_results = array() ) {

	if ( empty ( $member_search_results ) ) {
		return;
	}

	return count( $member_search_results );

}

function cb_get_search_notice( $member_search ) {

	if ( is_array ( $member_search ) ) {
		$search_notice = $member_search;
		return $search_notice;

	}

	global $wpdb, $bp;

	$member_search_terms	= isset ( $_POST['search_terms'] ) ? $_POST['search_terms'] : '';
	$member_search_results 	= $member_search->results;

	$member_count = cb_count_member_search_results( $member_search_results );

	switch ( $member_count ) {

		case ( $member_count === 0 ) :

			$member_data = '';

			$search_notice = array (

				'notice' => __('We couldn\'t find anything from searching "' . $member_search_terms . '".', 'confetti-bits'),

				'member_data' => array(),

				'error' => '',

			);

			break;

		case ( $member_count === 1 ) :

			$member_data = array();

			foreach ( $member_search_results as $member ) {

				$user_object = new BP_Core_User( $member->ID );

				array_push (
					$member_data, array (
						'member_id'				=>	$member->ID,
						'member_display_name'	=>	$member->display_name,
						'member_avatar'			=>	$user_object->avatar_thumb,
					)
				);
			}

			$search_notice = array (

				'notice' => 'Alrighty, we got a hit here.',
				'member_data' => $member_data ,
				'error' => '',

			);

			break;

		case ( ( $member_count > 1 ) && ( $member_count < 10 ) ) :

			$member_data = array();

			foreach ( $member_search_results as $member ) {

				$user_object = new BP_Core_User( $member->ID );

				array_push( 
					$member_data, array (
						'member_id'				=>	$member->ID,
						'member_display_name'	=>	$member->display_name,
						'member_avatar'	=>	$user_object->avatar_thumb,
					)
				);
			}

			$search_notice = array (

				'notice' => 'We got ' . $member_count . ' results from looking up "' . $member_search_terms . '".',

				'member_data' => $member_data ,

				'error' => '',

			);

			break;

		case ( ( $member_count >= 10 ) ) :

			$member_data = array();

			foreach ( $member_search_results as $member ) {

				$user_object = new BP_Core_User( $member->ID );

				array_push( 
					$member_data, array ( 
						'member_id' => $member->ID, 
						'member_display_name' => $member->display_name,
						'member_avatar' => $user_object->avatar_thumb,
					)
				);

			}

			$search_notice = array (

				'notice' => __( 'We got over ' . $member_count . ' hits from looking up "' . $member_search_terms . '". That\'s kind of a lot. If you can\'t quite find the person you\'re looking for, try searching them by first and last name.', 'confetti-bits' ),

				'member_data' => $member_data,

				'error' => '',

			);

			break;

	}

	return $search_notice;

}
*/
//
	// ( ! empty( $fetched_transactions['total_count'] ) ?
	
	/*	if ( ! empty( $fetched_transactions ) ) {	

	foreach ( $fetched_transactions as $fetched_transaction ) {

		array_push( $amounts, $fetched_transaction->amount );

	}

	if ( ! empty ( $amounts ) ) {
	
		return array_sum ( $amounts );
	
	} else {
		
		return 0;
		
	}
	/*/	

/*
function whats_that_component() {
	if ( cb_is_user_confetti_bits() && cb_is_confetti_bits_component() ) {
		
		$bp = buddypress();
		$cb = Confetti_Bits();
		echo $bp->current_component . '<br>';
		print_r($cb->active_components);
		echo '<br>' . $bp->notifications->id . '<br>';
		print_r ($cb->loaded_components);
		echo $cb->transactions->slug;
	}
	
	
}
add_action('bp_init', 'whats_that_component');

*/
/*
 * Okay, so for next time, we need to have a little process to go through:
 * 1. Double check the cb_is_current_component function for accuracy
 * 2. cb_is_{$component}_component() function checks that a component is the current component by checking the slüg
 * 3. cb_screen_view function calls bp_load_template( apply_filters( 'confetti_bits_template', 'confetti-bits/confetti-bits' ) ); that's just the page template. need functions that call markup now
 * 4. cb_is_user_{component}() to check if it's a user and it's a current component
 * 5. cb_member_template_part() uses all our "cb_is_user_{$component}() functions to pass a template part id to the next function
 * 6. cb_member_locate_template_part is our template part finder, but uses the $bp_nouveau->members->displayed_user_hierarchy hierarchy class to construct the query
 * 7. cb_member_get_template_part gets the template part based on that id 
 * 8. So that's going to be based on $bp_nouveau->members which is a template class found in bp-templates/bp-nouveau/includes/{$component}/loader.php
 * 9. It's not an extreme necessity rn, it's just to make a component-based array so we can just loop through whatever we want for this
 * 10. cb_member_template_part() is going to be the guy we pop into the template i believe
 * 
 * Pop the cb_is_user_{component}() function in the template and maybe it'll work?
 * Pop the cb_member_get_template_part function in the template and maybe it'll work?
 * 
 * TURNS OUT that the URL for the confetti-bits component is at domain.com/members/{member_name}/confetti-bits
 * 
 * So we have cb_member_locate_template_part, cb_member_get_template_part, cb_member_template_part, cb_locate_template, bp_core_load_template
 * 
 * Okay so another crazy little situation is going on.
 * 
 * In the late_includes of a component, it sometimes checks stuff like "cb_is_confetti_bits_component", 
 * which requires this->path . 'component/screens/some-screen-file.php'. 
 * 
 * In whatever that file is, it has a function like "cb_members_screen_index" which calls "bp_core_load_template", 
 * and there's an add_action for "bp_screens" below it to do that. 
 * 
 * Well that bp_core_load_template function is calling a template file in the theme, in this case "members/index". 
 * 
 * If we go there, we see a bunch of "bp_get_template_part" functions, which pulls shit from the plugin, 
 * in this case "common/filters/directory-filters". 
 * 
 * So idk wtf is going on, but it sucks ass. I guess I'll try switching over the template parts?
 * 
 * 
 * 
 * */

			/*			if ( is_this_admins() ) { ?>
			<li class="cb-send-bits-line">
				<label class="cb-send-bits-label-top" for="amount" >Amount to Send</label>
				<input class="cb-send-bits-textbox" 
					   type="text" 
					   name="amount" 
					   id="amount" 
					   placeholder="Please select a log reference first" 
					   value=""
					   readonly="true">
			</li>
			<?php 

			} else { */


	/*
	 * We want to get info from the database and use that data in variables
	 * for the notification component. We'll be pulling info from the
	 * myCRED database (hopefully we'll make our own at some point and get rid of
	 * that plugin). We need the log entries, though. So we can either create
	 * a new database table or we can push these entries to the mycred table.
	 * 
	 * */
/*/
<div class="confetti-bits-module">
		<h4>Current Leaderboard:</h4>
		<div class="cb-leaderboard">
	echo do_shortcode('[mycred_leaderboard number=15 current=1 total=0 wrap="div"]') ;




		
		</div>
/*/
		/*print_r (mycred_get_leaderboard( $args = 
         * array (
         * 'number' => '15',
         * 'order' => 'DESC',
         * 'user_fields' => 'user_login,display_name,user_email,user_nicename,user_url',
         * 'offset'      => 0,
         * 'type'        => 'mycred_default',
         * 'template'    => '#%ranking% %user_profile_link% %cred_f%'
         * )
         * )
         * ); 
         * */
/*/
	</div>/*/

/*/		$transaction = wp_cache_get( $this->id, 'confetti_bits_transactions' );

		if ( false === $transaction ) {
			$transaction = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$cb->transactions->table_name} WHERE id = %d", $this->id ) );
			wp_cache_set( $this->id, $transaction, 'confetti_bits_transactions' );
		}
/*/
