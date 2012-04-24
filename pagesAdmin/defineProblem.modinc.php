<?php
/**
 * @package pagesAdmin
 */
//session_start();

include_once('./modules/problem.dialog.php');
include_once('./BD/requests.sql.php');
include_once('./BD/favourites.sql.php');
?>
<script
	src="./javascript/problem.functions.js" type="text/javascript"></script>
<script
	src="./javascript/prototype/Request.prototype.js"
	type="text/javascript"></script>
<script
	src="./javascript/prototype/List.prototype.js" type="text/javascript"></script>

<span class="gendarme"> <span class="h1"> Gérer les problèmes de
covoiturage </span> <span class="paragraphe"> Vous pouvez définir un
problème de covoiturage qui sera traitée par le système. </span> </span>
<table cellpadding="0" cellspacing="0" border="0" class="display"
	id="problemsTable">
	<thead>
		<tr>
		<?php
		$infos_image = @getImageSize("./images/details_open.png");
		$largeur = $infos_image[0];
		echo('<th width="'.$largeur.'"></th>');
		?>
			<th>ID problème</th>
			<th>Période</th>
			<th>Destination</th>
			<th>Nombre de requêtes</th>
			<th>Etat</th>
			<th>Itinéraire</th>
		</tr>
	</thead>
	<tbody>
	<?php

	$db = new BD();
	$problems = getProblems($db);
	for ($i=0; $i< count($problems); $i++) {
		$problem = $problems[$i];
		$reques=getProDetail($db,$problem['IDPROBLEME']);
			
		echo('<tr class="odd gradeU">');
		echo('<td><img src="./images/details_open.png"></td>');
		echo('<td>'.$problem['IDPROBLEME'].'</td>');
		echo('<td>Départ depuis '.$problem['TIMEBEGIN'].' '.$problem['DATEBEGIN'].' avant '.$problem['TIMEOVER'].' '.$problem['DATEOVER'].'</td>');
		echo('<td>'.$problem['ALIAS'].'</td>');
		echo('<td>'.count($reques).'</td>');
		echo('<td>'.$problem['COMMENTAIRE'].'</td>');
		echo('<td>');
		echo('<form method="post" action="./afficherRoute.mediateur.php" target="_blank">');
		echo('<input type="hidden" name="idpro" value="'.$problem['IDPROBLEME'].'"/>');
		echo('<input type="hidden" name="idfavfin" value="'.$problem['IDFAVORI'].'"/>');
		echo('<input type="hidden" name="latfin" value="'.$problem['LATITUDE'].'"/>');
		echo('<input type="hidden" name="lngfin" value="'.$problem['LONGITUDE'].'"/>');
		$marquerpro="'".$problem['IDPROBLEME']."'";
		echo '<select name="numsolution" onchange="clicksimulation('.$marquerpro.')">
<option value="1">solution 1</option>
<option value="2">solution 2</option>
         </select>';
		echo '<input id="'.$problem['IDPROBLEME'].'" type="submit" value="Voir"/>';
		echo('</form>');
		echo('</td>');
			
		echo '<script language="javascript" type="text/javascript">
                     var requids=[];
                           </script>';
			

		for ($j=0; $j< count($reques); $j++){
			$reque=	$reques[$j];
			$favfrom=getfav_debut($reque,$db);
			$favto=getfav_fin($reque,$db);
			$addfrom=$favfrom['ADRESSE'].",".$favfrom['NOM'].",".$favfrom['NOMPAYS'];
			$addto=$favto['ADRESSE'].",".$favto['NOM'].",".$favto['NOMPAYS'];

			echo('<script language="Javascript">document.requests.put(
							'.$reque.',
							new Request(
							 	"'.$addfrom.'",
							 	"'.$favfrom['ALIAS'].'",
								"'.$favfrom['DATE'].'",
								"'.$favfrom['HEUREDEBUT'].'",
								"'.$favfrom['HEUREFIN'].'",
								"'.$addto.'",
								"'.$favto['ALIAS'].'",
								"'.$favto['DATE'].'",
								"'.$favto['HEUREDEBUT'].'",
								"'.$favto['HEUREFIN'].'",
								'.$favfrom['CONDUCTEUR'].'
							));
							requids.push('.$reque.');
								</script>'
								);
		}
		echo('<script language="Javascript">
						document.relations.put(
							'.$problem['IDPROBLEME'].',
		                           requids);
		                          </script>');
	
	}
	$db->closeConnexion();
	?>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<th>ID problème</th>
			<th>Période</th>
			<th>Destination</th>
			<th>Nombre de requêtes</th>
			<th>Etat</th>
			<th>Itinéraire</th>
		</tr>
	</tfoot>
</table>

<div id="moduleHoraire"><?php

$db = new BD();
$favourites = getPrefavourites($db);
$db->closeConnexion();
for ($i=0; $i< count($favourites); $i++) {
	$favourite = $favourites[$i];
	echo ('<script language="Javascript">document.favourites.add(new Favourite(
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

echo ('<script language="Javascript">addFavouritesToHTML(document.favourites, "arrival")</script>');

?></div>

<input value="Définir un nouveau problème" type="button" id="newProBtn">

<!-- Module Horaire -->

<div id="output" style="color: red;"></div>



