 <?php
	session_start ();
	include_once '../controllers/Controller.php';
	include_once '../dto/SocialUser.php';
	
	$controller = new Controller();
	$fbUser = $controller->getFBLoggedUser();
	?>

<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Login with Facebook</title>
<link
	href="../public/cssbootstrap-combined.min.css" rel="stylesheet">
</head>
<body>
	<div>
		<ul>
			<li>Image</li>
			<li><img
				src="https://graph.facebook.com/<?php echo $fbUser->socialId; ?>/picture"></li>
			<li>Facebook ID</li>
			<li><?php echo $fbUser->socialId; ?></li>
			<li>Facebook fullname</li>
			<li><?php echo $fbUser->name; ?></li>
			<li>Facebook Email</li>
			<li><?php echo $fbUser->email; ?></li>
		</ul>
	</div>
</body>
</html>