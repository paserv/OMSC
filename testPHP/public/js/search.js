window.onload = loadScript;

function loadScript() {
	var mapApi = document.createElement('script');
	mapApi.type = 'text/javascript';
	mapApi.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
	document.body.appendChild(mapApi);
}

function initialize() {
	var bounds = new google.maps.LatLngBounds();
	var mapOptions = { mapTypeId: google.maps.MapTypeId.ROADMAP };
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	
	addMarkers(map, bounds);
	
	map.fitBounds(bounds);
    map.panToBounds(bounds); 
	
}

function addMarker(location, name, active, map) {       
    var marker = new google.maps.Marker({
        position: location,
        map: map,
        title: name,
        status: active
    });
}



