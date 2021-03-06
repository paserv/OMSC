<?php 
	if (!isset($_SESSION ["total_users"])) { 
		$controller = new Controller(); 
		$total = $controller->countMembers(); 
	}
?>
<div id="header">
	<div class="wrap">
		<div class="left_col">
			<div class="menuButton"><a href="index.php"><img src="public/img/home.png"></a></div>
			<div class="menuButton" id="searchPerBtn"><a><img src="public/img/searchPerson.png"></a></div>
			<div class="menuButton"><a href="account.php?choose=yes"><img src="public/img/map.png"></a></div>
			<?php if (IS_QUIZ_ENABLED) {
				echo "<div class='menuButton'><a href='quiz.php'><img src='public/img/quiz.png'></a></div>";
			} ?>
			<!-- <div class="menuButton" id="joinus"><a><img src="public/img/joinus.png"></a></div> -->
		</div>
		<div class="right_col">
				<?php 
				if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) {
					echo $_SESSION ["name"] . "&nbsp<img style='border:2px solid white;vertical-align:middle' src=" . $_SESSION ["avatarUrl"] . ">";
				} else {
					echo "<img style='vertical-align:middle' src='public/img/anonym_user.png'>";
					}
				?>
				<a href="#" onMouseOver="return changeImageRow()" onMouseOut= "return changeImageBackRow()" onMouseDown="return handleMDownRow()" onMouseUp="return handleMUpRow()"><div id = "rowBtn"><img style="vertical-align:top" name="rowButton" src="public/img/row.png"></div></a>
				<p>
					<div id="userMenu" style="display: none;" >
							<?php if (isset($_SESSION ["latitude"]) && $_SESSION ["latitude"] != null) { ?>
								<p><a href="account.php?sn=<?php echo $_SESSION ["sn"] ?>">My Profile</a></p>
								<p><a href="operation.php?logout_button=Logout">Logout</a></p>
							<?php } else if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) {?>
								<p><a href="account.php?sn=<?php echo $_SESSION ["sn"] ?>">Register</a></p>
								<p><a href="operation.php?logout_button=Logout">Logout</a></p>
							<?php } else {?>
								Sign In With: 
								<a href="account.php?sn=FB"><img src="public/img/FB_pic.png"></a>
								<a href="account.php?sn=TW"><img src="public/img/TW_pic.png"></a>
								<a href="account.php?sn=PL"><img src="public/img/PL_pic.png"></a>
							<?php } ?>
					</div>
				</p>
		</div>
	</div>
	
</div>
<div id="inputSearchPer" style="display: none;" >
	<p>Find people</p>
	<p><input id="nameInput" type="text" placeholder="Enter a name"></input></p>
	<p><input id="searchPerLoc" type="text"></input></p>
	<p>
		<label id="labelkm" for="kilometers">Ray (Km): </label>
		<input type="text" id="kilometers" readonly style="border:0; color:#8E9FE2; font-weight:bold; width: 30px; line-height: 1.5; font-family: sans-serif;">
	</p>
	<div id="slider" style="width:80%; margin-left:auto; margin-right:auto;"></div>
	<p><a href="#" onMouseOver="return changeImageFindBtn()" onMouseOut= "return changeImageBackFindBtn()" onMouseDown="return handleMDownFindBtn()" onMouseUp="return handleMUpFindBtn()"><div id = "findBtn"><img name="findButton" src="public/img/find.png"></div></a></p>
</div>

<!-- 
<div id="sociallogin" style="display: none;" >
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
 -->


<script type="text/javascript">
	$( "#sociallogin" ).hide();
	$( "#userMenu" ).hide();
	$( "#inputSearchPer" ).hide();
	$( "#slider" ).hide();
	$( "#kilometers" ).hide();
	$( "#labelkm" ).hide();

	$(function() {
	    $( "#slider" ).slider({
	      orientation: "horizontal",
	      range: "min",
	      min: 0,
	      max: 100,
	      value: 50,
	      slide: function( event, ui ) {
	        $( "#kilometers" ).val( ui.value );
	      }
	    });
	    $( "#kilometers" ).val( $( "#slider" ).slider( "value" ) );
	  });
	  
	var input = document.getElementById('searchPerLoc');
	var autocomplete = new google.maps.places.Autocomplete(input);

	$('#searchPerLoc').bind('input', function() {
		if (input.value === '') {
			$( "#slider" ).hide();
			$( "#kilometers" ).hide();
			$( "#labelkm" ).hide();
		} else {
			$( "#kilometers" ).show();
			$( "#labelkm" ).show();
			$( "#slider" ).show();
		}
	});
	
