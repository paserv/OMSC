<?php session_start(); 
require_once 'autoload.php';
autoload (); 
$controller = new Controller ();
$excep = new CustomException(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>One Million Social Club - Home Page</title>
		<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link type="text/css" rel="stylesheet" href="public/css/omsc_.css" />
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
		<script type="text/javascript" src="public/js/index.js"></script>
		<script type="text/javascript" src="public/js/config.js"></script>
	</head>

<body>
	<script type="text/javascript">var coordinate = false;</script>
	<?php 
		if (isset($_REQUEST["sn"])) {
			if (isset($_SESSION ["sn"]) && $_SESSION ["sn"] !== $_REQUEST["sn"]) {
				$controller->logout();
			}
			$_SESSION ["sn"] = $_REQUEST["sn"];
		}
		
		if (!isset($_REQUEST["choose"]) && isset($_SESSION["sn"])) {
			try {
				$currentUser = $controller->getUser ( $_SESSION ["sn"] );
				if ($currentUser->isLogged()) {
					if ($currentUser->isRegistered()) {
						?><script type="text/javascript">
							coordinate = {
				    			coords: {
				    				latitude: <?php echo $currentUser->latitude ?> ,
				    		        longitude: <?php echo $currentUser->longitude ?>,
				    				}
								};
							</script>
						<?php
						} else {
							$paypal_url = $controller->getPayPalUrl();
							}
					} else {
						$loginUrl = $currentUser->loginUrl;
						}
				} catch (Exception $se) {
					$excep->setError($se->getCode(), $se->getMessage());
					}
				}
	?>
	<?php include 'header_.php'; ?>
	
	<?php if ($excep->existProblem) {
		} else {
	?>
				<div class="container">
				<?php if (!isset($_SESSION["sn"]) || isset($_REQUEST["choose"])) { ?>
					<div>
						<div>Sign in with: </div>
						<a href="account_.php?sn=FB"><img src="public/img/facebook.png"></a>
						<a href="account_.php?sn=TW"><img src="public/img/twitter.png"></a>
						<a href="account_.php?sn=PL"><img src="public/img/gplus.png"></a>
					</div>
					<?php } elseif ($currentUser->isLogged()) { ?>
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
								<?php 
									if (DELETE_BTN_ENABLED) {
									?>
										<div><input type="submit" name="delete_button" value="Delete"/></div>
									<?php }	
								} else {
								?>
								<div><textarea name="aboutme" id="aboutme" rows="2" cols="40" maxlength="160" ></textarea></div>
								<?php 
								if (isset($_SESSION["okquiz"]) && $_SESSION["okquiz"] === true) {
								?>
								<input type="submit" name="register_button" value="Free Registration"/>
								<?php 
								} else {
								?>
								<input type="submit" name="register_button" value="" style="background:url(public/img/paypal-button.png) no-repeat;width:180px;height:40px;border: none;"/>
								<?php 
									} 
								} ?>
							<!-- <div><input type="submit" name="logout_button" value="Logout"/></div> -->
						</div>
						<div class="right_col">
							<div class="label">Search Coordinates by Address</div>
							<div><input type="text" id="address" /></div>
							<div class="label">Pick Your Address</div>
				        	<div id="map" style="width: 100%; height: 380px;"></div>
				    	</div>
						</form>
						<?php } else if ($loginUrl !== null) { ?>
							<div style="width:100%; text-align: center;">
								<div><img src="public/img/login_ico.png"></div>
								<div><a href="<?php echo $loginUrl; ?>"><img src="public/img/login_<?php echo $_SESSION ["sn"]; ?>.png"></a></div>
							</div>
						<?php } ?>
				</div>
	
	<?php } include 'footer_.php'; ?>
	<script type="text/javascript" src="public/js/location_choose.js"></script>
</body>

</html>