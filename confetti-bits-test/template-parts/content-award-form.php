<?php
/*
 * 
 * Confetti Bits Award Form
 * Version 1.4.1
 * 
 */


/* Maybe Notifications? */
/**
 * Notification formatting callback for bp-friends notifications.
 *
 * @since BuddyPress 1.0.0
 *
 * @param string $action            The kind of notification being rendered.
 * @param int    $item_id           The primary item ID.
 * @param int    $secondary_item_id The secondary item ID.
 * @param int    $total_items       The total number of messaging-related notifications
 *                                  waiting for the user.
 * @param string $format            'string' for BuddyBar-compatible notifications;
 *                                  'array' for WP Toolbar. Default: 'string'.
 * @return array|string
 */

/*
function confetti_bits_format_notifications( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

	switch ( $action ) {
		case 'new_confetti_bits':
			$link = trailingslashit( bp_loggedin_user_domain() . '/confetti-bits' );

			// $action and $amount are used to generate dynamic filter names.
			$action = 'accepted';

			// Set up the string and the filter.
			if ( (int) $total_items > 1 ) {
				$text   = sprintf( __( '%d sent you Confetti Bits', 'buddyboss' ), (int) $total_items );
				$amount = 'multiple';
			} else {
				$text   = sprintf( __( '%s sent you Confetti Bits', 'buddyboss' ), bp_core_get_user_displayname( $secondary_item_id ) );
				$amount = 'single';
			}

			break;

		case 'new_confetti_bits':
			$link = bp_loggedin_user_domain() . bp_get_friends_slug() . '/requests/?new';

			$action = 'request';

			// Set up the string and the filter.
			if ( (int) $total_items > 1 ) {
				$text   = sprintf( __( 'You have %d pending requests to connect', 'buddyboss' ), (int) $total_items );
				$amount = 'multiple';
			} else {
				$text   = sprintf( __( '%s sent you an invitation to connect', 'buddyboss' ), bp_core_get_user_displayname( $item_id ) );
				$amount = 'single';
			}

			break;
	}
*/
	// Return either an HTML link or an array, depending on the requested format.
/*	if ( 'string' == $format ) {

		/**
		 * Filters the format of friendship notifications based on type and amount * of notifications pending.
		 *
		 * This is a variable filter that has four possible versions.
		 * The four possible versions are:
		 *   - bp_friends_single_friendship_accepted_notification
		 *   - bp_friends_multiple_friendship_accepted_notification
		 *   - bp_friends_single_friendship_request_notification
		 *   - bp_friends_multiple_friendship_request_notification
		 *
		 * @since BuddyPress 1.0.0
		 *
		 * @param string|array $value       Depending on format, an HTML link to new requests profile
		 *                                  tab or array with link and text.
		 * @param int          $total_items The total number of messaging-related notifications
		 *                                  waiting for the user.
		 * @param int          $item_id     The primary item ID.
		 */

/*
		$return = apply_filters( 'confetti_bits_' . $amount . '_got_bits_' . $action . '_notification', '<a href="' . esc_url( $link ) . '">' . esc_html( $text ) . '</a>', (int) $total_items, $item_id );
	} else {
		/** This filter is documented in bp-friends/bp-friends-notifications.php */
/*		$return = apply_filters(
			'confetti_bits_' . $amount . '_leadership_' . $action . '_notification',
			array(
				'link' => $link,
				'text' => $text,
			),
			(int) $total_items,
			$item_id
		);
	}

	/**
	 * Fires at the end of the confetti_bits notification format callback.
	 *
	 * @since BuddyPress 1.0.0
	 *
	 * @param string       $action            The kind of notification being rendered.
	 * @param int          $item_id           The primary item ID.
	 * @param int          $secondary_item_id The secondary item ID.
	 * @param int          $total_items       The total number of messaging-related notifications
	 *                                        waiting for the user.
	 * @param array|string $return            Notification text string or array of link and text.
	 */
