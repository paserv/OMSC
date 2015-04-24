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
	
	$date = new DateTime();
	$timestamp =  $date->getTimestamp();
	
	if ( !empty($_POST['latitude'])){
		$latitude = $_POST['latitude'];
	}
	if ( !empty($_POST['latitude'])){
		$longitude = $_POST['longitude'];
	}
	
	$controller = new Controller();
	//Controller has to check if already registered
	$user = new DBUser($socialId, $name, $mail, $latitude, $longitude, "Description", $socialPageUrl, $avatarUrl, $timestamp, $socialNetwork);
	$controller->registerUserIntoDB($user);
	//Controller has to check in which fusion table register user
	$controller->registerFakeUserIntoFusionTable($user);

	?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Registration</title>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
</head>
<body>
	<div>
		Registration OK
	</div>
</body>
</html>