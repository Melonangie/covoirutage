<?php
/**
 * @package BD
 */
session_start();
@include_once('../BD/BD.class.php');

/**
 * Add a new address to the OD Matrix, fill the fields to NULL
 * @param bigint $addressID
 * 			      IDPOINT
 * @param BD $DB
 * 			 a database
 */
function addAddressODMatrix($addressID, $DB) {
	$result = $DB->query("SELECT DISTINCT IDPOINT FROM matriceod");
	$existingAdressID=array();
	while($row = $DB->fetchAssoc($result)) {
		$existingAdressID[] = $row['IDPOINT'];
	}
	if(count($existingAdressID)>0)
	{
		for ($i = 0; $i < count($existingAdressID); $i++) {
			$DB->query("INSERT INTO `matriceod` VALUES (".$addressID.", ".$existingAdressID[$i].", NULL, NULL)");
			$DB->query("INSERT INTO `matriceod` VALUES (".$existingAdressID[$i].", ".$addressID.", NULL, NULL)");
		}
	}
	$DB->query("INSERT INTO `matriceod` VALUES (".$addressID.",".$addressID.",1,1)");
}

/**
 *
 * obtenir distance et durée totale d'un trajet sans covoiturage, un trajet est planifié par le système pour la covoiturage
 * @param  array $idfavs
 *               idfavoris du départ
 * @param  bigint $idfavfin
 *               idfavori de la destination
 * @param  BD $db
 *            une base de données
 * @return ArrayObject $inivalue
 *                 un array qui consiste en distance totale et durée totale           
 */
function getValeurini_trajet($idfavs,$idfavfin,$db)
{
	$disini=0;
	$durini=0;
	for($i=0;$i<count($idfavs);$i++)
	{
		$idfav=$idfavs[$i];
		$value=getValueini($idfav,$idfavfin,$db);
		$dis=$value["DISTANCE"];
		$dur=$value["DUREE"];
		$disini+=$dis;
		$durini+=$dur;
	}
	$inivalue=array("DISTANCE"=>$disini,"DUREE"=>$durini);
	return $inivalue;
}

/**
 *
 * obtenir distance et durée entre deux adresses
 * @param bigint $id
 *           un idfavori
 * @param bigint $id1
 *           un autre idfavori
 * @param BD $db
 *          une base de données
 * @return ArrayObject $value
 *                  un array qui consiste en distance et durée entre deux adresses         
 */
function getValueini($id,$id1,$db)
{
	$query = 'SELECT DISTANCE, TIME_TO_SEC(DUREE) AS DUREE
			  FROM `matriceod` inner join favori A1 on `matriceod`.IDPOINT=A1.IDPOINT
			  INNER JOIN favori A2 on `matriceod`.IDPOINT_1=A2.IDPOINT 
				WHERE A1.IDFAVORI = '.$id.' AND A2.IDFAVORI = '.$id1;
	$result = $db->query($query);
	$value = $db->fetchAssoc($result);
	return $value;
}

/**
 * Get the adresses whose distances are setted to NULL
 * @param BD $DB
 * 			a database
 * @return ArrayObject $listDistances
 *                  des adresses dont la distance est null
 */
function getNullDistances($DB) {
	$query = 'SELECT `matriceod`.IDPOINT, A1.`LATITUDE`,A1.`LONGITUDE`, `matriceod`.IDPOINT_1, A2.`LATITUDE`,A2.`LONGITUDE`
			  FROM `matriceod` 
				INNER JOIN `point` AS A1 ON `matriceod`.IDPOINT = A1.`IDPOINT`
				INNER JOIN `point` AS A2 ON `matriceod`.IDPOINT_1 = A2.`IDPOINT`
			  WHERE `DISTANCE` IS NULL';
	$result = $DB->query($query);
	$listDistances=array();
	while($distance = $DB->fetchRow($result)) {
		$listDistances[] = $distance;
	}
	$DB->freeResult($result);
	return $listDistances;
}

/**
 * Get the distance and travel time between two addreses
 * @param bigint $idA
 * 			un idpoint 
 * @param bigint $idB
 * 			un autre idpoint
 * @param BD $DB
 * 			 a database
 * @return ArrayObject $distance
 *          un array qui consiste en distance et durée entre deux adresses
 */
function getDistance($idA,$idB,$DB) {
	$query = 'SELECT DISTANCE, DUREE
			  FROM `matriceod` 
			  WHERE IDPOINT='.$idA.' AND IDPOINT_1='.$idB;
	$result = $DB->query($query);
	$distance = $DB->fetchAssoc($result);
	$DB->freeResult($result);
	return $distance;
}

/**
 * update destance et durée entre deux adresses
 * @param bigint $idA
 *                un idpoint
 * @param bigint $idB
 *                un autre idpoint
 * @param decimal $distance
 *              distance entre deux adresses
 * @param time $time
 *               durée entre deux adresses
 @param BD $DB
 * 			 a database              
 */
function setDistance($idA, $idB, $distance, $time, $DB) {
	$query = 'UPDATE `matriceod`
			  SET `DISTANCE` = '.$distance.', `DUREE` = SEC_TO_TIME('.$time.')
			  WHERE `IDPOINT` = "'.$idA.'" AND `IDPOINT_1`= "'.$idB.'"';
	$result = $DB->query($query);
	return $query;
}

if(isset($_POST['setDistance']) && isset($_POST['idA']) && isset($_POST['idB'])
&& isset($_POST['distance']) && isset($_POST['time'])) {
	$db = new BD();
	$res = setDistance($_POST['idA'], $_POST['idB'], $_POST['distance'], $_POST['time'], $db);
	$db->closeConnexion();
	//echo($res);
}

if(isset($_POST['getDistance']) && isset($_POST['idA']) && isset($_POST['idB']))
{
	$db = new BD();
	$res =  json_encode(getDistance($_POST['idA'],$_POST['idB'],$db));
	$db->closeConnexion();
	echo($res);
}

if(isset($_POST['getNullDistances'])) {
	$db = new BD();
	$res =  json_encode(getNullDistances($db));
	$db->closeConnexion();
	echo($res);
}
?>