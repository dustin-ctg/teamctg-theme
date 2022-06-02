<?php
/*
 * 
 * Confetti Bits Award Form
 * Version 1.4.2
 * 
 */

/*---------- Start Award Form Functions ----------*/




$current_user_object = wp_get_current_user();
$sender_display_name = $current_user_object->display_name;
$recipient_name = '';
$sender_name = '';
$user_idError = '';
$log_refError = '';
$amountError = '';

/*---------- Uses the hidden input value on submit as a boolean ----------*/
if(isset($_POST['submitted'])) {
	
	
	if ( trim($_POST['sender_name']) === '' ) {
		return false;
	} else {
		$sender_name = trim($_POST['sender_name']);
	}
	
	// If the id is empty, throw an error, else set the id for the point add function
	if(trim($_POST['user_id']) === '' || trim($_POST['member_display_name']) === '' ) {
		$recipient_name = '';
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

	if ( $_COOKIE['ConfettiBits'] >= 20 && !is_this_admins() /*&& !is_this_dustin()/*/ ) {
		$log_ref = '';
		$amount = '';
		$user_id = '';
		$hasError = true;
		$_SESSION['submitMessage'] = '<div class="confetti-bits-module error">Sorry, you\'ve already sent ' . $_COOKIE['ConfettiBits'] . ' Confetti Bits today. Try again tomorrow, please!</div>';
		header('Location:https://teamctg.com/confetti-bits/', true, 303);
		ob_end_flush();
		exit;
		}
	
	/* If there's no error and the post was sent, call the point add function.
	 * Then, set the values back to empty strings.
	 * Then, set the session message in a variable, and P-R-G with the 
	 * stored message.
	 * */

	if( !$hasError && $_POST['submitted'] ) {
		
		
		if ( !is_this_admins() /*&& !is_this_dustin()/*/ && ! isset($_COOKIE['ConfettiBits']) ) {
			setcookie('ConfettiBits', $amount , mktime(24,0,0) );
		} else {
			setcookie('ConfettiBits', $_COOKIE['ConfettiBits'] + $amount , mktime(24,0,0) );
		}
		
		mycred_add('leadership_bits', $user_id, $amount, $log_ref . ' – from ' . $sender_name );
		
		$_SESSION['submitMessage'] = '<div class="confetti-bits-module">We successfully sent bits to ' . $recipient_name . '!</div>';
		$user_id = '';
		$amount = '';
		$log_ref= '';

		
			
		header('Location:https://teamctg.com/confetti-bits/', true, 303);
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
			<input type="hidden" name="recipient_name" id="recipient_name" value="<?php echo $recipient_name; ?>" />
			<input type="hidden" name="sender_name" id="sender_name" value="<?php echo $sender_display_name; ?>" />
			<input type="hidden" name="submitted" id="submitted" value="true" />
		</form>

	<?php if ( !is_this_admins()  && isset($_COOKIE['ConfettiBits']) &&  $_COOKIE['ConfettiBits'] > 1 && $_COOKIE['ConfettiBits'] < 20 ) { ?>
	<p class="confetti-bits-counter">
		You've sent <?php echo $_COOKIE['ConfettiBits']; ?> Confetti Bits so far today. You can send up to <?php echo 20 - $_COOKIE['ConfettiBits']; ?> more.
	</p>
	<?php } else if ( !is_this_admins() && !isset($_COOKIE['ConfettiBits']) ){ ?>
	<p class="confetti-bits-counter">
		You've sent 0 Confetti Bits so far today. You can send up to 20. 
	</p>
	<?php } else if ( isset($_COOKIE['ConfettiBits']) &&  $_COOKIE['ConfettiBits'] == 1 && !is_this_admins() ) { ?>
	<p class="confetti-bits-counter">
		You've sent <?php echo $_COOKIE['ConfettiBits']; ?> Confetti Bit so far today. You can send up to 19 more.
	</p>
<?php } else if ( isset($_COOKIE['ConfettiBits']) && $_COOKIE['ConfettiBits'] >= 20 && !is_this_admins() ) { ?>
		<p class="confetti-bits-counter">
		You've sent <?php echo $_COOKIE['ConfettiBits']; ?> Confetti Bits today. Your counter should reset tomorrow!
	</p>
<?php } ?>
	</div><!-- End of Module -->

<?php 