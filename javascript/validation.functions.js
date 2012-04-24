
/**
 * @fileOverview This file has functions related to the validations.
 * @author <a href="mailto:lejeune.aurelien@gmail.com">Aurelien Lejeune</a>
 * @version 0.5
 */





/**
 * Add a new favourite in the database
 * 
 * @param favourite:
 * @param database:
 * @return
 */
function addFavouriteToDB(favourite, callback) {
	jQuery.post("traitement/validationFavoris.check.php", {
		insert: true,
		address: favourite.address,
		country : favourite.country,
		comment : favourite.comment,
		label: favourite.label,
		city : favourite.city,
		cp: favourite.cp,
		lat : favourite.latitude,
		lng : favourite.longitude
	   },
	   callback
	 );
}

/**
 * Delete an existing favourite in the database
 * 
 * @param favourite:
 * @param database:
 * @return
 */
function removeFavouriteFromDB(favourite, callback) {
	jQuery.post("traitement/validationFavoris.check.php", {
		remove: true,
		lat: favourite.latitude,
		lng: favourite.longitude
	   },
	   callback
	 );
}

/**
 * Update (or not) an existing favourite in the database
 * 
 * @param favourite:
 * @param database:
 * @return
 */
function updateFavouriteOnDB(favourite, callback) {
	jQuery.post("traitement/validationFavoris.check.php", {
				update: true,
				lat: favourite.latitude,
				lng: favourite.longitude,
				comment: favourite.comment,
				label: favourite.label
			   },
			   callback
			 );
}

/**
 * Function used to display the status of the requests.
 * @param oData:
 */
function appendText(oData){
	if (oData.length > 1) {
		var texte =	document.createTextNode(oData);
		document.getElementById('output').appendChild(texte);
	setTimeout('document.getElementById("output").innerHTML="";',5000);
	}    
	
	
}



