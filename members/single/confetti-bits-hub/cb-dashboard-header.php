<?php ?>
<div class="cb-dashboard-header">
	<div class="cb-hub-nav-toggle"></div>
	<div class="cb-hub-nav-container">
		<?php 
		$templates = cb_get_active_templates();
		if ( isset($templates['Dashboard Header'] ) ) {
			unset($templates['Dashboard Header']);
		}

		foreach( $templates as $label => $tag ) {

		?>
		<div class="cb-hub-nav-item cb-<?php echo $tag; ?>-toggle<?php echo ( $tag === 'dashboard' ) ? ' active' : ''; ?>">
			<a href="#cb-<?php echo $tag; ?>" class="cb-hub-nav-link"><?php  echo $label; ?></a>
		</div>

		<?php
		}
		?>
	</div>
</div>
<div class="cb-feedback">
	<p class="cb-feedback-message"></p>
</div>