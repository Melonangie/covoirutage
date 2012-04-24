<?php
/**
 * @package BD
 */

@include_once('./BD.class.php');


/**
 *
 * Obtenir les favoris prédéfinis par administrateurs, par exemple Université d'Artois(Lens)
 * @param BD $DB
 *         une base de données
 * @return ArrayObject $listFav
 *           un array de favoris prédéfinis
 */
function getPrefavourites($DB) {
	$result = $DB->query("
		SELECT ADRESSE, LATITUDE, LONGITUDE,PREDEFINI, NOM, NOMPAYS, ALIAS, COMMENTAIRE, CP
		FROM favori INNER JOIN point ON favori.IDPOINT=point.IDPOINT INNER JOIN ville ON point.IDVILLE = ville.ID_VILLE INNER JOIN departement ON ville.ID_DEPARTEMENT = departement.ID_DEPARTEMENT INNER JOIN pays ON departement.IDPAYS=pays.IDPAYS
		WHERE favori.PREDEFINI = 1
	");
	while($fav = $DB->fetchAssoc($result)) {
		$listFav[] = $fav;
	}
	$DB->freeResult($result);
	return $listFav;
}



/**
 * obtenir tous les favoris d'un utilisateur
 * @param bigint $id
 * 		  the user ID
 * @param BD $DB
 * 			 a database
 * @return ArrayObject $listFav
 *                      tous les favoris d'un utilisateur
 */
function getUserFavourites($id,$DB) {
	$result = $DB->query("
		(SELECT ADRESSE, LATITUDE, LONGITUDE,PREDEFINI, NOM, NOMPAYS, ALIAS, COMMENTAIRE, CP
		FROM favori INNER JOIN point ON favori.IDPOINT=point.IDPOINT INNER JOIN ville ON point.IDVILLE = ville.ID_VILLE INNER JOIN departement ON ville.ID_DEPARTEMENT = departement.ID_DEPARTEMENT INNER JOIN pays ON departement.IDPAYS=pays.IDPAYS
		WHERE favori.IDPERSONNE = '".$id."')
		UNION
		(SELECT ADRESSE, LATITUDE, LONGITUDE,PREDEFINI, NOM, NOMPAYS, ALIAS, COMMENTAIRE, CP
		FROM favori INNER JOIN point ON favori.IDPOINT=point.IDPOINT INNER JOIN contientf ON favori.IDFAVORI=contientf.IDFAVORI INNER JOIN groupe ON contientf.IDGROUPE=groupe.IDGROUPE INNER JOIN appartientg ON groupe.IDGROUPE=appartientg.IDGROUPE INNER JOIN ville ON point.IDVILLE = ville.ID_VILLE INNER JOIN departement ON ville.ID_DEPARTEMENT = departement.ID_DEPARTEMENT INNER JOIN pays ON departement.IDPAYS=pays.IDPAYS
		WHERE appartientg.IDPERSONNE = '".$id."')
	");
	while($fav = $DB->fetchAssoc($result)) {
		$listFav[] = $fav;
	}
	$DB->freeResult($result);
	return $listFav;
}

/**
 * Return an array containing all the addresses
 * @param BD $DB
 * 			 a database
 * @return ArrayObject $listADR
 *           an array of addresses
 */
function getAddresses($DB) {
	$result = $DB->query("
		SELECT IDPOINT, ADRESSE,LATITUDE,LONGITUDE,NOM,NOMPAYS
		FROM point INNER JOIN ville ON point.IDVILLE = ville.ID_VILLE INNER JOIN departement 
		ON ville.ID_DEPARTEMENT = departement.ID_DEPARTEMENT 
		INNER JOIN pays ON departement.IDPAYS=pays.IDPAYS");		
	while($fav = $DB->fetchAssoc($result)) {
		$listADR[] = $fav;
	}

	$DB->freeResult($result);
	return $listADR;
}

/**
 *
 * Obtenir IDPOINT en fonction de latitude et de longitude d'une adresse
 * @param BD $DB
 *              une base de données
 * @param decimal $lat
 *                 latitude de l'adresse
 * @param decimal $lng
 *                 longitude de l'adresse
 * @return bigint $idpoint
 *                 idpoint d'adresse 
 */
function getIDPOINT($DB,$lat,$lng)
{
	$sql="select IDPOINT from point where LATITUDE=".$lat." and LONGITUDE=".$lng;
	$result=$DB->query($sql);
	if($id = $DB->fetchAssoc($result))
	$idpoint=$id["IDPOINT"];
	else
	$idpoint=null;
	return $idpoint;
}




/**
 *
 * Obtenir les informations(nom,prénom,adresse) de tous les clients.
 * Cette fonction obtient les informations de tous les clients une fois, pour éviter se connecter à la BD plusieur fois
 * @param BD $DB
 *             une base de données
 * @return ArrayObject $listINFO
 *                 un array des information de tous les clients
 */
function getInfo_client($DB) {
	$query = 'SELECT NOM, PRENOM, LATITUDE, LONGITUDE, ALIAS
FROM personne
RIGHT OUTER JOIN favori ON personne.IDPERSONNE = favori.IDPERSONNE INNER JOIN point ON favori.IDPOINT=point.IDPOINT';
	$result = $DB->query($query);
	while($infos = $DB->fetchAssoc($result))
	{
		$listINFO[] = $infos;
	}
	$DB->freeResult($result);
	return $listINFO;
}



if(isset($_POST['getinfo']))
{
	$db = new BD();
	$res =  json_encode(getInfo_client($db));
	$db->closeConnexion();
	echo($res);
}

?>