<?php
/* 
 * Confetti Bits Import Module 
 * @since Confetti Bits 1.2.1
 * 
 * */ 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="cb-container">
	<div class="cb-module">
		<?php

				$bytes      = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
				$size       = size_format( $bytes );
				$upload_dir = wp_upload_dir();

		?>
		<h4 class="cb-heading">
			Import a List of Users
		</h4>

		<form enctype="multipart/form-data" id="import-upload-form" method="post" >
			<ul class="cb-form-page-section" id="cb-import-data">
				<li class="cb-form-line">
					<label class="cb-form-label-top" for="import">Please choose a .csv file from your computer</label>
					<input type="file" id="import" name="import" accept=".csv" />
				</li>
				<li class="cb-form-line">
					<p><?php printf( __( 'Maximum size: %s' ), $size ); ?></p>
				</li>
			</ul>
			<div class="submit">
				<input type="submit" class="button button-primary" value="Import" />
				<input type="hidden" name="cb_bits_imported" value="" />
			</div>
		</form>
	</div>
</div>
<?php 	