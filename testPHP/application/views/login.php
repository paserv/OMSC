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

<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Login with your Favourite Social Network</title>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="../../public/css/omsc.css" rel="stylesheet">
<script type="text/javascript" src="../../public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../../public/js/config.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<script type="text/javascript" src="../../public/js/locationpicker.jquery.min.js"></script>
<script type="text/javascript" src="../../public/js/location_choose.js"></script>
</head>
<body>

<?php include 'header.php'; ?>

	<div id="headerseparator"></div>
	<div class="corpo">
		<div class="wrap">
		<form name="coordinateForm" action="register.php" method="post">
			<div class="left_col">
				<p><img src="https://graph.facebook.com/<?php echo $currentUser->socialId; ?>/picture" /></p>
				<p class="label">Name</p>
				<p><?php echo $currentUser->name; ?></p>
				<p class="label">Email</p>
				<p><?php echo $currentUser->email; ?></p>
				<p class="label">My Coordinates</p>
				<p><b>Latitude</b></p>
				<p><input type="text" name="latitude" id="latitude" readonly/></p>
				<p><b>Longitude</b></p>
				<p><input type="text" name="longitude" id="longitude" readonly/></p>
				<p class="label">Something about me</p>
				<p><textarea name="aboutme" id="aboutme" rows="5" cols="40" maxlength="512" >Write here...</textarea></p>
				<input type="submit" name="submit_button" value="Register"/>
			</div>
			<div class="right_col">
				<p class="label">Search Coordinates by Address</p>
				<p><input type="text" id="address" /></p>
				<p class="label">Pick Your Address</p>
	        	<div id="map" style="width: 100%; height: 500px;"></div>
	    	</div>
			</form>
		</div>
	</div>
<?php include 'footer.php'; ?>
</body>
</html>