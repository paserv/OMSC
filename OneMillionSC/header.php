<?php 
	if (!isset($_SESSION ["total_users"])) { 
		$controller = new Controller(); 
		$total = $controller->countMembers(); 
	}
?>
	<ul id="dropdown1" class="dropdown-content">
	<?php if (isset($_SESSION ["latitude"]) && $_SESSION ["latitude"] != null) { ?>
	  <li><a href="account.php?sn=<?php echo $_SESSION ["sn"] ?>">My Account</a></li>
	  <li class="divider"></li>
	  <li><a href="operation.php?logout_button=Logout">Logout</a></li>
	<?php } else if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) {?>
	  <li><a href="account.php?sn=<?php echo $_SESSION ["sn"] ?>">Register</a></li>
	  <li class="divider"></li>
	  <li><a href="operation.php?logout_button=Logout">Logout</a></li>
	<?php } else {?>
	  <li class="blue-text text-darken-4">Sign In With:</li>
	  <li class="divider"></li>
	  <li><a href="account.php?sn=FB"><img src="public/img/FB_pic.png" /></a></li>
	  <li><a href="account.php?sn=TW"><img src="public/img/TW_pic.png"></a></li>
	  <li><a href="account.php?sn=PL"><img src="public/img/PL_pic.png"></a></li>
	<?php } ?>
	</ul>
	<div class="navbar-fixed">
	<nav>
		<div class="nav-wrapper blue darken-3">
			<ul class="left hide-on-med-and-down">
				<li><a class="waves-effect waves-light" href="index.php"><i class="mdi-social-public"></i></a></li>
				<li><a class="waves-effect waves-light modal-trigger" href="#modal1"><i class="mdi-action-search"></i></a></li>
				<li><a class="waves-effect waves-light" href="account.php?choose=yes"><i class="mdi-social-person-add"></i></a></li>
				<?php if (IS_QUIZ_ENABLED) { ?>
					<li><a class="waves-effect waves-light" href="quiz.php"><i class="mdi-communication-live-help"></i></a></li>
				<?php } ?>
			</ul>
			<ul class="right hide-on-med-and-down">
			<?php if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) { ?>
		  		<li><img class="header-img" src="<?php echo $_SESSION ["avatarUrl"]; ?>" /></li>
			<?php } else { ?>
		  		<li><img class="header-img" src="public/img/anonym_user.png" /></li>
			<?php } ?>
				<li><a class="dropdown-button" href="#" data-activates="dropdown1"><i class="material-icons right">more_vert</i></a></li>
			</ul>
			
			<ul id="slide-out" class="side-nav">
			    <li class="no-padding">
			      <ul class="collapsible collapsible-accordion">
			        <li>
			        	<a class="collapsible-header"><i class="mdi-navigation-arrow-drop-down"></i></a>
				        <?php if (isset($_SESSION ["latitude"]) && $_SESSION ["latitude"] != null) { ?>
				  		<img class="header-img" src="<?php echo $_SESSION ["avatarUrl"]; ?>" />
				  		<div class="collapsible-body">
				            <ul>
				              <li><a href="account.php?sn=<?php echo $_SESSION ["sn"] ?>">My Account</a></li>
				              <li><a href="operation.php?logout_button=Logout">Logout</a></li>
				            </ul>
				          </div>
						<?php } else if (isset($_SESSION ["isLogged"]) && $_SESSION ["isLogged"] == true) { ?>
					  	<img class="header-img" src="<?php echo $_SESSION ["avatarUrl"]; ?>" />
				  		<div class="collapsible-body">
				            <ul>
				              <li><a href="account.php?sn=<?php echo $_SESSION ["sn"] ?>">Register</a></li>
							  <li><a href="operation.php?logout_button=Logout">Logout</a></li>
				            </ul>
				          </div>
						<?php } else { ?>
							<img class="header-img" src="public/img/anonym_user.png" />
							<div class="collapsible-body">
					            <ul>
					              <li class="blue-text text-darken-4">Sign In With:</li>
								  <li class="divider"></li>
								  <li><a href="account.php?sn=FB"><img src="public/img/FB_pic.png" /> Facebook</a></li>
								  <li><a href="account.php?sn=TW"><img src="public/img/TW_pic.png"> Twitter</a></li>
								  <li><a href="account.php?sn=PL"><img src="public/img/PL_pic.png"> Google Plus</a></li>
					            </ul>
					          </div>
						<?php } ?>
			        </li>
			      </ul>
			    </li>
				 
				<li class="divider"></li>
		    	<li><a class="waves-effect waves-light" href="index.php"><i class="mdi-social-public">Home</i></a></li>
				<li><a class="waves-effect waves-light modal-trigger" href="#modal1"><i class="mdi-action-search">Search</i></a></li>
				<li><a class="waves-effect waves-light" href="account.php?choose=yes"><i class="mdi-social-person-add">Sign In</i></a></li>
				<?php if (IS_QUIZ_ENABLED) { ?>
					<li><a class="waves-effect waves-light" href="quiz.php"><i class="mdi-communication-live-help">Quiz</i></a></li>
				<?php } ?>
				</ul>
			<a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
		</div>
	</nav>
