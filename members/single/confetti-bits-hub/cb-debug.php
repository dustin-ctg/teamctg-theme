<div class="cb-container">
	<div class="cb-module">
		<?php 

		$transaction  = new Confetti_Bits_Transactions_Transaction();
		$transaction_earned = $transaction->get_users_earning_cycle( 5 );
		$transaction_spending = $transaction->get_users_spending_cycle( 5 );
		$total_balance = $transaction->get_users_balance( 5 );
		
		echo 'total earned: ' . $transaction_earned[0]['amount'] . '<br>';
		echo 'total spent: ' . $transaction_spending[0]['amount'] . '<br>';
		echo 'total balance: ' . $total_balance . '<br>';
		echo $transaction_earned[0]['amount'] + $transaction_spending[0]['amount'] . '<br>';
		echo bp_get_option( 'cb_reset_date' ) . '<br>';
		echo date( 'Y-m-d H:i:s', strtotime( bp_get_option( 'cb_reset_date' ) . ' - 1 year + 1 month') ) . '<br>';
		
		/*/ 
		 * if they're in the current cycle, it'll be whatever is on the leaderboard
		 * their spending pool will have to be separate from their current balance until the actual 
		 * reset at the end of july
		 * 
		 * so we can have one balance be their spending pool that resets at the end of july
		 * one balance is their leaderboard balance that resets at the beginning of july
		 * if it's currently july, their spending pool is their balance that was seen on the leaderboard
		 * before it reset
		 * otherwise, it's the value currently on the leaderboard
		 * 
		 * could check if it's july, change the query based on that
		 * spending pool = (is_july ? 1000 : whatever's on the leaderboard)
		 * 
		 * leaderboard gets everything from july 1st 21-22
		 * spending pool would be that, but how do we get it to change after july 31st 2022?
		 * 
		 * if july, 
		 * spending pool (current balance) is everything from july 1 - july 1
		 * 
		 * if august or later of current year, or january to june of current year,
		 * spending pool (current balance) is 
		 * everything from $july_1_current_year through $july_1_current_year + $1_year
		 * 
		 * if after spending cycle, spending pool = new spending cycle
		 * 
		 * after spending cycle = current month-year > spending cycle reset date
		 * 
		 * for fucks sake oh my god why is this not making sense
		 * 
		 * spending pool = range of stuff from spending cycle start to finish
		 * current balance = if date is within cycle or 1 month from end of cycle
		 * leaderboard balance = regular yearly cycle
		 * 
		 * make new spending cycle = selected date + 1 year
		 * can_spend is based on whatever is in make new spending cycle
		 * 
		 * /*/

		$current_date = date('Y-m-d H:i:s');
		$reset_date = date('Y-m-d H:i:s', strtotime('06/01/2022') );
		$spending_cycle_start_date = date('Y-m-d H:i:s', strtotime('06/01/2021') );
		$spending_cycle_end_date = date('Y-m-d H:i:s', strtotime( $spending_cycle_start_date . '+ 1 year + 1 month') );

		echo 'current date: ' . $current_date . '<br>';

		echo 'reset date: ' . $reset_date . '<br>';

		echo 'spending cycle start date: ' . $spending_cycle_start_date . '<br>';

		echo 'spending cycle end date: ' . $spending_cycle_end_date . '<br>';

		echo 'spending pool end date: ' . $reset_date . '<br>';

		echo 'they\'ll pretty much only be spending bits on requests, so we count requests separately i think<br>';

		if ( $current_date < $reset_date ) {
			echo 'ye' . '<br>';
		}

		?>
		<form>
			<input type="date">
		</form>
	</div>
</div>