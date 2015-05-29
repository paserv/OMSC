<?php session_start(); ?>
<!doctype html>
<head>
<title>One Million Social Club - Login with your favourite Social Network</title>
<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="public/js/config.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript" src="public/js/locationpicker.jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="public/css/omsc.css" rel="stylesheet">
<script type="text/javascript">
var coordinate = false;
<?php
	require_once 'autoload.php';
	autoload();
	
	$controller = new Controller ();
	$controller->setSocialLogRequest();
	
	$excep = new CustomException();
	
	try {
		$currentUser = $controller->getUser ( $_SESSION ["sn"] );
		if ($currentUser->isLogged()) {
			if ($currentUser->isRegistered()) {
				?>
					coordinate = {
		    			coords: {
		    				latitude: <?php echo $currentUser->latitude ?> ,
		    		        longitude: <?php echo $currentUser->longitude ?>,
		    				}
						};
				<?php
				} else {
					$paypal_url = $controller->getPayPalUrl();
					}
			} else {
				$loginUrl = $currentUser->loginUrl;
				}
		} catch (Exception $se) {
			$excep->setError(700, "Write here");
		}
	?>
</script>
</head>
<body>

<?php include 'header.php'; ?>

	<div id="headerseparator"></div>
	<div class="corpo">
	<?php
		if ($excep->existProblem) {
			include 'error.php';
		} else {
	?>
				<div class="wrap">
				<?php if ($currentUser->isLogged()) { ?>
				<form name="coordinateForm" action="operation.php" method="post">
					<div class="left_col">
						<div><img src="<?php echo $currentUser->avatarUrl; ?>" /></div>
						<div class="label">Name</div>
						<div><?php echo $currentUser->name; ?></div>
						<div class="label">Email</div>
						<div><?php echo $currentUser->email; ?></div>
						<div class="label">My Coordinates</div>
						<div><b>Latitude</b></div>
						<div><input type="text" name="latitude" id="latitude"/></div>
						<div><b>Longitude</b></div>
						<div><input type="text" name="longitude" id="longitude"/></div>
						<div class="label">Something about me</div>
						<?php 
							if ($currentUser->isRegistered()) {
							?>
							<div><textarea name="aboutme" id="aboutme" rows="2" cols="40" maxlength="160" ><?php echo $currentUser->description; ?></textarea></div>
							<div><input type="submit" name="modify_button" value="Modify"/></div>
							<div><input type="submit" name="delete_button" value="Delete"/></div>
								<?php	
							} else {
							?>
							<div><textarea name="aboutme" id="aboutme" rows="2" cols="40" maxlength="160" ></textarea></div>
							<input type="submit" name="register_button" value="Register"/>
							<?php } ?>
						<div><input type="submit" name="logout_button" value="Logout"/></div>
					</div>
					<div class="right_col">
						<div class="label">Search Coordinates by Address</div>
						<div><input type="text" id="address" /></div>
						<div class="label">Pick Your Address</div>
			        	<div id="map" style="width: 100%; height: 380px;"></div>
			    	</div>
					</form>
					<?php } else if ($loginUrl !== null) { ?>
						<div><img src="public/img/login_ico.png"></div>
						<div><a href="<?php echo $loginUrl; ?>"><img src="public/img/login_<?php echo $_SESSION ["sn"]; ?>.png"></a></div>
						<?php } else { ?>
						<div>Something Wrong</div>
						<?php } ?>
				</div>
	</div>
<?php } include 'footer.php'; ?>
<script type="text/javascript" src="public/js/location_choose.js"></script>
</body>
</html>