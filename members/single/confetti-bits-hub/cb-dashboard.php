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


<?php 