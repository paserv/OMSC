window.onload = loadScript;

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.19&signed_in=true&callback=initialize&key=AIzaSyD15UMjUyEUgkroE57c1j0hGrsFGbo0Is0';
	document.body.appendChild(script);
}

function initialize() {
	var afragola = new google.maps.LatLng(40.9210375, 14.3072168);

	var map = new google.maps.Map(document.getElementById('map-canvas'), {
		center: afragola,
		zoom: 8
	});

	//Example data
	new google.maps.FusionTablesLayer({
		map: map,
		query: {
			select: "col2",
			from: "1JaKfO_o43acSHPh5s5cJccQLiuOUljSK2KDblRWK",
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
			select: "col1",
			from: "1-AjHF5DJJONAmN51BiJ0AXiHcZQ1EajwhqTHIlSw",
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
			select: "col1",
			from: "1LkJaffRvmM8B_lr9qVJZbXP8O8bg3Bei1syah1i8",
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 2
		}
	});

	//Test data
	new google.maps.FusionTablesLayer({
		map: map,  
		query: {
			select: "col1",
			from: "1smtYhPcYgrZ5LjH8D6Uz5iTH8qsCu6sPxGO3m9sQ",
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
			select: "col1",
			from: "1MVpFMOH0dr0f5pUq6CoqLiFvFqc6T-Um7OgkRRUB",
			where: ""
		},
		options: {
			styleId: 2,
			templateId: 2
		}
	});

}

