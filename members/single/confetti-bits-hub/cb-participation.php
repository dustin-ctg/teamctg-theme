<div class="cb-container">
	<div class="cb-module">
		<div class="cb-participation">
			<h4 class="cb-heading">
				Confetti Bits Participation
			</h4>
			<p style="margin:10px auto auto auto;">
				Submit your registration information here.
			</p>

			<form>
				<?php 


				cb_file_input(
					array(
						'accepts'	=> array('.jpg', '.jpeg', '.png', '.heic'),
//						'capture'	=> 'user'
					)
				);
				cb_form_component(
					array(
						'for'	=> 'cb_participation_amt',
						'type'	=> 'number'
					)
				);
				cb_submit_input();
				?>
			</form>

		</div>
	</div>
</div>