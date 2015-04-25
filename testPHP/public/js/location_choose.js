window.onload = initialize();;

function initialize() {
	var x = document.getElementById("location");
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(drawMap, drawMapNoPosition, geo_options);
	} else {
		x.innerHTML = "Geolocation is not supported by this browser. Pick Location Manually";
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
	    },
	    enableAutocomplete: true,
		});
}


function drawMapNoPosition() {
	drawMap(map_options.default_position);
};


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

