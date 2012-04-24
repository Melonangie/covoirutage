/**
 * @fileOverview This file has functions related to the favourites page. Des fonctions sont spécialisées aux adresses françaises, pour adapter les autres adresses, il est suffisant de modifier les interfaces pages, et d'ajouter des fonctions spécialisées aux autres adresses. 
 * @author <a href="mailto:francie_xue@hotmail.com">Dong XUE</a>
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 1.0
 */

/**
 * Temporary variable used to store the Favourite
 */
var TEMP_FAV = new Array();
var TEMP_NDX = 0;
var COMPTEUR = 0;

/**
 * version française Initialise the favourite and the map The favourite list is
 * put in the variable TEMP_FAV by the php file.
 */
function init() {
	document.favourites = new List();
	document.DBfavourites = new List();
	updateFavourites(TEMP_FAV, 'pointList');
	document.DBfavourites.addAll(TEMP_FAV);
	document.googleMap = new GoogleMap('map2');
	document.markers = new Markers('pointList');
	document.googleMap.addListeners();
	document.googleMap.addFavMarkers(document.favourites);
};

/**
 * Remove a favourite from the list of Favourite, the list of Marker and the
 * HTML list.
 * 
 * @param param :
 *            HTML list component id {String} or index of the favourite
 *            {Integer}
 * @return true if the favourite have been removed
 */
function removeFavourite(param, admin) {
	var deleteConfirm = confirm("Êtes vous sur de vouloir effacer le favori ?");
	if (deleteConfirm) {
		if (typeof (param) == 'string') {
			var index = document.getElementById(param).selectedIndex;
		} else {
			var index = param;
		}
		if (index != -1) {
			var marker = document.markers.get(index);
			var favourite = document.favourites.get(index);
			if (admin == false && favourite.predefine == 1)
				alert("Favoris prédéfinis ne peuvent pas être supprimés!");
			else {
				document.markers.remove(marker);
				document.favourites.remove(favourite);
				document.getElementById('pointList').options[index] = null;
				document.getElementById('nbSelection').value--;
				removeFavouriteFromDB(favourite, appendText);
			}
		}
	}
};

/**
 * Update a favourite with new data if possible Only comment and alias allow to
 * modify,if a new address needs,it should add an address but modify.
 * 
 * @param componentListID :
 *            the ID of the HTML component containing the favourites list
 */
function updateFavourite(componentListID, admin) {
	var updateConfirm = confirm("Êtes vous sûr de vouloir modifier le favori ?");
	if (updateConfirm) {
		var index = document.getElementById(componentListID).selectedIndex;

		if (index != -1) {
			var favourite = document.favourites.get(index);
			if (admin == false && favourite.predefine == 1)
				alert("Favoris prédéfinis ne peuvent pas être modifiés!");
			else
				updateAliasComment(favourite, index);
		}
	}
};

/**
 * Update the alias and comment attribut of a favourite with the corresponding
 * fields values
 * 
 * @param: a favourite {Favourite}
 */
function updateAliasComment(favourite, index) {
	var la = document.getElementById('txtLabel').value;
	if (adr_label_Exists("", la, index)) {
		alert("Alias existe déjà!");
	} else {
		favourite.label = la;
		favourite.comment = parseComment(document.getElementById('txtComment').value);
		document.getElementById('txtComment').value = favourite.comment;
		document.getElementById('txtLabel').value = favourite.label;
		updateFavListLabel(favourite);
		updateFavouriteOnDB(favourite, appendText);
	}
}

/**
 * Highlight a Marker
 * 
 * @param index :
 *            index of the favourite {Integer}
 */
function highlightFavourite(component) {
	var index = component.selectedIndex;
	var favourite = document.favourites.get(index);
	var marker = document.markers.get(index);
	document.getElementById('txtAddress').value = favourite.address;
	document.getElementById('city').value = favourite.city;
	document.getElementById('country').value = favourite.country;
	document.getElementById('codepostal').value = favourite.cp;
	document.getElementById('txtLabel').value = favourite.label;
	document.getElementById('txtComment').value = favourite.comment;
	document.markers.highlight(marker);
};

