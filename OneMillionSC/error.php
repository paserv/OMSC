<div id="error">
	<?php
	$codes = array(
			#Search Error#
			100 => 'No query',
			
			#DB Error#
			200 => 'DB Error',
			
			#Fusion Error#
			300 =>'Fusion Table Error',
			
			#PayPal Error
			400 => 'Paypal Error',
			
			#FB Error#
			500 => 'Facebook Error',
	
			#TW Error#
			600 => 'Twitter Error',
	
			#SEARCH ERROR
			700 => 'Sorry no results found',
			701 => 'Please Register for unlimited search',
			
			#Controller Error#
			800 => 'Impossible Register User into DB',
			801 => 'Impossible Register User into Fusion Table',
			802 => 'Impossible Execute Payment',
			803 =>'Impossible Delete User into Fusion Table',
			804 => 'Impossible Update User into Fusion Table',
			
			#Quiz Error#
			900 => 'Incorrect Solution',
			901 => 'Limit for free quiz subscription reached',
			
			902 => 'Captcha is not correct, please try again'
			
	);
	
	$publicMessage = "No Error to display";
	$controller = new Controller ();
	if($excep->error_code){
		$publicMessage = "Error Code Not Found";
		if (array_key_exists($excep->error_code, $codes)) {
			$publicMessage = $codes[$excep->error_code];
		}
			echo '<div class="container">
					<div class="row">
						<div class="col s12"><h5>Error<i class="material-icons left small">error</i></h5></div>
					</div>
					<div class="card-panel">
						<div class="row">
							<div class="col s12">' . $publicMessage . '</h5></div>
						</div>';
			if ( (int) $excep->error_code < 700 || ( (int) $excep->error_code >= 800 && (int) $excep->error_code < 900 )) {
				echo   '<div class="row">
						    <div class="col s12">Please try again later, if problem persists <a href="contact.php">Contact Us</a>.</h5></div>
						</div>';
				}
			echo   '</div>
					    <div class="row">
							<a class="waves-effect waves-light btn blue darken-3 right" href="index.php"><i class="material-icons right">backspace</i>Come Back Home</a>
					    </div>
				   </div>';

		$controller->sendEmail("Administrator OMSC", "administrator@omsc.com", "Public Message: " . $publicMessage . " - Private Message: " . $excep->private_message . " - Timestamp: " . date('l jS \of F Y h:i:s A'));
		error_log("Public Message: " . $publicMessage . " - Private Message: " . $excep->private_message . " - Timestamp: " . date('l jS \of F Y h:i:s A'));
	} else {
		$controller->sendEmail("Administrator OMSC", "administrator@omsc.com", "Public Message: " . $publicMessage . " - Private Message: EMPTY - Timestamp: " . date('l jS \of F Y h:i:s A'));
		error_log("Public Message: " . $publicMessage . " - Private Message: EMPTY - Timestamp: " . date('l jS \of F Y h:i:s A'));
		echo '<div class="container">
					<div class="row">
						<div class="col s12"><h5>Error<i class="material-icons left small">error</i></h5></div>
					</div>
					<div class="card-panel">
						<div class="row">
							<div class="col s12">' . $publicMessage . '</h5></div>
						</div>
					</div>
					<div class="row">
						<a class="waves-effect waves-light btn blue darken-3 right" href="index.php"><i class="material-icons right">backspace</i>Come Back Home</a>
					</div>
				</div>';
	}
	?>	
</div>