var marker = new google.maps.Marker({
    map: map,
    // Define the place with a location, and a query string.
    place: {
      location: {lat: -33.8666, lng: 151.1958},
      query: 'Google, Sydney, Australia'

    },
    // Attributions help users find your site again.
    attribution: {
      source: 'OMSC',
      webUrl: 'http://localhost:8093/testFBjavascriptAPI/goggle.html'
    }
  });

//Construct a new InfoWindow.
var infowindow = new google.maps.InfoWindow({
  content: 'Google Sydney'
});

// Opens the InfoWindow when marker is clicked.
marker.addListener('click', function() {
  infowindow.open(map, marker);
});