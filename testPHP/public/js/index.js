window.onload = loadScript;
var zoom;

function loadScript() {
	var mapApi = document.createElement('script');
	mapApi.type = 'text/javascript';
	mapApi.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
	document.body.appendChild(mapApi);
}

function initialize() {
	zoom = map_options.zoom;
	if (typeof searchPlace !== 'undefined') {
		
	} else if (typeof latitude !== 'undefined' && typeof longitude !== 'undefined' ) {
	    $registeredPos = {
    			coords: {
    				latitude: latitude,
    		        longitude: longitude,
    				}
	    		};
	    zoom = 8;
	    drawMap($registeredPos);
	} else if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(drawMap, drawMapNoPosition, geo_options);
	} else {
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
		zoom: $zoom
	});

	//Test data
	var layer1 = new google.maps.FusionTablesLayer({
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
	
	/*
	//Example data
	new google.maps.FusionTablesLayer({
		map: map,
		query: {
			select:"col2",
			from: map_options.id_map1,
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
			from: map_options.id_map2,
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


function whereStatement(place) {
	var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
      address: place
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        map.setZoom(10);
        // OPTIONAL: run spatial query to find results within bounds.
        var sw = map.getBounds().getSouthWest();
        var ne = map.getBounds().getNorthEast();
        return where = 'ST_INTERSECTS(' + map_options.col_name + ', RECTANGLE(LATLNG' + sw + ', LATLNG' + ne + '))';
      } else {
        window.alert('Address could not be geocoded: ' + status);
      }
    });
  }

