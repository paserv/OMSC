<div id="header">
	<div class="menuButton" id="joinus"><a><img src="public/img/joinus.png"></a></div>
	<div class="menuButton"><a href="index.php"><img src="public/img/home.png"></a></div>
	<div class="menuButton" id="searchPlBtn"><a><img src="public/img/searchPlace.png"></a></div>
	<div class="menuButton" id="searchPerBtn"><a><img src="public/img/searchPerson.png"></a></div>
</div>
<div id="inputSearchPl">
	<input id="searchPlText" type="text"></input>
</div>
<div id="inputSearchPer">
	<input id="searchPerText" type="text"></input>
</div>
<div id="sociallogin">
	<p>
		<a href="login.php?sn=FB"><img src="public/img/facebook.png"></a>
	</p>
	<p>
		<a href="login.php?sn=TW"><img src="public/img/twitter.png"></a>
	</p>
	<p>
		<a href="login.php?sn=PL"><img src="public/img/gplus.png"></a>
	</p>
</div>

<script type="text/javascript">
	$( "#sociallogin" ).hide();
	$( "#joinus" ).click(function() {
		$( "#sociallogin" ).toggle("blind", 300);
	});

	$( "#inputSearchPl" ).hide();
	$( "#searchPlBtn" ).click(function() {
		$( "#inputSearchPer" ).hide();
		$( "#inputSearchPl" ).toggle("blind", 100);
	});

	$( "#inputSearchPer" ).hide();
	$( "#searchPerBtn" ).click(function() {
		$( "#inputSearchPl" ).hide();
		$( "#inputSearchPer" ).toggle("blind", 100);
	});

	var input = document.getElementById('searchPlText');
	var autocomplete = new google.maps.places.Autocomplete(input);
	$( "#searchPlText" ).keypress(function(e) {
		if (e.keyCode == 13) {
			window.location = "index.php?searchPlace=" + $( "#searchPlText" ).val();
		}
	});

	$( "#searchPerText" ).keypress(function(e) {
		if (e.keyCode == 13) {
			window.location = "search.php?query=" + $( "#searchPerText" ).val();
		}
	});

	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			$( "#sociallogin" ).hide();
			$( "#inputSearchPl" ).hide();
			$( "#inputSearchPer" ).hide();
		}
	});
</script>