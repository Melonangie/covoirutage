/******************************************
|	Système de Géolocalisation - Covoiturage
|	Licence Professionnelle de L'IUT DE LENS								
|
|	Copyright (c) 2010 Stylobic 								
|																							
|	Auteur :																	
|	- CAPILLIEZ Cyril 
|      Description : ce fichier est utile pour les modules Favoris et Horaire ( requêtes Ajax )
|     
|     Note : les fonctions sont très similaire (manque de temps oblige)
|
********************************************/

var statutFavoris = 0; // Pour ne pas écrire plusieurs fois le texte de retour
var statutDLFav   = 0;
var statutHoraire = 0;

 /**** Validation des Favoris ****/

function requestFavourites(callback,address,lat,lng,label){
			
			if (xhr && xhr.readyState != 0) {
				alert("Vous avez déjà lancé une requête");
			return;
			}
			
			var xhr = getXMLHttpRequest();
						
			xhr.onreadystatechange = function() {
				if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
					callback(xhr.responseText);
					document.getElementById("loader").style.display = "none";
					setTimeout("window.location='index.php'",1000);  
				}
				else if (xhr.readyState < 4) {
					document.getElementById("loader").style.display = "inline";
				}			
			};			
				
			xhr.open("POST", "traitement/validationFavoris.check.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			var request =  "&address=" + address + "&lat=" + lat + "&lng=" + lng + "&label=" + label ;
			xhr.send(request);
			
}

function deleteFavourites(callback){
	
	if (xhr && xhr.readyState != 0) {
		alert("Vous avez déjà lancé une requête");
	return;
	}
	var xhr = getXMLHttpRequest();			
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
			document.getElementById("loader").style.display = "none";
			setTimeout("window.location='index.php'",1000);  
		}
		else if (xhr.readyState < 4) {
			document.getElementById("loader").style.display = "inline";
		}			
	};			
		
	xhr.open("POST", "traitement/validationFavoris.check.php", false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	var request =  "delete=" + true;
	xhr.send(request);
	return;
}

function favorisReadData(oData){
	if(statutFavoris == 0){
		var texte =	document.createTextNode(oData);
		document.getElementById('output').appendChild(texte);
		statutFavoris = 0;
	}
	return;
}


/**** Validation Horaire *******/

function requestHoraire(callback,source,outward_date,outward_time){

		if (xhr && xhr.readyState != 0) {
			alert("Vous avez déjà lancé une requête");
			return;
		}
			
		var xhr = getXMLHttpRequest();	
	
		xhr.onreadystatechange = function() {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				callback(xhr.responseText);
				document.getElementById("loader").style.display = "none";
				setTimeout("window.location='index.php'",1000);  
			}
			else if (xhr.readyState < 4) {
				document.getElementById("loader").style.display = "inline";
			}
		};

			xhr.open("POST", "traitement/validationHoraire.check.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");			
			var requete =  "source=" + source + "&outward_date=" + outward_date +"&outward_time=" + outward_time;			
			xhr.send(requete);			

}

function horaireReadData(oData){	
	if(statutHoraire == 0){
		var texte =	document.createTextNode(oData);
		document.getElementById('output').appendChild(texte);
		statutHoraire = 1;
	}
}

