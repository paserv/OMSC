var api_parameters = {};

var map;
var markerArray = [];

window.onload = loadScript;

function initialize() {
  var mapOptions = {
    zoom: 2,
    center: {lat: -34.397, lng: 150.644},
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
  animateMarkers();
  
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
  document.body.appendChild(script);
}




function loadMarkers() {
	for (var i = -50; i < 50; i++) {
		for (var j = -50; j < 50; j++) {
			loadMarker(i, j);
		}
	}
}


function loadMarker(lat, long) {
	var marker = new google.maps.Marker({
	    map: map,
	    place: {
	      location: {lat: lat, lng: long},
	      query: 'Google, Sydney, Australia'
	    },
	    attribution: {
	      source: 'OMSC',
	      webUrl: 'http://localhost:8093/testFBjavascriptAPI/goggle.html'
	    }
	  });

	//Construct a new InfoWindow.
	var infowindow = new google.maps.InfoWindow({
	  content: lat + '_' + long + 'Test <a href="https://www.facebook.com/paolo.servillo.7" target="_blank"> Hello </a>'
	});

	// Opens the InfoWindow when marker is clicked.
	marker.addListener('click', function() {
	  infowindow.open(map, marker);
	});
	markerArray.push(marker);
}

/**
function animateMarkers() {
	for (var i =0; i < markerArray.length; i++) {
		setTimeout(setAnimation(markerArray[i]), i*2000);
	}
}

function setAnimation(marker) {
	marker.setAnimation(google.maps.Animation.DROP);
}
*/