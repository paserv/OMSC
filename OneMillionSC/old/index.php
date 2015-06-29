<?php session_start(); ?>
<!doctype html>
<head>
<title>One Million Social Club - Home Page</title>
<meta property="og:title" content="OMSC">
<meta property="og:image" content="http://www.blitzquotidiano.it/wp/wp/wp-content/uploads/2014/12/servillo.jpg">
<meta property="og:site_name" content="One Million Social Club">
<meta property="og:description" content="Become a member of One Million Social Club in few clicks">
<meta property="og:locale" content="en_UK">
<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.19&libraries=places&language=en"></script>
<script type="text/javascript" src="public/js/index.js"></script>
<script type="text/javascript" src="public/js/config.js"></script>
<link type="text/css" rel="stylesheet" href="public/css/jquery-ui.css">
<link href="public/css/omsc.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="inputSearchPl">
	<input id="searchPlText" type="text"></input>
</div>
<script>
var input = document.getElementById('searchPlText');
var autocomplete = new google.maps.places.Autocomplete(input);
$( "#searchPlText" ).keypress(function(e) {
	if (e.keyCode == 13) {
		window.location = "index.php?searchPlace=" + $( "#searchPlText" ).val();
	}
});
</script>
<?php
require_once 'autoload.php';
autoload ();
if (! empty ( $_GET['latitude'] ) && ! empty ( $_GET['longitude'] )) {
	?>
	<script type="text/javascript">var latitude = <?php echo $_GET['latitude']; ?>;</script>
	<script type="text/javascript">var longitude = <?php echo $_GET['longitude']; ?>;</script>
<?php
}

if(isset($_GET['searchPlace'])){
?>
	<script type="text/javascript">var searchPlace = "<?php echo $_GET['searchPlace']; ?>;"</script>
	<?php
}

if(isset($_GET['searchPerson'])){
?>
	<script type="text/javascript">var searchPerson = "<?php echo $_GET['searchPerson']; ?>;"</script>
	<?php
}

include 'header.php';
?>
		<div id="map-canvas"></div>
<?php include 'footer.php'; ?>

</body>
</html>