// 	google.maps.event.addListener(autocomplete, 'place_changed', function() {
// 		$( "#kilometers" ).show();
// 		$( "#labelkm" ).show();
// 		$( "#slider" ).show();
// 		});
// 	$( "#searchPerLoc" ).keypress(function(e) {
// 		if (e.keyCode == 13) {
// 			window.location = "search.php?searchPlace=" + $( "#searchPlText" ).val();
// 		}
// 	});

	$( "#findBtn" ).click(function() {
		var queryString;
		var ray = $( "#kilometers" ).val();
		if ($( "#searchPerLoc" ).val() !== '' && $( "#nameInput" ).val() !== '') {
			var lat;
			var lng;
			var geocoder = new google.maps.Geocoder();
		    geocoder.geocode({
		      address: $( "#searchPerLoc" ).val()
		    }, function(results, status) {
			  var res = results;
			  var st = status;
		      if (status == google.maps.GeocoderStatus.OK) {
		    	geom = results[0].geometry;
		    	lat = geom.location.lat();
		    	lng = geom.location.lng();
		    	queryString = "?name=" + $( "#nameInput" ).val() + "&lat=" + lat + "&lng=" + lng + "&ray=" + ray;
				window.location = "search.php" + queryString;
		      } else {
		    	  window.alert('Address could not be geocoded: ' + status);
			      }
		    });
			} else if ($( "#searchPerLoc" ).val() !== '') {
			var lat;
			var lng;
			var geocoder = new google.maps.Geocoder();
		    geocoder.geocode({
		      address: $( "#searchPerLoc" ).val()
		    }, function(results, status) {
			  var res = results;
			  var st = status;
		      if (status == google.maps.GeocoderStatus.OK) {
		    	geom = results[0].geometry;
		    	lat = geom.location.lat();
		    	lng = geom.location.lng();
		    	queryString = "?lat=" + lat + "&lng=" + lng + "&ray=" + ray;
		    	window.location = "search.php" + queryString;
		      } else {
		    	  window.alert('Address could not be geocoded: ' + status);
			      }
		    });
		} else if ($( "#nameInput" ).val() !== '') {
			queryString = "?name=" + $( "#nameInput" ).val();
			window.location = "search.php" + queryString;
			} else {
				window.location = "search.php";
				}
	});

	$( "#rowBtn" ).click(function() {
		$( "#sociallogin" ).hide();
		$( "#inputSearchPer" ).hide();
		$( "#userMenu" ).toggle("blind", 100);
		});
	
	$( "#joinus" ).click(function() {
		$( "#inputSearchPer" ).hide();
		$( "#userMenu" ).hide();
		$( "#sociallogin" ).toggle("blind", 300);
	});

	
	$( "#searchPerBtn" ).click(function() {
		//$( "#inputSearchPl" ).hide();
		$( "#sociallogin" ).hide();
		$( "#userMenu" ).hide();
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
			$( "#userMenu" ).hide();
		}
	});



	function changeImageFindBtn() {
	document.images["findButton"].src= "public/img/find_mo.png";
	return true;
	}
	function changeImageBackFindBtn() {
	 document.images["findButton"].src = "public/img/find.png";
	 return true;
	}
	function handleMDownFindBtn() {
	 document.images["findButton"].src = "public/img/find_md.png";
	 return true;
	}
	function handleMUpFindBtn() {
	 changeImageFindBtn();
	 return true;
	}

	function changeImageRow() {
		document.images["rowButton"].src= "public/img/row_mo.png";
		return true;
		}
		function changeImageBackRow() {
		 document.images["rowButton"].src = "public/img/row.png";
		 return true;
		}
		function handleMDownRow() {
		 document.images["rowButton"].src = "public/img/row_md.png";
		 return true;
		}
		function handleMUpRow() {
		 changeImageRow();
		 return true;
		}
</script>