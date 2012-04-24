/**
markers de favoris
 * @fileOverview This file has object related to the Markers.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 1.0
 */

/**
 * Create a new map and show it in a HTML element
 * @param HTMLComponent an HTML ID coponent related to the Markers list. 
 * @constructor
 */
function Markers(HTMLComponent) {
	this.HTMLComponent = HTMLComponent;
	this.highlighted = null;
	this.markers = new List();
	this.selectedIcon = new google.maps.MarkerImage(
			"http://labs.google.com/ridefinder/images/mm_20_yellow.png",
			new google.maps.Size(12, 20), new google.maps.Point(0, 0),
			new google.maps.Point(6, 20));
	this.unselectedIcon = new google.maps.MarkerImage(
			"http://labs.google.com/ridefinder/images/mm_20_blue.png",
			new google.maps.Size(12, 20), new google.maps.Point(0, 0),
			new google.maps.Point(6, 20));
	this.shadow = new google.maps.MarkerImage(
			"http://labs.google.com/ridefinder/images/mm_20_shadow.png",
			new google.maps.Size(22, 20), new google.maps.Point(0, 0),
			new google.maps.Point(6, 20));
}

/**
 * Highlight a marker and shade the others
 * 
 * @param :
 *            the Marker to highlight
 */
Markers.prototype.highlight = function(marker) {
	if (this.highlighted != null) {
		this.highlighted.setIcon(this.unselectedIcon);
		this.highlighted.infoWindow.close();
	}
	this.highlighted = marker;
	marker.setIcon(this.selectedIcon);
	index = this.markers.indexOf(marker);
	document.getElementById(this.HTMLComponent).options[index].selected = true;
};

/**
 * Add a new marker to the set
 * 
 * @param favourite :
 *            the marker will be related to this favourite {Favourite}
 */
Markers.prototype.add = function(favourite) {
	var marker = this.createMarker(favourite);
	this.markers.add(marker);
};

/**
 * Return a Marker
 * 
 * @param index :
 *            the position of the Marker {Integer}
 * @return {Marker}
 */
Markers.prototype.get = function(index) {
	return this.markers.get(index);
};

/**
 * Return the highlighted Marker
 * 
 * @return {Marker}
 */
Markers.prototype.getHighlighted = function() {
	return this.highlighted;
};

/**
 * Remove a Marker
 * 
 * @param marker :
 *            could be a Marker or an position in the array
 */
Markers.prototype.remove = function(marker) {
	if (typeof marker == 'number') {
		this.markers.get(i).setMap(null);
		this.markers.removeIndex(marker);
	} else {
		this.markers.remove(marker);
		marker.setMap(null);
	}
};

/**
 * Clear the marker list
 * 
 */
Markers.prototype.clear = function() {
	for ( var i = 0; i < this.markers.size();) {
		var marker = this.markers.get(0);
		this.remove(marker);
	}
	this.highlighted = null;
};

/**
 * Create a new Marker at a specific location
 * 
 * @param favourite :
 *            the marker will be related to this favourite {Favourite}
 * 
 * @return {Marker}
 */
Markers.prototype.createMarker = function(favourite) {
	var infoWindow = new google.maps.InfoWindow( {
		content : "<br><b>" + "Adresse : " + "</b>" + favourite.address
		+ "</br>" + "<br><b>" + "Ville : " + "</b>" + favourite.city
				+ "</br>" + "<br><b>" + "Pays : " + "</b>" + favourite.country
				+ "</br>" + "<br><b>" + "Position : " + "</b>"
				+ favourite.latitude + ", " + favourite.longitude + "</br>"
	});
	var marker = new google.maps.Marker( {
		position : new google.maps.LatLng(favourite.latitude,
				favourite.longitude),
		map : document.map,
		shadow : this.shadow,
		icon : this.unselectedIcon,
		title : favourite.label,
		infoWindow : infoWindow
	});
	var parent = this;
	google.maps.event.addListener(marker, 'click', function() {
		parent.highlight(marker);
		highlightFavourite(document.getElementById('pointList'));
	});
	google.maps.event.addListener(marker, 'dblclick', function() {
		jumpToSelectedFavourite();
	});
	return marker;
};

/**
 * Update a Marker with his favourite informations
 * 
 * @param index:
 *            the index of the marker {Integer}
 * @param favourite:
 *            the favourite related to the marker {Favourite}
 */
Markers.prototype.updateMarker = function(index, favourite) {
	var infoWindow = new google.maps.InfoWindow( {
		content : "<br><b>" + "Adresse : " + "</b>" + favourite.address
		+ "</br>" + "<br><b>" + "Ville : " + "</b>" + favourite.city
				+ "</br>" + "<br><b>" + "Pays : " + "</b>" + favourite.country
				+ "</br>" + "<br><b>" + "Position : " + "</b>"
				+ favourite.latitude + ", " + favourite.longitude + "</br>"
	});
	var marker = new google.maps.Marker( {
		position : new google.maps.LatLng(favourite.latitude,
				favourite.longitude),
		map : document.map,
		shadow : this.shadow,
		icon : this.unselectedIcon,
		title : favourite.label,
		infoWindow : infoWindow
	});
	var parent = this;
	google.maps.event.addListener(marker, 'click', function() {
		parent.highlight(marker);
		highlightFavourite(document.getElementById('pointList'));
	});
	google.maps.event.addListener(marker, 'dblclick', function() {
		jumpToSelectedFavourite();
	});
	var old = this.get(index);
	old.setMap(null);
	this.markers.set(index, marker);
};


/**
 * Return a marker index
 * 
 * @param marker :
 *            a marker in the list {Marker}
 * @return {Integer}
 */
Markers.prototype.indexOf = function(marker) {
	return this.markers.indexOf(marker);
};
