/**
 * @fileOverview This file has functions related to the Google Map API.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 1.0
 */

/**
 * Create a new map and show it in a HTML element
 * @param elementID the ID of the HTML element
 * @constructor
 */
function GoogleMap(elementID) {
	var mapOptions = {
		zoom : INITIAL_ZOOM_LEVEL,
		center : new google.maps.LatLng(INITIAL_POSITION_LAT,
				INITIAL_POSITION_LNG),
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	document.map = new google.maps.Map(document.getElementById(elementID),
			mapOptions);
	document.geocoder = new google.maps.Geocoder();
}

/**
 * Add the listeners on the map.
 * A click on the map will add a favourite at the mouse position.
 */
GoogleMap.prototype.addListeners = function() {
	google.maps.event.addListener(document.map, 'click', function(
			event, overlay) {
		document.getElementById('txtLabel').value = "";
		document.getElementById('txtComment').value = "";
		document.geocoder.geocode({
			'latLng': event.latLng
			},
			afficherAdr);
	});
};

/**
 * Add a marker to all the favoutites
 */
GoogleMap.prototype.addFavMarkers = function(favourites) {
	for ( var i = 0; i < favourites.size(); i++) {
		var favourite = favourites.get(i);
		document.markers.add(favourite);
	}
};