/*	do_action( 'confetti_bits_format_notifications', $action, $item_id, $secondary_item_id, $total_items, $return );

	return $return;
}
*/

/*---------- Start Award Form Functions ----------*/


/*---------- Uses the hidden input value on submit as a boolean ----------*/

$current_user_object = wp_get_current_user();
$sender_display_name = $current_user_object->display_name;
$sender_id = $current_user_object->ID;
$recipient_display_name = '';
$sender_name = '';
$user_idError = '';
$log_refError = '';
$amountError = '';
$transaction_id = 1;

if(isset($_POST['submitted'])) {


	// If the id is empty, throw an error, else set the id for the point add function
	if(trim($_POST['user_id']) === '' || trim($_POST['member_display_name'] === '' ) ) {
		$user_id = '';
		$user_idError = 'Please select someone to award bits to.';
		$hasError = true;
		$formSuccess = false;
	} else {
		$recipient_name = trim($_POST['member_display_name']);
		$identifier = trim($_POST['user_id']);
		$user_id = mycred_get_user_id($identifier);	
	}

	// If the amount is empty, throw an error, else set the amount for the point add function
	if( trim ( $_POST['award_amount'] ) === '') {
		$amount = '';
		$amountError = 'Please enter an amount to send.';
		$hasError = true;
		$formSuccess = false;
	} else if( (abs(trim ( $_POST['award_amount'] )) > mycred_get_users_balance($user_id)) && (trim ( $_POST['award_amount'] ) < 0 ) ) {
		$amount = '';
		$amountError = $recipient_name. ' doesn\'t have enough Confetti Bits for that.';
		$hasError = true;
		$formSuccess = false;
	} else {
		$amount = trim($_POST['award_amount']);
	}
		
	// If the log reference is empty, throw an error, else set the log reference for the point add function
	if(trim($_POST['log_ref']) === '') {
		$log_ref = '';
		$log_refError = 'We need to know what that award was for, pretty please!';
		$hasError = true;
		$formSuccess = false;
	} else {
		$log_ref = str_replace("\\",'',$_POST["log_ref"]);
	}
	
	if ( trim($_POST['sender_name']) === '' ) {
		$hasError = true;
		$sender_name = '';
	} else {
		$sender_name = trim($_POST['sender_name']);
	}

	if ( $_COOKIE['ConfettiBits'] >= 20 && !is_this_admins() && !is_this_dustin() ) {
		$log_ref = '';
		$amount = '';
		$user_id = '';
		$hasError = true;
		$_SESSION['submitMessage'] = '<div class="confetti-bits-module error">Sorry, you\'ve already sent ' . $_COOKIE['ConfettiBits'] . ' Confetti Bits today. Try again tomorrow, please!</div>';
		header('Location:https://teamctg.com/confetti-bits-test/', true, 303);
		ob_end_flush();
		exit;
		}
	
	/* If there's no error and the post was sent, call the point add function.
	 * Then, set the values back to empty strings.
	 * Then, set the session message in a variable, and P-R-G with the 
	 * stored message.
	 * */

	if( !$hasError && $_POST['submitted'] ) {

		
		
		if ( !is_this_admins() && /*!is_this_dustin() &&/*/ ! isset( $_COOKIE['ConfettiBits'] ) ) {
			
			setcookie( 'ConfettiBits', $amount , mktime(24,0,0) );
			
		} else {

			setcookie('ConfettiBits', $_COOKIE['ConfettiBits'] + $amount , mktime(24,0,0) );
			
		}
				
		mycred_add('leadership_bits', $user_id, $amount, $log_ref . ' – from ' . $sender_name );

//		send_confetti_bits( $user_id, get_current_user_id() );
		
		/*bp_notifications_add_notification(
		array(
			'user_id'           => $user_id,
			'item_id'           => $wpdb->insert_id,
			'secondary_item_id' => $sender_id,
			'component_name'    => 'confetti_bits',
			'component_action'  => 'new_confetti_bits',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		)
	);*/
		
		$_SESSION['submitMessage'] = '<div class="confetti-bits-module">We successfully sent bits to ' . $recipient_name . '!</div>';
		$user_id = '';
		$amount = '';
		$log_ref= '';
		
		
			
		header('Location:https://teamctg.com/confetti-bits-test/', true, 303);
		ob_end_flush();
		exit;



/* Else if there's an error there, let us know by 
 * storing a fail message, and emptying the input values.
 * */
	} else if ( $hasError && $_POST['submitted'] ) {
		if (! isset($_SESSION['submitMessage']) ) {
			$_SESSION['submitMessage'] = '<div>Something went wrong; we weren\'t able to send bits.</div>';	
		} 
		
		$user_id = '';
		$amount = '';
		$log_ref= '';
		
	} else {
		return false;
	}
}

