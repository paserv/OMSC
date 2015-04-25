<?php
	session_start ();
	if(isset($_GET['sn'])){
		$_SESSION['sn']=$_GET['sn'];
		header ( "Location: " . "login.php" );
	}
	?>
<html>
<head>
<title>Join the One Million Social Club</title>
</head>
<body>

 	<a href="login.php?sn=FB"><img src="../../public/img/facebook.png"></a>
 	<a href="login.php?sn=TW"><img src="../../public/img/twitter.png"></a>
 	<a href="login.php?sn=PL"><img src="../../public/img/gplus.png"></a>
 	<a href="login.php?sn=LI"><img src="../../public/img/linkedin.png"></a>
 	<a href="login.php?sn=PI"><img src="../../public/img/pinterest.png"></a>
 	<a href="login.php?sn=TU"><img src="../../public/img/tumblr.png"></a>
 	<a href="login.php?sn=YT"><img src="../../public/img/youtube.png"></a>
 	<a href="login.php?sn=IN"><img src="../../public/img/instagram.png"></a>
 
 	
 </body>
</html>
