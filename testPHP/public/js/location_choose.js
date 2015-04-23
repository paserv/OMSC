window.onload = loadScript;

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'http://maps.google.com/maps/api/js?sensor=false&libraries=places';
	document.body.appendChild(script);
	
	var script2 = document.createElement('script');
	script2.type = 'text/javascript';
	script2.src = '../../public/js/locationpicker.jquery.min.js';
	document.body.appendChild(script2);
	
	initialize();
}

function initialize() {
	var x = document.getElementById("location");
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(drawMap, drawMapNoPosition, geo_options);
	} else {
		x.innerHTML = "Geolocation is not supported by this browser.";
	}
}

function drawMap(pos) {
	$('#map').locationpicker({
		location: {latitude: pos.coords.latitude, longitude: pos.coords.longitude},	
		radius: 10,
		inputBinding: {
	        latitudeInput: $('#latitude'),
	        longitudeInput: $('#longitude'),
	        locationNameInput: $('#address')
	    }
		});
}


function drawMapNoPosition() {
	drawMap(map_options.default_position);
};

function drawMap2(pos) {
	myPosition = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
	
	var markers = [];
	var map = new google.maps.Map(document.getElementById('map-canvas'), {
		center: myPosition,
		zoom: map_options.zoom
	});

	// Create the search box and link it to the UI element.
	var input = /** @type {HTMLInputElement} */(
			document.getElementById('pac-input'));
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	var searchBox = new google.maps.places.SearchBox(
			/** @type {HTMLInputElement} */(input));

	// [START region_getplaces]
	// Listen for the event fired when the user selects an item from the
	// pick list. Retrieve the matching places for that item.
	google.maps.event.addListener(searchBox, 'places_changed', function() {
		var places = searchBox.getPlaces();

		if (places.length == 0) {
			return;
		}
		for (var i = 0, marker; marker = markers[i]; i++) {
			marker.setMap(null);
		}

		// For each place, get the icon, place name, and location.
		markers = [];
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0, place; place = places[i]; i++) {
			var image = {
					url: place.icon,
					size: new google.maps.Size(71, 71),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(17, 34),
					scaledSize: new google.maps.Size(25, 25)
			};

			// Create a marker for each place.
			var marker = new google.maps.Marker({
				map: map,
				icon: image,
				title: place.name,
				position: place.geometry.location
			});

			markers.push(marker);

			bounds.extend(place.geometry.location);
		}

		map.fitBounds(bounds);
	});
	// [END region_getplaces]

	// Bias the SearchBox results towards places that are within the bounds of the
	// current map's viewport.
	google.maps.event.addListener(map, 'bounds_changed', function() {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
	});
}


function showPosition(position) {
	var x = document.getElementById("location");
	x.innerHTML = "Latitude: " + position.coords.latitude + 
	"<br>Longitude: " + position.coords.longitude; 
}

function showError(error) {
	switch(error.code) {
	case error.PERMISSION_DENIED:
		x.innerHTML = "User denied the request for Geolocation.";
		break;
	case error.POSITION_UNAVAILABLE:
		x.innerHTML = "Location information is unavailable.";
		break;
	case error.TIMEOUT:
		x.innerHTML = "The request to get user location timed out.";
		break;
	case error.UNKNOWN_ERROR:
		x.innerHTML = "An unknown error occurred.";
		break;
	}
}

