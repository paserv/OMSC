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
	var loc;
	for (var i = 0; i < markers.length; i++) {
		curr = markers[i];
		addMarker(curr, bounds, map);
	}
	map.fitBounds(bounds);
    map.panToBounds(bounds); 
}

function addMarker(mark, bounds, map) {
	loc = new google.maps.LatLng(mark.latitude, mark.longitude);
	bounds.extend(loc);
	
	var contentString = 
	'<div class="wrap">' + 
		'<div class="left_col">'+
			'<div><a href="' + mark.socialPageUrl + '" target="_blank"><img src="' + mark.avatarUrl + '" /></a></div>' +
			'<div><img src="../../public/img/' + mark.socialNetwork + '_pic.png" /></div>' +
		'</div>' +
		'<div class="right_col">'+
			'<div>Name: ' + mark.name + '</div>' +
			'<div>About me: ' + mark.description + '</div>' +
		'</div>' +
	'</div>';
	
	var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 400
	});
	
	var image = {
		    url: mark.avatarUrl,
		    size: new google.maps.Size(50, 50),
		    origin: new google.maps.Point(0,0),
		    anchor: new google.maps.Point(0, 50)
	};
	
    var marker = new google.maps.Marker({
        position: loc,
        map: map,
        title: mark.name,
        status: "active",
        icon: image
    });
    
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
      });
}



