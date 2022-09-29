<?php 
/*/ 
 * Here we have true facts about the Confetti Bits Log History Panel
/*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="cb-container cb-wide">
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