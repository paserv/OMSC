window.onload = loadScript;
var geom = null;

var input = document.getElementById('zoom_place');
var autocomplete = new google.maps.places.Autocomplete(input);

$( "#zoom_place" ).keypress(function(e) {
	if (e.keyCode == 13) {
		window.location = "index.php?searchPlace=" + $( "#zoom_place" ).val();
	}
});

function loadScript() {
	var mapApi = document.createElement('script');
	mapApi.type = 'text/javascript';
	mapApi.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
	document.body.appendChild(mapApi);
}

function initialize() {
	var registeredPos;
	var vieport;
	 var boundingBoxPoints;
	if (typeof searchPlace !== 'undefined') {
		var geocoder = new google.maps.Geocoder();
	    geocoder.geocode({
	      address: searchPlace
	    }, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	    	geom = results[0].geometry;
	    	registeredPos = {
	    			coords: {
	    				latitude: geom.location.lat(),
	    		        longitude: geom.location.lng(),
	    				}
		    		};
	        drawMap(registeredPos);
	      } else {
	        window.alert('Address could not be geocoded: ' + status);
	        zoom = map_options.default_zoom;
	        drawMapNoPosition();
	      }
	    });
	} else if (typeof latitude !== 'undefined' && typeof longitude !== 'undefined' ) {
	    registeredPos = {
    			coords: {
    				latitude: latitude,
    		        longitude: longitude,
    				}
	    		};
	    zoom = map_options.deep_zoom;
	    drawMap(registeredPos);
	} else if (navigator.geolocation) {
		zoom = map_options.default_zoom;
		navigator.geolocation.getCurrentPosition(drawMap, drawMapNoPosition, geo_options);
	} else {
		zoom = map_options.default_zoom;
		drawMapNoPosition();
	}
}

function drawMapNoPosition() {
	drawMap(map_options.default_position);
};

function drawMap(pos) {
	
	myPosition = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
	
	var map = new google.maps.Map(document.getElementById('map-canvas'), {
		center: myPosition,
	});
	
	if (geom === null) {
		map.setZoom(zoom);
	} else {
		var ne = geom.viewport.getNorthEast();
        var sw = geom.viewport.getSouthWest();
        map.fitBounds(geom.viewport);
        
        var boundingBoxPoints = [ne, new google.maps.LatLng(ne.lat(), sw.lng()), sw, new google.maps.LatLng(sw.lat(), ne.lng()), ne];
        var boundingBox = new google.maps.Polyline({
            path: boundingBoxPoints,
            strokeColor: '#3F61BE',
            strokeOpacity: 0.8,
            strokeWeight: 2
         });
        boundingBox.setMap(map);
	}
	
	//Test data
	var layer1 = new google.maps.FusionTablesLayer({
		map: map,  
		query: {
			select: map_options.col_name,
			from: map_options.id_map1,
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 2
		}
	});
	
	/*
	//Example data
	new google.maps.FusionTablesLayer({
		map: map,
		query: {
			select:"col2",
			from: map_options.id_map2,
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 3
		}
	});

	//Example data
	new google.maps.FusionTablesLayer({
		map: map,  
		query: {
			select: map_options.col_name,
			from: map_options.id_map3,
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 2
		}
	});

	//Example data
	new google.maps.FusionTablesLayer({
		map: map,  
		query: {
			select: map_options.col_name,
			from: map_options.id_map4,
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 2
		}
	});


	//Example data
	new google.maps.FusionTablesLayer({
		map: map,  
		query: {
			select: map_options.col_name,
			from: map_options.id_map5,
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 2
		}
	});
*/
};