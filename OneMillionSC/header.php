<div id="header">
	<div class="menuButton"><a href="index.php"><img src="public/img/home.png"></a></div>
	<div class="menuButton" id="searchPerBtn"><a><img src="public/img/searchPerson.png"></a></div>
	<div class="menuButton" id="joinus"><a><img src="public/img/joinus.png"></a></div>
</div>
<input id="lat" type="text" style="display: none;"></input>
<input id="lng" type="text" style="display: none;"></input>
<div id="inputSearchPer">
	<p>Find people</p>
	<p><input id="nameInput" type="text" placeholder="Enter a name"></input></p>
	<p><input id="searchPerLoc" type="text"></input></p>
	<p><a href="#" onMouseOver="return changeImage()" onMouseOut= "return changeImageBack()" onMouseDown="return handleMDown()" onMouseUp="return handleMUp()"><div id = "findBtn"><img name="findButton" src="public/img/find.png"></div></a></p>
</div>
<div id="sociallogin">
	<p>
		<a href="account.php?sn=FB"><img src="public/img/facebook.png"></a>
	</p>
	<p>
		<a href="account.php?sn=TW"><img src="public/img/twitter.png"></a>
	</p>
	<p>
		<a href="account.php?sn=PL"><img src="public/img/gplus.png"></a>
	</p>
</div>

<script type="text/javascript">
	$( "#sociallogin" ).hide();
	$( "#inputSearchPer" ).hide();

	var input = document.getElementById('searchPerLoc');
	var autocomplete = new google.maps.places.Autocomplete(input);
// 	$( "#searchPerLoc" ).keypress(function(e) {
// 		if (e.keyCode == 13) {
// 			window.location = "search.php?searchPlace=" + $( "#searchPlText" ).val();
// 		}
// 	});

	$( "#findBtn" ).click(function() {

		var queryString = "?";
		if ($( "#searchPerLoc" ).val().lenght > 0) {
			var lat;
			var lng;
			var geocoder = new google.maps.Geocoder();
		    geocoder.geocode({
		      address: $( "#searchPerLoc" ).val()
		    }, function(results, status) {
		      if (status == google.maps.GeocoderStatus.OK) {
		    	geom = results[0].geometry;
		    	lat = geom.location.lat();
		    	lng = geom.location.lng();
		    	queryString = queryString + "lat=" + lat + "&lng=" + lng + "&";
		      } else {
		    	  window.alert('Address could not be geocoded: ' + status);
			      }
		    });
		}
		if (!$( "#nameInput" ).val()) {
			queryString = queryString + "name=" + $( "#nameInput" ).val();
			}
		window.location = "search.php" + queryString;
	});

	
	$( "#joinus" ).click(function() {
		$( "#sociallogin" ).toggle("blind", 300);
		$( "#inputSearchPer" ).hide();
	});

// 	$( "#searchPlBtn" ).click(function() {
// 		$( "#inputSearchPer" ).hide();
// 	});

	
	$( "#searchPerBtn" ).click(function() {
		//$( "#inputSearchPl" ).hide();
		$( "#sociallogin" ).hide();
		$( "#inputSearchPer" ).toggle("blind", 100);
	});

// 	$( "#searchPerText" ).keypress(function(e) {
// 		if (e.keyCode == 13) {
// 			window.location = "search.php?name=" + $( "#nameInput" ).val() + "&lat=" + "&lng=";
// 		}
// 	});

	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			$( "#sociallogin" ).hide();
			$( "#inputSearchPer" ).hide();
		}
	});



	function changeImage() {
	document.images["findButton"].src= "public/img/find_mo.png";
	return true;
	}
	function changeImageBack() {
	 document.images["findButton"].src = "public/img/find.png";
	 return true;
	}
	function handleMDown() {
	 document.images["findButton"].src = "public/img/find_md.png";
	 return true;
	}
	function handleMUp() {
	 changeImage();
	 return true;
	}
</script>