<?php session_start(); ?>
 
<?php
	require_once 'autoload.php';
	operation_autoload();
	
	$_SESSION ["error_code"] = false;
	
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
	
	$user = new DBUser($socialId, $name, $mail, $latitude, $longitude, $aboutme, $socialPageUrl, $avatarUrl, $timestamp, $socialNetwork);
	$controller = new Controller();
	
	try {
		if (isset($_POST['delete_button'])) {
		    $controller->delete($user);
		} else if (isset($_POST['modify_button'])) {
		    $controller->update($user);
		} else if (isset($_POST['register_button'])){
		    $message = $controller->register($user);
		}
	} catch (Exception $e) {
		$_SESSION ["error_code"] = $e->getCode();
	}
?>

<!doctype html>
<head>
<title>One Million Social Club - Registration</title>
<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="public/js/config.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link href="public/css/bootstrap-combined.min.css" rel="stylesheet">
<link href="public/css/omsc.css" rel="stylesheet">
</head>
<body>
<?php
include 'header.php'; 
if ($_SESSION ["error_code"]) {
	include 'error.php';
} else {
$controller = new Controller();
$users = $controller->count();
$_SESSION ["users_count"] = $users;
?>
	<div id="headerseparator"></div>
	<br>
	<br>
	<div class="corpo">
	<br>
	<br>
	<br>
	<br>
	Operation Success!
	<div><a href="index.php<?php echo "?latitude=" . $_SESSION["latitude"] . "&longitude=" . $_SESSION["longitude"] ?>">Come Back Home</a></div>
	</div>
<?php 
} 
include 'footer.php'; ?>
</body>
</html>