echo bp_is_active('confetti-bits-notifications') ? "true" : "false" . '<br>';
print_r (bp_notifications_get_registered_components());

?>

<!-- Start the Award Markup -->
	
<div class="confetti-bits-module">

	<h4 class="confetti-bits-heading">
		Award Points to Team Members
	</h4>
	<form class="award-form" method="post" name="award_form" autocomplete="off">
		<ul class="award-form-page-section" id="award-form-data">
				
			<li class="award-form-line">
				<label class="award-form-label-top" for="member_display_name">Team Member</label>
				<input class="award-form-textbox" 
					   type="text" 
					   name="member_display_name" 
					   id="member_display_name" 
					   value="" 
					   readonly="true"
					   placeholder="Select a team member from the search panel" style="color:#9a9a9a;">
				
				<?php if($user_idError != '') { ?>
					<span class="error"><?php echo $user_idError; ?></span>
				<?php } ?>
			</li>
			
			<li class="award-form-line">
				<input class="award-form-textbox" 
					   type="hidden" 
					   name="user_id" 
					   id="user_id" 
					   value="" 
					   placeholder="">
			</li>
			<?php 
			if ( is_this_admins() /*|| is_this_dustin()/*/ ) { ?>
			
			<li class="award-form-line">
				<label class="award-form-label-top" for="log_ref" >Log Reference</label>
				<select class="award-form-textbox" 
						name="log_ref" 
						id="log_ref" 
						placeholder="">
					<option disabled selected >--- Select an Option ---</option>
					<option value="Attending Company Party/Event" 
							class="logEntry" 
							data-award-value="20">Attending Company Party/Event</option>
					<option value="Member of Contest-Winning Office" 
							class="logEntry" 
							data-award-value="10">Member of Contest-Winning Office</option>
					<option value="Contest Winner" 
							class="logEntry" 
							data-award-value="10">Contest Winner</option>
					<option value="Spirit Day Participation" 
							class="logEntry" 
							data-award-value="5">Spirit Day Participation</option>
					<option value="Monthly Meeting" 
							class="logEntry" 
							data-award-value="5">Monthly Meeting</option>
					<option value="Amanda\'s Workshop" 
							class="logEntry" 
							data-award-value="5">Amanda's Workshop</option>
					<option value="Confetti Captain Participation" 
							class="logEntry" 
							data-award-value="5">Confetti Captain Participation</option>
					<option value="Office Decoration Participation" 
							class="logEntry" 
							data-award-value="5">Office Decoration Participation</option>
					<option value="Monthly Culture Club Planners" 
							class="logEntry" 
							data-award-value="5">Monthly Culture Club Planners</option>
					<option value="All other participation" 
							class="logEntry" 
							data-award-value="5">All other participation</option>
					<option value="One PTO Day" 
							class="logEntry" 
							data-award-value="-1500">One PTO Day</option>
					<option value="Dinner/1-on-1 with Company Leader" 
							class="logEntry" 
							data-award-value="-1200">Dinner/1-on-1 with Company Leader</option>
					<option value="Single Night Hotel Stay" 
							class="logEntry" 
							data-award-value="-900">Single Night Hotel Stay</option>
					<option value="Spa Trip" 
							class="logEntry" 
							data-award-value="-700">Spa Trip</option>
					<option value="$25 DoorDash Gift Card" 
							class="logEntry" 
							data-award-value="-500">$25 DoorDash Gift Card</option>
					<option value="$25 Starbucks Gift Card" 
							class="logEntry" 
							data-award-value="-500">$25 Starbucks Gift Card</option>
					<option value="$20 CTG Gift Card" 
							class="logEntry" 
							data-award-value="-400">$20 CTG Gift Card</option>
				</select>
			</li> 
			
			<?php 
			} else { 
				?>
			
			<li class="award-form-line">
				<label class="award-form-label-top" for="log_ref" >Log Reference</label>			
				<input class="award-form-textbox" 
					  	type="text"
						name="log_ref" 
						id="log_ref" 
						placeholder="Let them know what it's for!">
			</li>
			<?php 
			
			}
				
			if($log_refError != '') { ?>	
			
				<span class="error"><?php echo $log_refError; ?></span>
			
			<?php 
			} 
			
			if ( is_this_admins() /*|| is_this_dustin()/*/ ) { ?>
			<li class="award-form-line">
				<label class="award-form-label-top" for="award_amount" >Amount to Send</label>
				<input class="award-form-textbox" 
					   type="text" 
					   name="award_amount" 
					   id="award_amount" 
					   placeholder="Please select a log reference first" 
					   value=""
					   readonly="true">
			</li>
			<?php 
				
			} else { ?>
			<li class="award-form-line">
				<label class="award-form-label-top" for="award_amount" >Amount to Send</label>
				<input class="award-form-textbox" 
					   type="number" 
					   min="1" 
					   max="20" 
					   name="award_amount" 
					   id="award_amount"  
					   value="">
				
			</li>
			<?php } 
			
			if($amountError != '') { ?>
				<span class="error"><?php echo $amountError; ?></span>
			<?php } ?>
			
			<li class="award-form-line">
				<div class="submit-container">
					<input class="award-submit" 
						   type="submit" 
						   action="content-award-form.php" 
						   value="Submit">
				</div>
			</li>
			</ul>
			<input type="hidden" name="recipient_name" id="recipient_name" value="<?php echo $recipient_display_name; ?>" />
			<input type="hidden" name="sender_name" id="sender_name" value="<?php echo $sender_display_name; ?>" />
			<input type="hidden" name="submitted" id="submitted" value="true" />
		</form>
	<p>
		<?php 
