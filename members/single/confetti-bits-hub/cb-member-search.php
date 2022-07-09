<?php
/* 
 * Confetti Bits Member Search Panel
 * @since Version 1.0.0
 * 
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="cb-container">
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
							   action="" 
							   value="Search">
				</li>
			</ul>
		</form>
		<div class="cb-member-selection-container">
			<?php cb_search_results(); ?>
		</div>
	</div> 
</div>
<?php 