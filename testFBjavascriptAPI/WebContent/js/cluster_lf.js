var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				maxZoom: 18,
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, Points &copy 2012 LINZ'
			}),
			latlng = L.latLng(-37.79, 175.27);
		var map = L.map('map', { center: latlng, zoom: 13, layers: [tiles] });
		var progress = document.getElementById('progress');
		var progressBar = document.getElementById('progress-bar');
		function updateProgressBar(processed, total, elapsed, layersArray) {
			if (elapsed > 1000) {
				// if it takes more than a second to load, display the progress bar:
				progress.style.display = 'block';
				progressBar.style.width = Math.round(processed/total*100) + '%';
			}
			if (processed === total) {
				// all markers processed - hide the progress bar:
				progress.style.display = 'none';
			}
		}
		var markers = L.markerClusterGroup({ chunkedLoading: true, chunkProgress: updateProgressBar });
		var markerList = [];
		//console.log('start creating markers: ' + window.performance.now());
		for (var i = 0; i < 1000; i++) {
			var title = "title" + i;
			var marker = L.marker(L.latLng(getRandomArbitrary(-85, 85), getRandomArbitrary(-180, 180)), { title: title });
			marker.bindPopup(title);
			markerList.push(marker);
			console.log(i);
		}
		//console.log('start clustering: ' + window.performance.now());
		markers.addLayers(markerList);
		map.addLayer(markers);
		
		function getRandomArbitrary(min, max) {
			return Math.random() * (max - min) + min;
		}