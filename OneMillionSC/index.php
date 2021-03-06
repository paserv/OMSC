<?php session_start(); 
require_once 'autoload.php';
autoload ();
$excep = new CustomException();
?>
<!DOCTYPE html>
	<html>
		<head>
			<title>One Million Social Club - Home Page</title>
			<link rel="icon" href="favicon.ico" />
			<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
			<link type="text/css" rel="stylesheet" href="public/css/jquery-ui.css">
			<link type="text/css" rel="stylesheet" href="public/css/omsc.css" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
			<meta property="og:title" content="OMSC">
			<meta property="og:image" content="http://www.aoapao.com/public/img/ico.png">
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
		<?php include_once("analyticstracking.php") ?>
		<?php if (! empty ( $_REQUEST['latitude'] ) && ! empty ( $_REQUEST['longitude'] )) {?>
		<script type="text/javascript">var latitude = <?php echo $_REQUEST['latitude']; ?>;</script>
		<script type="text/javascript">var longitude = <?php echo $_REQUEST['longitude']; ?>;</script>
		<?php } if(isset($_REQUEST['searchPlace'])){ ?>
		<script type="text/javascript">var searchPlace = "<?php echo $_REQUEST['searchPlace']; ?>;"</script>
		<?php } ?>
		
		<?php include 'header.php'; if ($excep->existProblem) { include 'error.php'; } else { ?>
			<input id="zoom_place" type="text"></input>
			<div id="map-canvas"></div>
		<?php } include 'footer.php'; ?>
			
			
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