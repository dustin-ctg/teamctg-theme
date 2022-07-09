<?php 

/*/ 
 * Here we have true facts about the Confetti Bits Exports Module
/*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
	
	<div class="cb-container">
	<div class="cb-module">
		<h4 class="cb-heading">
			Export Log Entries
		</h4>

		<form enctype="multipart/form-data" id="export-download-form" method="post" >
			<ul class="cb-form-page-section" id="cb-export-data">
				<li class="cb-form-line">
					<label class="cb-form-label-top" for="cb_export_type">Export Options</label>
					<select class="cb-form-textbox cb-form-selector"
							name="cb_export_type"
							id="cb_export_type"
							placeholder="">
						<option value="self" selected>My Transactions</option>
						
						<?php if ( cb_is_user_executive() ) { ?>
						<option value="leadership">Leadership Transactions</option>
						<option value="current_cycle_leaderboard">Leaderboard Top 15</option>
						<option value="previous_cycle_leaderboard">Last Cycle's Leaderboard</option>
						<option value="current_cycle_totals">All Totals (Current)</option>
						<option value="previous_cycle_totals">All Totals (Previous Cycle)</option>
						<?php } ?>
						
					</select>
				</li>

				<li class="cb-form-line">
					<label class="cb-form-label-top" for="cb_export_logs">Export a .csv file of your transaction history</label>
					<button type="submit" id="cb_export_logs" name="cb_export_logs" >
						Submit
					</button>
				</li>
			</ul>
		</form>
	</div>
</div>
<?php