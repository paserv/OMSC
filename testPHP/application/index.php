<html>
<head>
<title>One Million Social Club</title>
<script type="text/javascript" src="../public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../public/js/config.js"></script>
<script type="text/javascript" src="../public/js/index.js"></script>
<link href="../public/css/omsc.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php 
session_start();
if ( !empty($_SESSION['latitude']) && !empty($_SESSION['longitude'])) {
?>
	<script type="text/javascript">var latitude = <?php echo $_SESSION['latitude']; ?>;</script>
	<script type="text/javascript">var longitude = <?php echo $_SESSION['longitude']; ?>;</script>
<?php 
}
?>

	<div class="header">Home</div>

	<div id="map-canvas"></div>
	<a href="views/social_choose.php"><img src="../public/img/join_us.png"></a>
	
</body>
</html>
