
	google.maps.event.addDomListener(window, 'load', init);
	function init() {
		// Basic options for a simple Google Map
		// For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
		var mapOptions = {
			// How zoomed in you want the map to start at (always required)
			zoom: 9,
			scrollwheel: false,
			// The latitude and longitude to center the map (always required)
			center: new google.maps.LatLng(55.746669, 37.626409), // New York
			// How you would like to style the map. 
			// This is where you would paste any style found on Snazzy Maps.
			styles: 
				[]
		};
		// Get the HTML DOM element that will contain your map 
		// We are using a div with id="map" seen below in the <body>
		var mapElement = document.getElementById('map');

		// Create the Google Map using our element and options defined above
		var map = new google.maps.Map(mapElement, mapOptions);

		// Let's also add a marker while we're at it


		// marker 1
		var image = 'img/icone/mark-map.png';
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(55.746669, 37.626409),
			map: map,
			icon: image,
			title: 'Snazzy!'
		});
		var infowindow = new google.maps.InfoWindow({
			
		});

		marker.addListener('click', function() {
			$('.block-form-map').hide(0);
			$('#form-map-1').show(0);
		});


		// marker 2
		var image = 'img/icone/mark-map.png';
		var marker_2 = new google.maps.Marker({
			position: new google.maps.LatLng(55.706669, 37.426409),
			map: map,
			icon: image,
			title: 'Snazzy!'
		});



		marker_2.addListener('click', function() {
			$('.block-form-map').hide(0);
			$('#form-map-2').show(0);
		});


		/*---------------content maps---------------*/
	}



	jQuery(document).ready(function($) {
		$('.block-form-map .close-map').click(function(event) {
			$('.block-form-map').hide(0);
		});
	});














