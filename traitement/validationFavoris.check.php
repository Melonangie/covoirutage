<?php
 /**
 * @package traitement
 */
session_start();
header("Content-Type: text/plain");

include_once('../BD/BD.class.php');
include_once ('../BD/favourites.sql.php');
include_once ('../BD/ODMatrix.sql.php');
include_once('../modules/fonctionsUtiles.php');

$succes = false;



if (isset($_POST['remove']) && isset($_POST['lat']) && isset($_POST['lng'])) {

	$userID  = $_SESSION['id'];
	if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)
	{

		$userID=0;
	}
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$reponse=fav_utilise(round($lat,7),round($lng,7),$userID);
	if($reponse!=null)
	{
		$db = new BD();
		$query =	"DELETE FROM `favori`".
				"WHERE IDFAVORI=".$reponse;
		$db->query($query);
		$db->closeConnexion();
		$succes = true;
	}
	else
	{

		$output="Delete referenced favourite, le favori est utilisé pour un trajet, suppression impossible!";

	}
}

if (isset($_POST['update']) && isset($_POST['lat']) && isset($_POST['lng'])
&& isset($_POST['comment']) && isset($_POST['label'])) {

	$userID  = $_SESSION['id'];
	if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)
	{

		$userID=0;
	}
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$reponse=fav_utilise(round($lat,7),round($lng,7),$userID);
	if($reponse!=null)
	{
		$comment = mysql_escape_string($_POST['comment']);
		$label = mysql_escape_string($_POST['label']);
		$db = new BD();
		$query = "UPDATE favori SET ALIAS='".$label."',COMMENTAIRE='".$comment."' WHERE IDFAVORI=".$reponse;
		$db->query($query);
		$db->closeConnexion();
		$succes = true;
	}
	else
	{

		$output="Le favori est utilisé pour un de vos trajet, la modifiction est impossible!";

	}
}

if (isset($_POST['insert']) && isset($_POST['address']) && isset($_POST['lat'])
&& isset($_POST['country']) && isset($_POST['lng'])
&& isset($_POST['comment']) && isset($_POST['label'])
&& isset($_POST['city']) && isset($_POST['cp'])) {
	$output="Echouer d'ajouter le favori!";
	$userID  = $_SESSION['id'];
	$address = mysql_escape_string($_POST['address']);
	$country = mysql_escape_string($_POST['country']);
	$comment =  mysql_escape_string($_POST['comment']);
	$label =  mysql_escape_string($_POST['label']);
	$city =  mysql_escape_string($_POST['city']);
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$cp = $_POST['cp'];
	$db = new BD();
	$predefini=0;
	if(isset($_SESSION['admin']) && $_SESSION['admin'] == true)
	{
		$predefini=1;
		$userID=0;
	}
	$idpoint=getIDPOINT($db,round($lat,7),round($lng,7));
	if($idpoint==null)
	{
		$queryIDville  = 'SELECT `ID_VILLE`
					FROM `ville`
					WHERE `NOM` = "'.$city.'"';

		$idville = $db->query($queryIDville);
		$result = mysql_fetch_row($idville);
		$cityID=$result[0];
		$queryAddPOINT = 'INSERT INTO `point`
					(`IDVILLE`, `ADRESSE`,`LATITUDE`,`LONGITUDE`)
					VALUES ('.$cityID.', "'.$address.'", '.$lat.', '.$lng.')';
		$db->query($queryAddPOINT);
		$sqllast="select LAST_INSERT_ID()";
		$idadd= mysql_fetch_row($db->query($sqllast));
		$idpoint=$idadd[0];
		addAddressODMatrix($idpoint, $db);
	}

	$queryAddFav = 'INSERT INTO `favori`
					(`ALIAS`, `COMMENTAIRE`, `PREDEFINI`,`IDPERSONNE`,`IDPOINT`)
					VALUES ("'.$label.'", "'.$comment.'",'.$predefini.','.$userID.','.$idpoint.')';
	$db->query($queryAddFav);
	$db->closeConnexion();
	$succes = true;

}

if(!$succes) {
	echo $output;
}



?>



