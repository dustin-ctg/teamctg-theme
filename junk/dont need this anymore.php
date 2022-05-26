<?php
/*
 * Confetti Bits Flash Messages
 * @since Version 1.0.0
 * 
 * */



/* 
 * Need to set this up as an object, store it in a function to call it easily over and over again
 * 
 * */




/*---------- Set the message to show up on the GET request ----------*/
		
/*	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		if(isset($_SESSION['submitMessage'])) {
			$submitMessage = $_SESSION['submitMessage'];
			unset($_SESSION['submitMessage']);*/
			?>
<div class="confetti-bits-module unstretch-it center-it error">
	<?php echo cb_search_notice(); ?>
</div>
<?php
//		}
//	}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
		if(isset($_SESSION['submitMessage'])) {
			$submitMessage = $_SESSION['submitMessage'];
			unset($_SESSION['submitMessage']);
			?>
<div class="submission-message-popup import-notifications">
			<?php echo $submitMessage; ?>	
</div>
<?php
		}
	}