<html>
<head>
<title>One Million Social Club</title>
<script type="text/javascript" src="../../public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="../../public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="../../public/js/config.js"></script>
<script type="text/javascript" src="../../public/js/index.js"></script>
<link href="../../public/css/omsc.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php
session_start ();
if (! empty ( $_SESSION ['latitude'] ) && ! empty ( $_SESSION ['longitude'] )) {
	?>
	<script type="text/javascript">var latitude = <?php echo $_SESSION['latitude']; ?>;</script>
	<script type="text/javascript">var longitude = <?php echo $_SESSION['longitude']; ?>;</script>
<?php
}
include 'header.php';
?>

	<div id="map-canvas" class="corpo"></div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
	$( "#sociallogin" ).hide();
	$( "#joinus" ).click(function() {
		$( "#sociallogin" ).toggle("blind", 300);
	});
</script>

</body>
</html>
