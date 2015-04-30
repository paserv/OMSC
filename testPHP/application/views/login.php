 <?php
	session_start ();
	include_once '../controllers/Controller.php';
	include_once '../dto/SocialUser.php';
	
	if(isset($_GET['sn'])){
		$_SESSION['sn'] = $_GET['sn'];
	}
	
	if (isset($_SESSION ["sn"])) {
		$socialNetwork = $_SESSION ["sn"];
	} else {
		header ("Location: ../index.php");
	}
	
	$controller = new Controller ();
	
	try {
		$currentUser = $controller->getLoggedUser ( $socialNetwork );
	} catch (Exception $ex) {
		echo ($socialNetwork . "Login not available at the moment");
	}
	
	$_SESSION ["id"] = $currentUser->socialId;
	$_SESSION ["name"] = $currentUser->name;
	$_SESSION ["mail"] = $currentUser->email;
	$_SESSION ["avatarUrl"] = $currentUser->avatarUrl;
	$_SESSION ["socialPageUrl"] = $currentUser->socialPageUrl;
	?>

<!doctype html>
<head>
<title>Login with your Favourite Social Network</title>
<script type="text/javascript" src="../../public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="../../public/js/config.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript" src="../../public/js/locationpicker.jquery.min.js"></script>
<script type="text/javascript" src="../../public/js/location_choose.js"></script>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="../../public/css/omsc.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

	<div id="headerseparator"></div>
	<div class="corpo">
		<div class="wrap">
		<form name="coordinateForm" action="register.php" method="post">
			<div class="left_col">
				<div><img src="https://graph.facebook.com/<?php echo $currentUser->socialId; ?>/picture" /></div>
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
				<div><textarea name="aboutme" id="aboutme" rows="5" cols="40" maxlength="512" ></textarea></div>
				<div><input type="submit" name="submit_button" value="Register"/></div>
			</div>
			<div class="right_col">
				<div class="label">Search Coordinates by Address</div>
				<div><input type="text" id="address" /></div>
				<div class="label">Pick Your Address</div>
	        	<div id="map" style="width: 100%; height: 380px;"></div>
	    	</div>
			</form>
		</div>
	</div>
<?php include 'footer.php'; ?>
</body>
</html>