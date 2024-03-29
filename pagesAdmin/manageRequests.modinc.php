<?php
/**
 * @package pagesAdmin
 */
	//session_start();

?>

<script type="text/javascript" charset="utf-8">
		jQuery(document).ready(function() {
			jQuery('#requestsTable').dataTable({
					"bJQueryUI": true
			});
		});
</script>


<span class="gendarme">
	<span class="h1">
		Requêtes des utilisateurs
	</span>
	<span class="paragraphe">
		Vous pouvez visualiser les requêtes des utilisateurs.
	</span>
</span>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="requestsTable">
	<thead>
		<tr>
			<th>ID requête</th>
			<th>Départ</th>
			<th>Arrivée</th>
			<th>Date de départ</th>
			<th>Heure de départ</th>
			<th>Date d'arrivée</th>
			<th>Heure d'arrivée</th>
			<th>Etat</th>
		</tr>
	</thead>
	<tbody>
		<?php
			include_once('./BD/requests.sql.php');
			$db = new BD();
			$reques = getAllRequests($db);
			
			for ($i=0; $i< count($reques); $i++) {
				$requeid = $reques[$i];
				$favfrom=getfav_debut($requeid,$db);
				$favto=getfav_fin($requeid,$db);
				$etatar=get_Etats_Requete($requeid,$db);
				$eatder=$etatar[0];
				$etat=$eatder["INTITULE"];
				$addfrom=$favfrom['ADRESSE'].",".$favfrom['NOM'].",".$favfrom['NOMPAYS'];
				$addto=$favto['ADRESSE'].",".$favto['NOM'].",".$favto['NOMPAYS'];
				echo('<tr class="odd gradeU">');
				echo('<td>'.$requeid.'</td>');
				echo('<td>'.$addfrom.'</td>');
				echo('<td>'.$addto.'</td>');
				echo('<td>'.$favfrom['DATE'].'</td>');
				echo('<td>'.$favfrom['HEUREDEBUT'].'--'.$favfrom['HEUREFIN'].'</td>');
				echo('<td>'.$favto['DATE'].'</td>');
				echo('<td>'.$favto['HEUREDEBUT'].'--'.$favto['HEUREFIN'].'</td>');
			echo('<td>'.$etat.'</td>');
			}
			$db->closeConnexion();
		?>
	</tbody>
	<tfoot>
		<tr>
				<th>ID requête</th>
			<th>Départ</th>
			<th>Arrivée</th>
			<th>Date de départ</th>
			<th>Heure de départ</th>
			<th>Date d'arrivée</th>
			<th>Heure d'arrivée</th>
			<th>Etat</th>
		</tr>
	</tfoot>
</table>


<div id="output" style="color: red;"></div>
