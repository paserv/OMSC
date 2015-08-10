<?php session_start(); 
require_once 'autoload.php';
autoload ();
$controller = new Controller ();
$excep = new CustomException(); 
?>
<!DOCTYPE html>
<html>
	<head>
		<title>One Million Social Club - Home Page</title>
		<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link type="text/css" rel="stylesheet" href="public/css/omsc.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
		<meta property="og:title" content="OMSC">
		<meta property="og:image" content="http://www.aoapao.com/public/img/find.png">
		<meta property="og:site_name" content="One Million Social Club">
		<meta property="og:description" content="Join One Million Social Club">
		<meta property="og:locale" content="en_UK">
		<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
		<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
		<script type="text/javascript" src="public/js/materialize.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.19&libraries=places&language=en"></script>
		<script type="text/javascript" src="public/js/config.js"></script>
		<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
	</head>

<body>
	<?php include 'header.php'; if ($excep->existProblem) { include 'error.php'; } else { ?>
	<div class="container">
		<?php if (isset($_POST['g-recaptcha-response'])) {
			$isRobot = $controller->checkIsRobot($_POST['g-recaptcha-response']);
				if ($isRobot) { ?>
					<div class="row">
						<div class="col s12"><h5>Uncorrect Captcha<i class="mdi-content-block left"></i></h5></div>
					</div>
					<div class="card-panel">
						<div class="row">
							<h5>Please try again</h5>
						</div>
					</div>
					<div class="row">
						<a class="btn waves-effect waves-light blue darken-3 right" href="contact.php"><i class="mdi-action-cached right"></i>Try Again</a>
					</div>
				<?php } else {
				$isDelivered = $controller->sendEmail($_POST['name'], $_POST['email'], $_POST['message']);
				if ($isDelivered) {
					echo "Delivered";
				} else {
					echo "NOT Delivered";
					}
				}
			} else {?>
		
			<div class="row">
				<div class="col s12"><h5>Contact Us<i class="mdi-content-mail left small"></i></h5></div>
			</div>
			<div class="card-panel">
				<div class="row">
					<form class="col s12" name="contactForm" action="contact.php" method="post">
						<div class="row">
							<div class="input-field col s12">
								<i class="mdi-action-account-circle prefix"></i>
	          					<input id="name" name="name" type="text" class="validate" required>
	          					<label for="name">Name</label>
	        				</div>
	 				    </div>
		 				<div class="row">
	        				<div class="input-field col s12">
	        					<i class="mdi-content-drafts prefix"></i>
		          				<input id="email" name="email" type="email" class="validate" required>
		          				<label for="email" data-error="Wrong Email Address" data-success="OK">Email</label>
					    	</div>
      					</div>
      					<div class="row">
					    	<div class="input-field col s12">
					        	<i class="mdi-content-create prefix"></i>
					    		<textarea id="message" name="message" class="materialize-textarea" required></textarea>
					    		<label for="message">Message</label>
					        </div>
					    </div>
					   <div class="row">
					   		<div class="input-field col s6">
					   			<div class="g-recaptcha" data-sitekey="6LdYDgsTAAAAAKwhsnmkc4HH_echjjSviT5KXZNa"></div>
					   		</div>
					   		<div class="input-field col s6">
						   		<button class="btn waves-effect waves-light blue darken-3 right" type="submit" name="contact_button" value="contact">Send Message
									<i class="mdi-content-send right"></i>
								</button>
							</div>
					   </div>
					</form>
				</div>
			</div>
	<?php } } ?> 
	</div>
	
	<?php include 'footer.php'; ?>
    </script>
</body>

</html>