/**
 * Center the map on the highlighted favourite
 */
function jumpToSelectedFavourite() {
	var marker = document.markers.getHighlighted();
	document.map.setCenter(marker.getPosition());
	document.map.setZoom(ADDRESS_ZOOM_LEVEL);
	marker.infoWindow.open(document.map, marker);
};

/**
 * Add a favourite to an HTML component
 * 
 * @param favourite :
 *            {Favourite}
 * @param componentID :
 *            the ID of a HTML component
 */
function addFavouriteToHTML(favourite, componentID) {
	document.getElementById(componentID).options.add(new Option(
			getFavListLabel(favourite)));
	document.getElementById('nbSelection').value++;
	COMPTEUR++;
};

/**
 * Add a favourites list to an HTML component
 * 
 * @param favourites :
 *            {List}
 * @param componentID :
 *            the ID of a HTML component
 */
function addFavouritesToHTML(favourites, componentID) {
	for ( var i = 0; i < favourites.size(); i++) {
		var favourite = favourites.get(i);
		document.getElementById(componentID).options.add(new Option(
				getFavListLabel(favourite)));
	}
};

/**
 * Update with an array of favourites
 * 
 * @param favourite :
 *            an array of Favourite {Array}
 * @param component :
 *            an HTML component
 */
function updateFavourites(favourites, component) {
	for ( var i = 0; i < favourites.length; i++) {
		document.favourites.add(favourites[i]);
		addFavouriteToHTML(favourites[i], component);
	}
};

/**
 * Afficher une adresse sélectionnée
 * 
 * @param results
 * @param status
 * @return
 */
function afficherAdr(results, status) {
	if (!results || (status != google.maps.GeocoderStatus.OK)) {
		alert("Error 01 : Geocoder did not return a valid response\n L'adresse saisie n'est pas référencée");
	} else {
		var address = results[0].formatted_address;
		var country = getCountry(address);
		var city = getCity(address);
		var cp = getPostalCode(address);
		var shoradr = getShortAddress(address);
		var location = results[0].geometry.location;
		document.getElementById('txtAddress').value = shoradr;
		document.getElementById('country').value = country;
		document.getElementById('city').value = city;
		document.getElementById('codepostal').value = cp;
		createMarker(location);
	}
}

/**
 * Create a new favourite and add it to the Favourites, the Markers and the HTML
 * component.
 * 
 * @param results :
 *            the result of a geocoding request
 * @param status :
 *            the status returned by the Geocoder
 */
function createAndMemorizeFavourite(results, status) {
	if (!results || (status != google.maps.GeocoderStatus.OK)) {
		alert("Error 01 : Geocoder did not return a valid response\n L'adresse saisie n'est pas référencée");
	} else {

		var address = results[0].formatted_address;
		var country = getCountry(address);
		var city = getCity(address);
		var cp = getPostalCode(address);
		var shoradr = getShortAddress(address);
		if (shoradr == "")
			alert("Cette adresse n'existe pas!");
		else {
			document.getElementById('txtAddress').value = shoradr;
			document.getElementById('country').value = country;
			document.getElementById('city').value = city;
			document.getElementById('codepostal').value = cp;

			var longitude = results[0].geometry.location.lng();
			var latitude = results[0].geometry.location.lat();
			var label = document.getElementById('txtLabel').value;
			var comment = parseComment(document.getElementById('txtComment').value);
			if (trim(label) == "") {
				var nbfav = COMPTEUR + 1;
				label = "favori " + nbfav;
				document.getElementById('txtLabel').value = label;
			}
			if (adr_label_Exists(address, label, -1)) {
				alert("Vous avez déjà ajouté cette adresse comme favori ou l'alias existe déjà!");
			} else {
				var favourite = new Favourite(shoradr, latitude, longitude,
						country, city, cp, label, comment, 0);
				addFavouriteToDB(favourite, appendText);
				document.favourites.add(favourite);
				document.markers.add(favourite);
				addFavouriteToHTML(favourite, 'pointList');
				document.markers.highlight(document.markers
						.get(document.favourites.indexOf(favourite)));
				jumpToSelectedFavourite();
			}
		}
	}
};

