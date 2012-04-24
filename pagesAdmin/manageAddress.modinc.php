<?php
/**
 * @package pagesAdmin
 */
//session_start();

?>
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="./javascript/addressManagement.function.js" type="text/javascript"></script>

<span class="gendarme"> <span class="h1"> Gérer les adresses
géographique </span> <span class="paragraphe"> Vous pouvez consulter et
administrer les adresses référencées par le site. </span> </span>

<table cellpadding="0" cellspacing="0" border="0" class="display"
	id="addressesTable">
	<thead>
		<tr>
		<th>ID</th>
			<th>Address</th>
			<th>Ville</th>
			<th>Pays</th>
			<th>Latitude</th>
			<th>Longitude</th>
		</tr>
	</thead>
	<tbody>
	<?php
	include_once('./BD/favourites.sql.php');
	$db = new BD();
	$addresses = getAddresses($db);
	$db->closeConnexion();
	for ($i=0; $i< count($addresses); $i++) {
		$address = $addresses[$i];
		echo('<tr class="odd gradeU">');
		echo('<td>'.$address['IDPOINT'].'</td>');
		echo('<td>'.$address['ADRESSE'].'</td>');
		echo('<td>'.$address['NOM'].'</td>');
		echo('<td>'.$address['NOMPAYS'].'</td>');
		echo('<td>'.$address['LATITUDE'].'</td>');
		echo('<td>'.$address['LONGITUDE'].'</td>');
	}
	?>
	</tbody>
	<tfoot>
		<tr>
		<th>ID</th>
			<th>Address</th>
			<th>Ville</th>
			<th>Pays</th>
			<th>Latitude</th>
			<th>Longitude</th>
		</tr>
	</tfoot>
</table>

<span class="paragraphe">
	Distance depuis : <input type="text" id="departure" readonly="readonly"></input><input type="hidden" id="departureid" readonly="readonly"></input>
	<button id="departureBtn">+</button>
	vers : <input type="text" id="arrival" readonly="readonly"></input><input type="hidden" id="arrivalid" readonly="readonly"></input>
	<button id="arrivalBtn">+</button>

	<span id="distResult"></span>
</span>

<span class="gendarme" style="text-align: center;">
	<br/>
	<button id="fillMatrixBtn">Remplir la matrice</button>
	<span id="fillResult"></span>
</span>

<div id="output"
	style="color: red;"></div>