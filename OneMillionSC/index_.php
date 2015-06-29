<?php session_start(); 
require_once 'autoload.php';
autoload (); ?>
<!DOCTYPE html>
	<html>
		<head>
			<title>One Million Social Club - Home Page</title>
			<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
			<link type="text/css" rel="stylesheet" href="public/css/jquery-ui.css">
			<link type="text/css" rel="stylesheet" href="public/css/omsc_.css" />
			<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
			<meta property="og:title" content="OMSC">
			<meta property="og:image" content="http://www.aoapao.com/public/img/find.png">
			<meta property="og:site_name" content="One Million Social Club">
			<meta property="og:description" content="Join One Million Social Club">
			<meta property="og:locale" content="en_UK">
			<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
			<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
			<script type="text/javascript" src="public/js/materialize.min.js"></script>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&libraries=places&language=en"></script>
			<script type="text/javascript" src="public/js/index.js"></script>
			<script type="text/javascript" src="public/js/config.js"></script>
		</head>
	
	<body>
		<?php if (! empty ( $_GET['latitude'] ) && ! empty ( $_GET['longitude'] )) {?>
		<script type="text/javascript">var latitude = <?php echo $_GET['latitude']; ?>;</script>
		<script type="text/javascript">var longitude = <?php echo $_GET['longitude']; ?>;</script>
		<?php } if(isset($_GET['searchPlace'])){ ?>
		<script type="text/javascript">var searchPlace = "<?php echo $_GET['searchPlace']; ?>;"</script>
		<?php } ?>
		
		<?php include 'header_.php'; ?>
			<input id="zoom_place" type="text"></input>
			<div id="map-canvas"></div>
		<?php include 'footer_.php'; ?>
			
			
			<script>
			var input_zoom_place = document.getElementById('zoom_place');
			var autocomplete = new google.maps.places.Autocomplete(input_zoom_place);
			$( "#zoom_place" ).keypress(function(e) {
				if (e.keyCode == 13) {
					window.location = "index.php?searchPlace=" + $( "#zoom_place" ).val();
				}
			});
			</script>
	</body>
	
	</html>