<?php
/* 
 * Confetti Bits Import Module 
 * @since Confetti Bits 1.2.1
 * 
 * */ 

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

/*/
$fname = 'Charles';
$lname = 'Brayden';

	$new_user_query	= new BP_User_Query( array(
				'type' => 'alphabetical',
				'search_terms' => $fname . ' ' . $lname,
				'search_wildcard' => 'both',
				'count_total' => 'sql_count_found_rows',
				'per_page' => 1,
				) );
	$new_user_query->__construct();

	$query_results	= $new_user_query->results;

	
				foreach ( $query_results as $query_result ) {
					
	$user_id = 				$query_result->ID;
				}
					echo $user_id;
/*/
?>

<?php
// Call out the dancing importer
//confetti_bits_importer();
/* 
		// A function to build a new importer

?>

<h4 class="cb-heading">
	Import a List of Users
</h4>

<form enctype="multipart/form-data" id="import-upload-form" method="post" >
	<ul class="cb-form-page-section" id="award-form-data">
		<li class="cb-form-line">
			<label class="cb-form-label-top" for="import">Please choose a .csv file from your computer</label>
			<input type="file" id="import" name="import" accept=".csv" />
		</li>
		<input type="hidden" name="action" value="save" />
		<input type="hidden" name="max_file_size" value="<?php echo $bytes; ?>" />
		<li class="cb-form-line">
			<p><?php printf( __( 'Maximum size: %s' ), $size ); ?></p>
		</li>
	</ul>
	<div class="submit">
		<input type="submit" class="button button-primary" value="Import" />
		<input type="hidden" name="bits_imported" value="">
	</div>
</form>
<?php 

*/