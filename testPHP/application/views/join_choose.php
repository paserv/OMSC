<?php
	session_start ();
	if(isset($_GET['sn'])){
		$_SESSION['sn']=$_GET['sn'];
		header ( "Location: " . "join.php" );
	}
	?>
<html>
<head>
<title>Join the One Million Social Club</title>
<script type="text/javascript" src="../public/js/fusion.js"></script>
<script type="text/javascript" src="../public/js/config.js"></script>
<script type="text/javascript" src="../public/js/jquery-2.1.3.min.js"></script>
<link href="../public/css/omsc.css" rel="stylesheet" type="text/css">
</head>
<body>

 	<a href="join_choose.php?sn=FB"><img src="../../public/img/facebook.png"></a>
 	<a href="join_choose.php?sn=TW"><img src="../../public/img/twitter.png"></a>
 	<a href="join_choose.php?sn=PL"><img src="../../public/img/gplus.png"></a>
 	<a href="join_choose.php?sn=LI"><img src="../../public/img/linkedin.png"></a>
 	<a href="join_choose.php?sn=PI"><img src="../../public/img/pinterest.png"></a>
 	<a href="join_choose.php?sn=TU"><img src="../../public/img/tumblr.png"></a>
 	<a href="join_choose.php?sn=YT"><img src="../../public/img/youtube.png"></a>
 	<a href="join_choose.php?sn=IN"><img src="../../public/img/instagram.png"></a>
 
 	
 </body>
</html>