</div>

<div id="modal1" class="modal">
    <div class="modal-content">
		<h4>Find people</h4>
		<div class="input-field col s6">
          <i class="mdi-action-account-circle prefix"></i>
          <input id="search_name" type="text" class="validate" placeholder="Enter a name">
        </div>
        <div class="input-field col s6">
          <i class="mdi-maps-map prefix"></i>
          <input id="search_place" type="text" class="validate">
        </div>
        <p class="range-field">
        	<i id="icon_slide_bar" class="mdi-device-location-searching prefix"></i>
        	<label id="label_slide_bar" for="slide_bar">Ray (Km)</label>
      		<input id="slide_bar" class="blue darken-3" type="range" id="test5" min="0" max="100" value="50"/>
   		</p>
    </div>
	<div class="modal-footer">
		<button id = "findBtn" class="btn blue darken-3 waves-effect waves-light" type="submit" name="action">Search
			<i class="mdi-content-send right"></i>
		</button>
		<a href="#!" class=" modal-action modal-close waves-effect waves-blue btn-flat">Cancel</a>
	</div>
</div>
<script>
$(document).ready(function(){
    $('.modal-trigger').leanModal();
    $(".dropdown-button").dropdown();
  });

$(".button-collapse").sideNav({
    closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
  }
);

$('.collapsible').collapsible();

var input_search_place = document.getElementById('search_place');
var autocomplete = new google.maps.places.Autocomplete(input_search_place);

$( "#icon_slide_bar" ).hide();
$( "#label_slide_bar" ).hide();
$( "#slide_bar" ).hide();

$('#search_place').bind('change', function() {
	if ($('#search_place').val() === '' || typeof $('#search_place').val() === 'undefined') {
		$( "#icon_slide_bar" ).hide();
		$( "#label_slide_bar" ).hide();
		$( "#slide_bar" ).hide();
	} else {
		$( "#icon_slide_bar" ).show();
		$( "#label_slide_bar" ).show();
		$( "#slide_bar" ).show();
	}
});

$( "#findBtn" ).click(function() {
	var queryString;
	var ray = $( "#slide_bar" ).val();
	if ($( "#search_place" ).val() !== '' && $( "#search_name" ).val() !== '') {
		var lat;
		var lng;
		var geocoder = new google.maps.Geocoder();
	    geocoder.geocode({
	      address: $( "#search_place" ).val()
	    }, function(results, status) {
		  var res = results;
		  var st = status;
	      if (status == google.maps.GeocoderStatus.OK) {
	    	geom = results[0].geometry;
	    	lat = geom.location.lat();
	    	lng = geom.location.lng();
	    	queryString = "?name=" + $( "#search_name" ).val() + "&lat=" + lat + "&lng=" + lng + "&ray=" + ray;
			window.location = "search.php" + queryString;
	      } else {
	    	  window.alert('Address could not be geocoded: ' + status);
		      }
	    });
		} else if ($( "#search_place" ).val() !== '') {
		var lat;
		var lng;
		var geocoder = new google.maps.Geocoder();
	    geocoder.geocode({
	      address: $( "#search_place" ).val()
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
	} else if ($( "#search_name" ).val() !== '') {
		queryString = "?name=" + $( "#search_name" ).val();
		window.location = "search.php" + queryString;
		} else {
			window.location = "search.php";
			}
});
</script>