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
	echo $message;
	?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Registration</title>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
</head>
<body>
<a href="../index.php">Home</a>
</body>
</html>