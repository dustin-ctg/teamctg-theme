<div class="cb-container">
	<div class="cb-module">
				<p style="margin:10px auto auto auto;">
			<?php echo cb_get_total_bits_notice( get_current_user_id() ); ?>
		</p>

		<?php 

		$transaction  = new Confetti_Bits_Transactions_Transaction();
		$transaction_earned = $transaction->get_users_earning_cycle( 76 );
		$transaction_spending = $transaction->get_users_spending_cycle( 76 );
		$total_balance = $transaction->get_users_balance( 76 );
		
		echo 'total earned: ' . $transaction_earned[0]['amount'] . '<br>';
		echo 'total spent: ' . $transaction_spending[0]['amount'] . '<br>';
		echo 'total balance: ' . $total_balance . '<br>';
		echo $transaction_earned[0]['amount'] + $transaction_spending[0]['amount'] . '<br>';
		echo 'the current setting is: ' . bp_get_option( 'cb_reset_date' ) . '<br>';
		echo 'the current date is: ' . date('Y-m-d H:i:s') . '<br>';
		echo date( 'Y-m-d H:i:s', strtotime( bp_get_option( 'cb_reset_date' ) . ' - 1 year + 1 month') ) . '<br>';

		$current_date = date('Y-m-d H:i:s');
		$reset_date = date('Y-m-d H:i:s', strtotime('06/01/2022') );
		$spending_cycle_start_date = date('Y-m-d H:i:s', strtotime('06/01/2021') );
		$spending_cycle_end_date = date('Y-m-d H:i:s', strtotime( $spending_cycle_start_date . '+ 1 year + 1 month') );

		echo 'current date: ' . $current_date . '<br>';

		echo 'reset date: ' . $reset_date . '<br>';

		echo 'spending cycle start date: ' . $spending_cycle_start_date . '<br>';

		echo 'spending cycle end date: ' . $spending_cycle_end_date . '<br>';

		echo 'spending pool end date: ' . $reset_date . '<br>';

		?>
	</div>
</div>