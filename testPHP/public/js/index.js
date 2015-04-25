window.onload = loadScript;

function loadScript() {
	var mapApi = document.createElement('script');
	mapApi.type = 'text/javascript';
	mapApi.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
	document.body.appendChild(mapApi);
}

function initialize() {
	
	if (typeof latitude !== 'undefined' && typeof longitude !== 'undefined' ) {
	    $registeredPos = {
    			coords: {
    				latitude: latitude,
    		        longitude: longitude,
    				}
	    		};
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
		zoom: map_options.zoom
	});

	//Test data
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
}

