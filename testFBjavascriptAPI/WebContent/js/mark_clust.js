var api_parameters = {};

var map;
var markerArray = [];

window.onload = loadScript;

function initialize() {
	var mapOptions = {
			zoom: 8,
			center: {lat: 40.8333333, lng: 14.25},
			mapTypeId: google.maps.MapTypeId.TERRAIN,
			panControl: true,
			zoomControl: true,
			mapTypeControl: true,
			scaleControl: true,
			streetViewControl: true,
			overviewMapControl: true
	};

	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	loadMarkers(map);
	//animateMarkers();
	var mcOptions = {gridSize: 100, maxZoom: 15};
	var markerCluster = new MarkerClusterer(map, markerArray, mcOptions);

}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
	document.body.appendChild(script);
}


function loadMarkers() {
	for (var i = 0; i < 100000; i++) {
		loadMarker(getRandomArbitrary(-85, 85), getRandomArbitrary(-180, 180));
	}
	console.log(markerArray.length);
}

function getRandomArbitrary(min, max) {
	return Math.random() * (max - min) + min;
}


function loadMarker(lat, long) {

	var image = {
			url: 'http://localhost:8093/testFBjavascriptAPI/images/pablo.jpg',
			//size: new google.maps.Size(50, 50),
			origin: new google.maps.Point(0,0),
			anchor: new google.maps.Point(0, 10)
	};

	var marker = new google.maps.Marker({
		map: map,
		position: new google.maps.LatLng(lat, long),
		place: {
			location: {lat: lat, lng: long},
			query: 'Paolo, Servillo, Facebook'
		},
		attribution: {
			source: 'OMSC',
			webUrl: 'http://localhost:8093/testFBjavascriptAPI/goggle.html'
		}
		//icon: image
	});

	//Construct a new InfoWindow.
	var infowindow = new google.maps.InfoWindow({
		content: lat + '_' + long + 'Test <a href="https:www.facebook.com/paolo.servillo.7" target="_blank"> Hello </a>'
	});

	// Opens the InfoWindow when marker is clicked.
	marker.addListener('click', function() {
		infowindow.open(map, marker);
	});
	markerArray.push(marker);
	//marker.setMap(null);
}