<?php
/*
 * 
 * Confetti Bits Member Dashboard
 * @since Version 1.0.0
 * 
 */

?>

<div class="cb-container">
	<div class="cb-module">
		<div class="cb-leaderboard">
			<h4 class="cb-heading">
				Confetti Cannon Top 15
			</h4>
			<?php cb_leaderboard(); ?>

			<p style="margin:10px auto auto auto;">
				<?php echo cb_get_total_bits_notice( get_current_user_id() ); ?>
			</p>

		</div>
	</div>
</div>

<div class="cb-container">
	<div class="cb-module">
		<div class="cb-log">
			<h4 class="cb-heading">
				Confetti Bits Log
			</h4>

			<?php cb_log(); ?>

		</div>
	</div>
</div>
<div class="cb-container">
	<div class="cb-module cb-notice">
		<div class="cb-notice-header-container">
			<h4 class="cb-heading" style="text-align:left;display:block;flex:0 1 auto;"><b>The transition from the previous Confetti Bits program has been completed. Please refer to below for additional updates.</b></h4>
			<div class="cb-close-notice-container">
				<span class="cb-close-notice"></span>
			</div>

		</div>
		<p>The most likely reason for any discrepancies that may exist between your current Confetti Bits balance and the balance you had prior to the transition would be <b>from either your web browser or the server storing specific values prior to a significant change</b>, such as:</p>
		<ul>
			<li>Balance corrections for platform-wide changes</li>
			<li>Retroactive changes from when posting changed from 5 Bits to 1 on May 1st</li>
			<li>Duplicate log entries from when posting changed from 3 times a day to 1</li>
		</ul>
		<p>
			This persistent browser/server caching is a <b>known bug that was addressed with Confetti Bits 2.1.1</b>, and has been fixed with the new update. <b>Your previous balance may not have been accurate, and your current balance should be fully accurate.</b>
		</p>

		<p>
			Your bits have been fully transitioned over to the new system. <b><a href="https://teamctg.com/wp-content/uploads/2022/06/Confetti-Bits-Full-Audit.xlsx" download>You can download and view all three full Confetti Bits Audits here.</a></b> It includes the original log export from the previous version of Confetti Bits platform, the April Confetti Bits import list, and any deductions that occurred from various transactions.<br>If you would like another audit performed on your personal Confetti Bits balance, or if you would like to be sent a copy of your Confetti Bits transaction history, <a href="https://form.jotform.com/221508198714055" target="_blank">please submit a request here.</a>
		</p>


	</div>
</div>
<?php 