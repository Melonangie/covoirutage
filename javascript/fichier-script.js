/******************************************
|	Système de Géolocalisation - Covoiturage
|	Licence Professionnelle de L'IUT DE LENS								
|
|	Copyright (c) 2010 Stylobic 								
|																							
|	Auteur :																	
|	- CAPILLIEZ Cyril 
|
|     Description : ce fichier regroupe plusieurs fonctions différentes 
|   ( affichage de miniature, jusqu'à des validations de formulaire via Ajax ).
|     
|
|
********************************************/

/***** Afficher les images miniatures en plein écran *******/

function openbox(url){
				var box = document.getElementById('box'); 
				document.getElementById('filter').style.display='block';
			  
				var title = document.getElementById('boxtitle');
				title.innerHTML = url;
			  
				var content = document.getElementById('boxcontent');
				content.style.padding="0";

				content.innerHTML = "...dynamic content...";
				content.innerHTML = "<img src=" + url + " />";
				
				box.style.display='block';	
}


function closebox(){
		document.getElementById('box').style.display='none';
		document.getElementById('filter').style.display='none';
}


/******** Fonction de Validation des Favoris ************/

function returnPreValid(){

	var nbFav = document.favourites.size();
	
	if (nbFav == 0)
	{	
		var text =	document.createTextNode("Vous ne pouvez pas valider votre formulaire de favoris car il est incomplet.");
		document.getElementById('output').appendChild(text);
		return false;
	}
	else{
		deleteFavourites(favorisReadData);
		for ( var i = 0; i < document.favourites.size(); i++) {
			requestFavourites(
					favorisReadData,
					document.favourites.get(i).address,
					document.favourites.get(i).latitude,
					document.favourites.get(i).longitude,
					document.favourites.get(i).label
					);
			
		}
		return false;s
	}
}

/******** Fonction de Validation de la planification d'un Trajet ************/

function returnPreHoraire(source,outward_date,outward_time){
	// Ici on peut rajouter des vérifications en Javascript ( manque de temps)
	requestHoraire(horaireReadData,source,outward_date,outward_time);	
	return false;
}

/******* Fonction utilisée pour le formulaire d'inscription ***********/

function changer(valeur){
	if(valeur){
		document.getElementById("cacher").style.display = 'inline';
		document.getElementById("cacher2").style.display = 'inline';
		document.getElementById("cacher3").style.display = 'inline';
		document.getElementById("cacher4").style.display = 'inline';
	}
	else{
		document.getElementById("cacher").style.display = 'none';
		document.getElementById("cacher2").style.display = 'none';
		document.getElementById("cacher3").style.display = 'none';
		document.getElementById("cacher4").style.display = 'none';
	}
}


/********* Fonction utilisée pour le module Horaire, pour connaitre le point de départ sélectionné ***********/

function getIndexSource(){
	 document.getElementById("sourceIndex").value = document.getElementById("source").selectedIndex;
}

/********* Récupérer des  Itineraires via un fichier XML nommée trajet.xml *********/

function recupItineraire() {
									
			var nodes = oData.getElementsByTagName("Trajet"); 
			var ul = document.createElement("ul"), li, cn, co, cp; 
					
			for (var i=0, c=nodes.length; i<c; i++) {
				
				li = document.createElement("li");
				cn = document.createTextNode(nodes[i].getAttribute("depart"));
				co = document.createTextNode(nodes[i].getAttribute("arrivee"));
				cp = document.createTextNode(nodes[i].getAttribute("distance"));
				
				li.appendChild(cn);
				li.appendChild(co);
				li.appendChild(cp);				
				ul.appendChild(li);
			}
				
			document.getElementById("output").appendChild(ul);
					
		}


