/******************************************
|	Système de Géolocalisation - Covoiturage
|	Licence Professionnelle de L'IUT DE LENS								
|
|	Copyright (c) 2010 Stylobic 								
|																							
|	Auteur :																	
|	- CAPILLIEZ Cyril 
 ********************************************/

/** ******* Creation d'un objet XMLHttpRequest pour les requêtes AJAX ********* */

function getXMLHttpRequest() {
	var xhr = null;

	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest();
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}

	return xhr;
}
