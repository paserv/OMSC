 <?php
	session_start ();
	include_once '../controllers/Controller.php';
	include_once '../dto/SocialUser.php';
	
	$socialId = $_SESSION["id"];
	
	$name = $_SESSION["name"];
	$mail = $_SESSION["mail"];
	$socialNetwork = $_SESSION["sn"];
	$avatarUrl = $_SESSION["avatarUrl"];
	$socialPageUrl = $_SESSION["socialPageUrl"];
	
	$timestamp = date("Y-m-d H:i:s");
	
	$latitude = $_POST['latitude'];
	$_SESSION["latitude"] = $latitude;
	$longitude = $_POST['longitude'];
	$_SESSION["longitude"] = $longitude;
	
	$aboutme = "";
	if ( !empty($_POST['aboutme'])){
		$aboutme = $_POST['aboutme'];
	}
	
	$controller = new Controller();
	$user = new DBUser($socialId, $name, $mail, $latitude, $longitude, $aboutme, $socialPageUrl, $avatarUrl, $timestamp, $socialNetwork);
	$message = $controller->register($user);
	?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Registration</title>
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
		<?php echo $message; ?>
	</div>
<?php include 'footer.php'; ?>
</body>
</html>