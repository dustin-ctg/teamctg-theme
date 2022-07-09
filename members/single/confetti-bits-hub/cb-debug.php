<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="cb-container">
	<div class="cb-module">
		<p style="margin:10px auto auto auto;">
			<?php echo cb_get_total_bits_notice( get_current_user_id() ); ?>
		</p>
		<p>
			<?php cb_reset_date(); ?>
			<?php cb_users_request_balance(); ?>
		</p>
		<?php 

		?>
	</div>
</div>