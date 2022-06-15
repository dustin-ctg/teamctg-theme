<?php
/*
 * 
 * Confetti Bits Requests
 * Version 2.1.0
 * 
 */
?>

<!-- Bring out the dancing markup -->
<div class="cb-container">
	<div class="cb-module">
		<h4 class="cb-heading">
			Send a New Request
		</h4>
		<form class="cb-form" method="post" name="cb_request_form" id="cb_request_form" action="<?php echo  bp_get_canonical_url(); ?>" autocomplete="off">
			
			<ul class="cb-form-page-section" id="cb-send-bits-data">

				<li class="cb-form-line">
					<label class="cb-form-label-top" for="cb_request_option" >Request Options</label>
					<select class="cb-form-textbox cb-form-selector" 
							name="cb_request_option" 
							id="cb_request_option" 
							placeholder="">
						<option disabled selected >--- Select an Option ---</option>
						<option value="One PTO Day" 
								class="cbRequestOption" 
								data-request-value="1500">One PTO Day</option>
						<option value="Dinner/1-on-1 with Company Leader" 
								class="cbRequestOption" 
								data-request-value="1200">Dinner/1-on-1 with Company Leader</option>
						<option value="Single Night Hotel Stay" 
								class="cbRequestOption" 
								data-request-value="900">Single Night Hotel Stay</option>
						<option value="Spa Trip" 
								class="cbRequestOption" 
								data-request-value="700">Spa Trip</option>
						<option value="$25 DoorDash Gift Card" 
								class="cbRequestOption" 
								data-request-value="500">$25 DoorDash Gift Card</option>
						<option value="$25 Starbucks Gift Card" 
								class="cbRequestOption" 
								data-request-value="500">$25 Starbucks Gift Card</option>
						<option value="$20 CTG Gift Card" 
								class="cbRequestOption" 
								data-request-value="400">$20 CTG Gift Card</option>
						
						<?php if ( cb_is_user_site_admin() ) { ?>	
						
						<option value="Test Request" 
								class="cbRequestOption" 
								data-request-value="100">Test Request</option>
						
						<?php } ?>
					</select>
				</li> 

				<li class="cb-form-line">
					<label class="cb-form-label-top" for="cb_request_amount" >Bits Cost</label>
					<input class="cb-form-textbox" 
						   type="number" 
						   name="cb_request_amount" 
						   id="cb_request_amount"  
						   readonly="true"
						   value="">
				</li>

				<li class="cb-form-line">
					<input class="cb-submit" 
						   type="submit"
						   name="send_bits_request"
						   id="send_bits_request"
						   action="<?php echo  wp_nonce_url(bp_get_canonical_url(), 'cb-send-bits-request'); ?>" 
						   value="Submit">
				</li>
			</ul>
		</form>
		
<?php 
/*/		$transaction_logs = new Confetti_Bits_Transactions_Transaction();
	$transaction_query = $transaction_logs->get_users_balance( get_current_user_id() );

	foreach ( $transaction_query as $query_result ) {

		$total = $query_result['amount'];
		echo $total . '??';
	} 
		/*/?>
	</div><!-- End of Module -->
</div>
<?php 

