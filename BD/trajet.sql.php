<?php
/**
 * @package BD
 */
/**
 *
 * obtenir trajets d'un problème
 * @param BD $BD
 *           une base de données
 * @param bigint $IDPRO
 *              un idproblème
 * @return ArrayObject $listTra
 *                      liste de idtrajets d'un problème
 *              
 */
function getTrajetsParPro($BD,$IDPRO)
{
	$query = 'SELECT IDTRAJET
			  FROM `contient` WHERE `IDPROBLEME`='.$IDPRO;
	$result = $BD->query($query);
	$listTra=array();
	while($tras = $BD->fetchAssoc($result)) {
		$listTra[] = $tras['IDTRAJET'];
	}
	$BD->freeResult($result);
	return $listTra;
}

/**
 *
 * obtenir idfavoris d'un trajet, idfavoris sont triés par l'ordre
 * @param BD $BD
 *            une base de données
 * @param bigint $IDTRA
 *               un idtrajet
 * @return ArrayObject $listFav
 *                     liste de idfavoris triés par l'ordre             
 */
function getFavParTra($BD,$IDTRA)
{
	$query = 'SELECT IDFAVORI,ORDRE
			  FROM `routeprev` WHERE `IDTRAJET`='.$IDTRA.' ORDER BY ORDRE ASC';
	$result = $BD->query($query);
	$listFav=array();
	while($fav = $BD->fetchAssoc($result)) {
		$listFav[] = $fav['IDFAVORI'];
	}
	$BD->freeResult($result);
	return $listFav;
}

/**
 *
 * obtenir latitude et longitude d'un favori
 * @param bigint $IDFAV
 *                  idfavori
 * @param BD $DB
 *             une base de données
 * @return ArrayObject $fav
 *                  latitude et longitude d'un favori    
 */
function getPositionFav($IDFAV,$DB) {
	$result = $DB->query("
		SELECT LATITUDE, LONGITUDE
		FROM favori inner join point on favori.IDPOINT=point.IDPOINT
		WHERE IDFAVORI=".$IDFAV
	);
	if($fav = $DB->fetchAssoc($result))
	return $fav;
}

/**
 *
 * obtenir distance et durée d'un trajet planifié
 * @param BD $BD
 *              une base de données
 * @param bigint $IDTRAJET
 *               un idtrajet
 * @return ArrayObject $tras
 *                distance et durée d'un trajet planifié 
 */
function getValeurPre_Trajet($BD,$IDTRAJET)
{
	$query = 'SELECT DISTANCE,TIME_TO_SEC(DUREE) AS DUREE
			  FROM `trajet` WHERE `IDTRAJET`='.$IDTRAJET;
	$result = $BD->query($query);
	$tras = $BD->fetchAssoc($result);
	$BD->freeResult($result);
	return $tras;
}

/**
 *
 * obtenir informations des clients d'un trajet
 * @param BD $BD
 *           une basze de données
 * @param bigint $IDTRA
 *                un idtrajet
 * @return ArrayObject $listInfo
 *               informations des clients d'un trajet
 */
function getinfoclientParTra($BD,$IDTRA)
{
	$query = 'SELECT NOM,PRENOM
			  FROM `routeprev` INNER JOIN `favori` ON `routeprev`.IDFAVORI=`favori`.IDFAVORI INNER JOIN  `personne` ON `favori`.IDPERSONNE=`personne`.IDPERSONNE
			   WHERE `routeprev`.`IDTRAJET`='.$IDTRA.' ORDER BY `routeprev`.ORDRE ASC';
	$result = $BD->query($query);
	$listInfo=array();
	while($fav = $BD->fetchAssoc($result)) {
		$listInfo[] = $fav;
	}
	$BD->freeResult($result);
	return $listInfo;
}

/**
 *
 * obtenir distance et durée entre chaque client et destination d'un trajet sans covoiturage trié par l'ordre
 * @param BD $BD
 *           une base de données
 * @param bigint $IDTRA
 *                un idtrajet
 * @param bigint $IDFAVFIN
 *                     idfavori de la destination
 * @return ArrayObject $listInfo
 *             distance et durée entre chaque client et destination d'un trajet sans covoiturage trié par l'ordre            
 */
function getvaluesParPer($BD,$IDTRA,$IDFAVFIN)
{
	$sql="select IDPOINT from favori where IDFAVORI=".$IDFAVFIN;
	$resu = $BD->query($sql);
	$fid = $BD->fetchAssoc($resu);
	$idfinpoint=$fid["IDPOINT"];
	$query = 'SELECT DISTANCE,DUREE
			  FROM `matriceod` INNER JOIN favori on matriceod.IDPOINT=favori.IDPOINT inner join `routeprev` ON `favori`.IDFAVORI=`routeprev`.IDFAVORI
			   WHERE `routeprev`.`IDTRAJET`='.$IDTRA.' AND `matriceod`.IDPOINT_1='.$idfinpoint.' ORDER BY `routeprev`.ORDRE ASC';
	$result = $BD->query($query);
	$listInfo=array();
	while($fav = $BD->fetchAssoc($result)) {
		$listInfo[] = $fav;
	}
	$BD->freeResult($result);
	return $listInfo;
}
?>