/**
 * Create a favourite when doing an action on the HTML form
 * 
 * @param
 * @return
 */
function createFavouriteFromForm() {
	var addConfirm = confirm("Êtes vous sur de vouloir ajouter le favori ?");
	if (addConfirm) {
		if (trim(document.getElementById("txtAddress").value) == ""
				|| trim(document.getElementById("city").value) == "")
			alert("Il faut saisir les champs obligatoires*");
		else {
			var address = document.getElementById("txtAddress").value + ","
					+ document.getElementById("codepostal").value + " "
					+ document.getElementById("city").value + ","
					+ document.getElementById("country").value;
			document.geocoder.geocode({
				'address' : address
			}, createAndMemorizeFavourite);
		}
	}
};

/**
 * Remove the carriage return in the comment.
 * 
 * @param comment:
 *            a comment (long text).
 * @return {String}
 */
function parseComment(comment) {
	var reg = new RegExp("\n+", "g");
	return comment.replace(reg, " ");
}

/**
 * Update the favourite name in the HTML list
 * 
 * @param favourite:
 *            the updated favourite {Favourite}
 */
function updateFavListLabel(favourite) {
	document.getElementById('pointList').options[index] = new Option(
			getFavListLabel(favourite));
}

/**
 * Select the usefull information to show in the HTML favourites list.
 * 
 * @param favourite:
 *            a favourite {Favourite}
 * @return the text shown in the HTML favourites list
 */
function getFavListLabel(favourite) {
	var label = favourite.label;
	if (favourite.predefine == 1)
		label += '(prédéfini)';
	return label;
}

/**
 * Get the contry name from address
 * 
 * @param address
 * @return a country name
 */
function getCountry(address) {
	var lastCommaPos = address.lastIndexOf(",", address.length);
	return address.substring(lastCommaPos + 2, address.length);
};

/**
 * Get the city name from address
 * 
 * @param address
 * @return a city name
 */
function getCity(address) {
	var lastCommaPos = address.lastIndexOf(",", address.length);
	var firstCommaPos = address.indexOf(",");
	if (lastCommaPos != firstCommaPos)
		return address.substring(firstCommaPos + 8, lastCommaPos);
	else
		return address.substring(0, lastCommaPos);
};

/**
 * Get postal code from address
 * 
 * @param address
 * @return the postal code
 */
function getPostalCode(address) {
	var firstCommaPos = address.indexOf(",");
	var lastCommaPos = address.lastIndexOf(",", address.length);
	if (lastCommaPos != firstCommaPos)
		return address.substring(firstCommaPos + 2, firstCommaPos + 7);
	else
		return "";
};

/**
 * Get the short address from address
 * 
 * @param address
 * @return a short address
 */
function getShortAddress(address) {
	var firstCommaPos = address.indexOf(",");
	var lastCommaPos = address.lastIndexOf(",", address.length);
	if (lastCommaPos != firstCommaPos)
		return address.substring(0, firstCommaPos);
	else
		return "";
};

/**
 * Enlever les espaces devant et après String
 * 
 * @param str
 * 
 * @return str corrigé
 */
function trim(str) {
	return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str) {
	return str.replace(/(^\s*)/g, "");
}
function rtrim(str) {
	return str.replace(/(\s*$)/g, "");
}

/**
 * 
 * @param adr
 * @param label
 * @return
 */
function adr_label_Exists(adr, label, index) {
	var exists = false;
	for ( var i = 0; i < document.favourites.size(); i++) {
		var fav = document.favourites.get(i);
		if (fav.address == getShortAddress(adr) && fav.cp == getPostalCode(adr)) {
			exists = !false;
			return exists;
		}
		if (i != index) {
			if (fav.label == label && label != "") {
				exists = !false;
				return exists;
			}
		}
	}
	return exists;
}
