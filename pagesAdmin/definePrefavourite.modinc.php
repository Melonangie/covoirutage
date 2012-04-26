<?php
	//session_start();
/**
 * @package pagesAdmin
 */
?>

<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="./javascript/favourites.functions.js" type="text/javascript"></script>
<script src="./javascript/prototype/Markers.Prototype.js" type="text/javascript"></script>
<script src="./javascript/markernonfavori.function.js" type="text/javascript"></script>
<script src="./javascript/prototype/GoogleMap.Prototype.js" type="text/javascript"></script>

<span class="gendarme">
	<span class="h1">Définition des Favoris Prédéfinis</span>		
	<span class="paragraphe">
	    Vous pouvez définir les favoris prédéfinis
	</span>	
</span>
		
<div id="preFavoris">
	<div id="map2"></div>		
	<div id="monPanel">					
		<form method="POST" action="#">			
		    <span class="blockleft">
			    <span class="titrefonction">Num et Rue* : <font size="1" color="black">&nbsp;(ex: 90 Rue Jean Sarrazin)</font></span>		    
			    <input id="txtAddress" type="text" class="gendarme">
			     <span class="titrefonction">Ville* :</span>
			    <input id="city" type="text" class="gendarme" onblur="checkAddress()">
			    <span class="titrefonction">Code Postal :</span>
			    <input id="codepostal" type="text" class="gendarme">
			    <span class="titrefonction">Pays :</span>
			    <input id="country" type="text" class="gendarme">
		    	<span class="titrefonction">Alias :</span>
		    	<input id="txtLabel" type="text" class="gendarme">
		    
		    	<span class="titrefonction">Commentaire :</span>
		    	<textarea id="txtComment" rows="5" class="gendarme"></textarea>
		    	
		    	<span class="gendarme">
		    		<input value="Ajouter"  onclick="createFavouriteFromForm()" type="button">
		    		<input value="Modifier" onclick="updateFavourite('pointList',true)" type="button">
		    		<input value="Effacer"  onclick="removeFavourite('pointList',true)" type="button">
		    	</span>
		    
		    </span>

		    <span class="titrefonction">Liste de points :</span>			
		    <span class="blockleft">Nombre de marqueurs : <input size="1" id="nbSelection" value="0"/></span>
			<div id="maxMarker">Vous avez atteint le nombre maximum de points d'étape.</div>
				<span class="gendarme">
			        <select id="pointList" size="5" onchange="highlightFavourite(this)" ondblclick="jumpToSelectedFavourite()"></select><br>
			        <?php
			        	include_once('./BD/favourites.sql.php');
			        	$mydb = new BD();
			        	$favourites = getPrefavourites($mydb);
						for ($i=0; $i< count($favourites); $i++) {
							$favourite = $favourites[$i];
							echo('<script language="Javascript">TEMP_FAV.push(new Favourite(
							 	"'.$favourite['ADRESSE'].'",
								'.$favourite['LATITUDE'].',
								'.$favourite['LONGITUDE'].',
								"'.$favourite['NOMPAYS'].'",
								"'.$favourite['NOM'].'",
								"'.$favourite['CP'].'",
								"'.$favourite['ALIAS'].'",
								"'.$favourite['COMMENTAIRE'].'",
								'.$favourite['PREDEFINI'].'								
							));</script>');
						}
			        	$mydb->closeConnexion();
			        ?>
			        	
				</span>
			<span class="gendarme">
				<input style="display:none" id="encodedPolyline" name="encodedPolyline"/>
				<input style="display:none" id="encodedLevels" name="encodedLevels"/>	
			</span>	
				<div id="output" style="color:black;font-size:16px;"></div>
		
			<span id="loader" style="display: none;"><img src="images/loading.gif" alt="loading" /></span>
			
		 
		    
		    
	   </form>
							
    </div> <!-- monPanel -->
</div> <!-- monFavoris -->