print_r( bp_notifications_get_notification( 9066 ));
		?>
	</p>
		
	<?php if ( !is_this_admins()  && isset($_COOKIE['ConfettiBits']) && $_COOKIE['ConfettiBits'] > 1 && $_COOKIE['ConfettiBits'] < 20 ) { ?>
	<p class="confetti-bits-counter">
		You've sent <?php echo $_COOKIE['ConfettiBits']; ?> Confetti Bits so far today. You can send up to <?php echo 20 - $_COOKIE['ConfettiBits']; ?> more.
	</p>
	<?php } else if ( !is_this_admins() && !isset($_COOKIE['ConfettiBits']) ){ ?>
	<p class="confetti-bits-counter">
		You've sent 0 Confetti Bits so far today. You can send up to 20. 
	</p>
	<?php } else if ( !is_this_admins() && isset($_COOKIE['ConfettiBits']) && $_COOKIE['ConfettiBits'] == 1 ) { ?>
	<p class="confetti-bits-counter">
		You've sent <?php echo $_COOKIE['ConfettiBits']; ?> Confetti Bit so far today. You can send up to 19 more.
	</p>
<?php } else if ( !is_this_admins() && isset($_COOKIE['ConfettiBits']) && $_COOKIE['ConfettiBits'] >= 20 ) { ?>
		<p class="confetti-bits-counter">
		You've sent <?php echo $_COOKIE['ConfettiBits']; ?> Confetti Bits today. Your counter should reset tomorrow!
	</p>
<?php } ?>
	</div><!-- End of Module -->

<?php 