<!doctype html>
<head>
	<link type="text/css" rel="stylesheet" href="public/css/materialize.min.css"  media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="public/css/jquery-ui.css">
	<script type="text/javascript" src="public/js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="public/js/jquery-ui-1.11.4.js"></script>
	<script type="text/javascript" src="public/js/materialize.min.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.19&libraries=places&language=en"></script>
</head>
<body>
<nav>
		<div class="nav-wrapper blue darken-3">
			<ul class="left hide-on-med-and-down">
				<li><a class="waves-effect waves-light" href="index_.php"><i class="mdi-social-public"></i></a></li>
				<li><a class="waves-effect waves-light modal-trigger" href="#modal1"><i class="mdi-action-search"></i></a></li>
				<li><a class="waves-effect waves-light" href="account_.php?choose=yes"><i class="mdi-social-person-add"></i></a></li>
			</ul>
		</div>
	</nav>
	<input id="searchPlText" type="text"></input>
	<script>
	var input = document.getElementById('searchPlText');
	var autocomplete = new google.maps.places.Autocomplete(input);
	$( "#searchPlText" ).keypress(function(e) {
		if (e.keyCode == 13) {
			window.location = "index.php?searchPlace=" + $( "#searchPlText" ).val();
		}
	});
	</script>
</body>
</html>
