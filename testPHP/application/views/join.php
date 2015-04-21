 <?php
	session_start ();
	include_once '../controllers/Controller.php';
	include_once '../dto/SocialUser.php';
	
	$controller = new Controller();
	$socialNetwork = $_SESSION["sn"];
	$currentUser = $controller->getLoggedUser($socialNetwork);
	
	$_SESSION["id"] = $currentUser->socialId;
	$_SESSION["name"] = $currentUser->name;
	$_SESSION["mail"] = $currentUser->email;
	?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Login with your Favourite Social Network</title>
<link href="../../public/css/bootstrap-combined.min.css" rel="stylesheet">
<script type="text/javascript" src="../../public/js/config.js"></script>
<script type="text/javascript">
function getLocation() {
	if (navigator.geolocation) {
    	navigator.geolocation.getCurrentPosition(showPosition, showError, geo_options);
	} else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
	var x = document.getElementById("location");
	x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude; 
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}
</script>
</head>
<body onload="getLocation()">
	<div>
		<ul>
			<li>Image</li>
			<li><img
				src="https://graph.facebook.com/<?php echo $currentUser->socialId; ?>/picture"></li>
			<li>ID</li>
			<li><?php echo $currentUser->socialId; ?></li>
			<li>Fullname</li>
			<li><?php echo $currentUser->name; ?></li>
			<li>Email</li>
			<li><?php echo $currentUser->email; ?></li>
		</ul>
	</div>
	<div id="location"></div>
	<a href="register.php">Register</a>
</body>
</html>