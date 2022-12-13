<?php
/**
 * 
 * Confetti Bits Form
 * Version 1.4.2
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="cb-container" id="cb-send-bits">
	<div class="cb-module">
		<h4 class="cb-heading">
			Search for someone to send them bits
		</h4>
		<form class="cb-form" method="post" name="team_search" autocomplete="on">
			<ul class="cb-form-page-section">
				<li class="cb-form-line">
					<label class="cb-form-label-top">Search Terms</label>
					<input type="search" name="cb_member_search_terms" placeholder="Full name, email, office, anything!">
				</li>
				<li class="cb-form-line">
					<input type="submit" 
						   class="cb-submit" 
						   name="cb_member_search_submit" 
						   id="cb_member_search_submit" 
						   value="Search">
				</li>
			</ul>
		</form>
		<div class="cb-member-selection-container">
			<?php cb_search_results(); ?>
		</div>
	</div> 

	<div class="cb-module">
		<h4 class="cb-heading">
			Send Bits to Team Members
		</h4>
		<p class="cb-counter">
			<?php 
			if ( !cb_is_user_admin() || cb_is_user_site_admin() ) {
				cb_users_transfer_balance_notice();
			}
			?>
		</p>
		<form class="cb-form" method="post" name="send_bits_form" id="send_bits_form" action="<?php echo  bp_get_canonical_url(); ?>" autocomplete="off">
			<ul class="cb-form-page-section" id="cb-send-bits-data">

				<li class="cb-form-line">
					<label class="cb-form-label-top" for="recipient_name">Team Member</label>
					<input class="cb-form-textbox" 
						   type="text" 
						   name="recipient_name" 
						   id="recipient_name" 
						   readonly="true" 
						   value="" 
						   placeholder="Select a team member from the search panel" style="color:#9a9a9a;">
				</li>

				<li class="cb-form-line">
					<input class="cb-form-textbox" 
						   type="hidden" 
						   name="recipient_id" 
						   id="recipient_id" 
						   value="" 
						   placeholder="">
				</li>

				<li class="cb-form-line">
					<label class="cb-form-label-top" for="log_entry" >Log Entry</label>			
					<input class="cb-form-textbox" 
						   type="text"
						   name="log_entry" 
						   id="log_entry" 
						   placeholder="Let them know what it's for!">
				</li>

				<?php  ?>
				<li class="cb-form-line">
					<label class="cb-form-label-top" for="amount" >Amount to Send</label>
					<input class="cb-form-textbox" 
						   type="number" 
						   min="1" 
						   max="20" 
						   name="amount" 
						   id="amount"  
						   value="">

				</li>

				<li class="cb-form-line">
					<input class="cb-submit" 
						   type="submit"
						   name="cb_send_bits"
						   id="cb_send_bits"
						   action="<?php echo  wp_nonce_url(bp_get_canonical_url(), 'cb-send-bits'); ?>" 
						   value="Submit">
				</li>
			</ul>
			<input type="hidden" 
				   readonly="true" 
				   name="sender_id" 
				   id="sender_id" 
				   value="<?php echo bp_current_user_id(); ?>" />


		</form>
		<p class="cb-counter">
			<?php cb_total_for_current_day_notice(); ?>
		</p>

	</div><!-- End of Module -->
</div>
<?php 