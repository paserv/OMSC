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
	
	if(isset($_REQUEST['sn'])){
		if ($_SESSION['sn'] !== $_REQUEST['sn']) {
			$controller->logout();
		}
		$_SESSION['sn'] = $_REQUEST['sn'];
	}
	
	if (!isset($_SESSION ["sn"])) {
		die("<script>location.href = 'index.php'</script>");
	}
	
	$currentUser = null;
	$loginUrl = null;
	
	try {
		$currentUser = $controller->getLoggedUser ( $_SESSION ["sn"] );
		if ($currentUser->socialId !== null) {
			if ($_SESSION ["isRegistered"]) {
				$currentUser = $controller->search($currentUser->socialId);
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
			$_SESSION ["error_code"] = $se->getCode();
			$_SESSION ["error_private_msg"] = $se->getMessage();
		}
	?>
</script>
</head>
<body>

<?php include 'header.php'; ?>

	<div id="headerseparator"></div>
	<div class="corpo">
		<div class="wrap">
		<?php if ($currentUser->socialId !== null ) { ?>
		<form name="coordinateForm" action="operation.php" method="post">
			<div class="left_col">
				<div><img src="<?php echo $currentUser->avatarUrl; ?>" /></div>
				<div class="label">Name</div>
				<div><?php echo $currentUser->name; ?></div>
				<div class="label">Email</div>
				<div><?php echo $currentUser->email; ?></div>
				<div class="label">My Coordinates</div>
				<div><b>Latitude</b></div>
				<div><input type="text" name="latitude" id="latitude" readonly/></div>
				<div><b>Longitude</b></div>
				<div><input type="text" name="longitude" id="longitude" readonly/></div>
				<div class="label">Something about me</div>
				<?php 
				if ($_SESSION ["isRegistered"]) {
				?>
				<div><textarea name="aboutme" id="aboutme" rows="2" cols="40" maxlength="160" ><?php echo $currentUser->description; ?></textarea></div>
				<div><input type="submit" name="modify_button" value="Modify"/></div>
				<div><input type="submit" name="delete_button" value="Delete"/></div>
				<!-- <div><input type="submit" name="logout_button" value="Logout"/></div> -->
					<?php	
				} else {
				?>
				<div><textarea name="aboutme" id="aboutme" rows="2" cols="40" maxlength="160" ></textarea></div>
				<input type="submit" name="register_button" value="Register"/>
				<a href="<?php echo $paypal_url ?>">Pay with PayPal</a>
				<?php } ?>
			</div>
			<div class="right_col">
				<div class="label">Search Coordinates by Address</div>
				<div><input type="text" id="address" /></div>
				<div class="label">Pick Your Address</div>
	        	<div id="map" style="width: 100%; height: 380px;"></div>
	    	</div>
			</form>
			<?php } else if ($loginUrl !== null) { ?>
				<div><a href="<?php echo $loginUrl; ?>">Login</a></div>
				<?php } else { ?>
				<div>Something Wrong</div>
				<?php } ?>
		</div>
	</div>
<?php include 'footer.php'; ?>
<script type="text/javascript" src="public/js/location_choose.js"></script>
</body>
</html>