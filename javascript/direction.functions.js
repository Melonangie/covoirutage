document.start;
document.end;
document.waypts = new Array();
document.map;
// var icon=''; changer icon de marker pour le trajet pré
// var markerop={icon:icon};

var polylineOp = {
	strokeColor : ROUTE_COULEUR_PRE
};
// var renderoptions={polylineOptions:polylineOp,markerOptions:markerop};
var renderoptions = {
	polylineOptions : polylineOp
};
var directionsDisplay = new google.maps.DirectionsRenderer(renderoptions);

/*
 * pour le trajet réel var polylineOp1={strokeColor:ROUTE_COULEUR_REEL}; var
 * renderoptions1={polylineOptions:polylineOp1,markerOptions:markerop}; var
 * directionsDisplay1 = new google.maps.DirectionsRenderer(renderoptions1);
 */
var directionsService = new google.maps.DirectionsService();

function initialisation() {
	createMap();
	directionsDisplay.setPanel(document.getElementById("directions_Panel"));
	// directionsDisplay1.setPanel(document.getElementById("directions_Panel1"));

	pre_itineraire();
	// reel_itineraire();

}

function createMap() {
	var centre = new google.maps.LatLng(INITIAL_POSITION_LAT,
			INITIAL_POSITION_LNG);
	var myOptions = {
		zoom : INITIAL_ZOOM_LEVEL,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		center : centre
	};
	document.map = new google.maps.Map(document.getElementById("map_canvas"),
			myOptions);
}

function pre_itineraire() {
	directionsDisplay.setMap(document.map);
	var request = {
		origin : document.start,
		destination : document.end,
		waypoints : document.waypts,
		optimizeWaypoints : false,
		travelMode : google.maps.DirectionsTravelMode.DRIVING
	};

	directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(response);

		}
	});
}

function reel_itineraire() {/*
							 * directionsDisplay1.setMap(document.map); var
							 * request = { origin : document.start, destination :
							 * document.end, waypoints : document.waypts,
							 * optimizeWaypoints : false, travelMode :
							 * google.maps.DirectionsTravelMode.DRIVING };
							 * 
							 * directionsService.route(request,
							 * function(response, status) { if (status ==
							 * google.maps.DirectionsStatus.OK) {
							 * directionsDisplay1.setDirections(response);
							 *  } });
							 */
}

function showDirection() {

	if (document.getElementById("preiti").checked
			&& !document.getElementById("reeliti").checked) { // directionsDisplay1.setMap(null);
		// directionsDisplay1.setPanel(null);
		directionsDisplay.setMap(document.map);
		directionsDisplay.setPanel(document.getElementById("directions_Panel"));

	} else if (!document.getElementById("preiti").checked
			&& document.getElementById("reeliti").checked) {
		directionsDisplay.setMap(null);
		directionsDisplay.setPanel(null);
		// directionsDisplay1.setMap(document.map);
		// directionsDisplay1.setPanel(document.getElementById("directions_Panel1"));
	}

	else if (document.getElementById("preiti").checked
			&& document.getElementById("reeliti").checked) {
		directionsDisplay.setMap(document.map);
		// directionsDisplay1.setMap(document.map);

		directionsDisplay.setPanel(document.getElementById("directions_Panel"));
		// directionsDisplay1.setPanel(document.getElementById("directions_Panel1"));
	}

	else {
		// directionsDisplay1.setMap(null);
		directionsDisplay.setMap(null);
		directionsDisplay.setPanel(null);
		// directionsDisplay1.setPanel(null);
	}

}
