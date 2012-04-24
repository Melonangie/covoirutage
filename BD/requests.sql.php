<?php
/**
 * @package BD
 */
//session_start();

@include_once('../BD/BD.class.php');
@include_once('../BD/favourites.sql.php');

/**
 * obtenir toutes les requettes d'un utilisateur
 * @param bigint $userID
 * 				the user ID
 * @param BD $DB
 * 			 a database
 * @return ArrayObject $listUsers
 * 			the list of user's request IDs
 */
function getUserRequests($userID, $DB) {
	$query = 'SELECT `IDREQUETE`
			  FROM `requete`
			  WHERE `IDPERSONNE` = '.$userID;
	$result = $DB->query($query);
	while($user = $DB->fetchAssoc($result)) {
		$listUsers[] = $user['IDREQUETE'];
	}
	$DB->freeResult($result);
	return $listUsers;
}

/**
 *
 * obtenir les informations(temps de départ,adresse...) du départ d'une requête
 * @param bigint $idrequete
 *                  ID d'une requête
 * @param BD $DB
 *               une base de données
 * @return ArrayObject $favarr
 *               les informations(temps de départ,adresse...) du départ d'une requête
 */
function getfav_debut($idrequete,$DB)
{
	$query="select HEUREDEBUT,HEUREFIN,DATE,ALIAS,ADRESSE,CONDUCTEUR,NOM,NOMPAYS from requete inner join passepar on requete.IDREQUETE=passepar.IDREQUETE inner join favori on passepar.IDFAVORI=favori.IDFAVORI INNER JOIN point ON favori.IDPOINT=point.IDPOINT INNER JOIN ville ON point.IDVILLE=ville.ID_VILLE inner join departement on ville.ID_DEPARTEMENT=departement.ID_DEPARTEMENT inner join pays on departement.IDPAYS=pays.IDPAYS where passepar.NUMORDRE='1' and requete.IDREQUETE='".$idrequete."'";
	$result = $DB->query($query);
	$favarr = $DB->fetchAssoc($result);
	$DB->freeResult($result);
	return $favarr;
}

/**
 *
 * obtenir latitude,longitude de l'adresse du départ d'une reqête
 * @param bigint $idrequete
 *                   IDREQUETE
 * @param BD $DB
 *          une base de données
 * @return ArrayObject $favarr
 *                    latitude et logitude de l'adresse du départ d'une reqête
 */
function getposition_debut($idrequete,$DB)
{
	$query="select LATITUDE,LONGITUDE from requete inner join passepar on requete.IDREQUETE=passepar.IDREQUETE inner join favori on passepar.IDFAVORI=favori.IDFAVORI INNER JOIN point ON favori.IDPOINT=point.IDPOINT where passepar.NUMORDRE='1' and requete.IDREQUETE='".$idrequete."'";
	$result = $DB->query($query);
	$favarr = $DB->fetchAssoc($result);
	$DB->freeResult($result);
	return $favarr;
}

/**
 *
 * obtenir les informations(temps de départ,adresse...) de la destination d'une requête
 * @param bigint $idrequete
 *                  ID d'une requête
 * @param BD $DB
 *               une base de données
 * @return ArrayObject $favarr
 *               les informations(temps de départ,adresse...) de la destination d'une requête
 */
function getfav_fin($idrequete,$DB)
{
	$query="select HEUREDEBUT,HEUREFIN,DATE,ALIAS,ADRESSE,CONDUCTEUR,NOM,NOMPAYS from requete inner join passepar on requete.IDREQUETE=passepar.IDREQUETE inner join favori on passepar.IDFAVORI=favori.IDFAVORI INNER JOIN point ON favori.IDPOINT=point.IDPOINT inner join ville on point.IDVILLE=ville.ID_VILLE inner join departement on ville.ID_DEPARTEMENT=departement.ID_DEPARTEMENT inner join pays on departement.IDPAYS=pays.IDPAYS where passepar.NUMORDRE='2' and requete.IDREQUETE='".$idrequete."'";
	$result = $DB->query($query);
	$favarr = $DB->fetchAssoc($result);
	$DB->freeResult($result);
	return $favarr;
}

/**
 *
 * obtenir latitude,longitude de l'adresse de la destination d'une reqête
 * @param bigint $idrequete
 * @param BD $DB
 *             une base de données
 * @return ArrayObject $favarr
 *                    latitude et logitude de l'adresse de la destination d'une reqête
 */
function getposition_fin($idrequete,$DB)
{
	$query="select LATITUDE,LONGITUDE from requete inner join passepar on requete.IDREQUETE=passepar.IDREQUETE inner join favori on passepar.IDFAVORI=favori.IDFAVORI INNER JOIN point ON favori.IDPOINT=point.IDPOINT where passepar.NUMORDRE='2' and requete.IDREQUETE='".$idrequete."'";
	$result = $DB->query($query);
	$favarr = $DB->fetchAssoc($result);
	$DB->freeResult($result);
	return $favarr;
}

/**
 *
 * obtenir tous les états d'une requête
 * @param bigint $idrequete
 * @param BD $db
 *          une base de données
 * @return ArrayObject $listEtatRe
 *                      liste des états  
 */
function get_Etats_Requete($idrequete,$db)
{
	$sql="select * from `change` inner join etat on `change`.IDETAT=etat.IDETAT where IDREQUETE=".$idrequete." order by DATECHANGEMENT DESC";
	$result = $db->query($sql);
	while($etatre = $db->fetchAssoc($result))
	{
		$listEtatRe[] = $etatre;
	}
	$db->freeResult($result);
	return $listEtatRe;
}

/**
 * Add a non periodic request to the database
 * @param bigint $userID
 * 			the user ID
 * @param tinyint $driver
 * 			1 if the user can be the driver, 0 else
 * @param BD $DB
 * 			 a database
 * @return bigint $requestID[0]
 * 			the new request ID
 */
function addUserSingleRequest($userID, $driver,$DB) {
	$query = 'INSERT INTO `requete`
			  VALUES
			  ("", '.$userID.', '.$driver.',null)';
	$DB->query($query);
	$result = $DB->query("SELECT LAST_INSERT_ID()");
	$requestID = mysql_fetch_row($result);
	return $requestID[0];
}

if(isset($_POST['addSingleRequest']) && isset($_POST['addressDlat']) && isset($_POST['addressAlat'])
&& isset($_POST['dateD']) && isset($_POST['dateA']) && isset($_POST['timeDStr'])
&& isset($_POST['timeDStp']) && isset($_POST['timeAStr']) && isset($_POST['timeAStp'])
&& isset($_POST['driver'])) {
	$db = new BD();
	$res = addUserSingleRequest($_SESSION['id'],$_POST['driver'],$db);
	changer_Etat("A prendre en charge",$res,$db);
	$favD_ID = getFavID($_SESSION['id'],$db,$_POST['addressDlat'],$_POST['addressDlng']);
	$favA_ID = getFavID($_SESSION['id'],$db,$_POST['addressAlat'],$_POST['addressAlng']);
	$inserpassD="insert into passepar values(".$res.",".$favD_ID.",1,'".$_POST['timeDStr']."','".$_POST['timeDStp']."','".$_POST['dateD']."')";
	$inserpassA="insert into passepar values(".$res.",".$favA_ID.",2,'".$_POST['timeAStr']."','".$_POST['timeAStp']."','".$_POST['dateA']."')";
	$db->query($inserpassD);
	$db->query($inserpassA);
	$db->closeConnexion();
	echo($res);
}



if(isset($_POST['defineProblem']) && isset($_POST['dateD']) && isset($_POST['dateA']) && isset($_POST['timeDStr'])
&& isset($_POST['timeAStr']) && isset($_POST['addressAlat']) )
{
	$db = new BD();
	$favid=getFavID(0,$db,$_POST['addressAlat'],$_POST['addressAlng']);
	$insertpro="insert into probleme values('','".$_POST['dateD']."','".$_POST['timeDStr']."','".$_POST['dateA']."','".$_POST['timeAStr']."',".$favid.",'Prise en charge')";
	$db->query($insertpro);
	$resultinsert = $db->query("SELECT LAST_INSERT_ID()");
	$proID = mysql_fetch_row($resultinsert);
	$proplemid=$proID[0];
	$resu1 = $db->query("SELECT TIME_TO_SEC(TIMEBEGIN),TO_DAYS(DATEBEGIN),TIME_TO_SEC(TIMEOVER),TO_DAYS(DATEOVER) from probleme where IDPROBLEME=".$proplemid);
	$resultime = mysql_fetch_row($resu1);
	$time0=$resultime[0];
	$time1=$resultime[2];
	$dateD=$resultime[1];
	$dateA=$resultime[3];
	$query="select TO_DAYS(p1.DATE) AS DATE,TIME_TO_SEC(p1.HEUREFIN) AS HEUREFIN,p1.IDREQUETE from passepar p1 inner join passepar p2 on p1.IDREQUETE=p2.IDREQUETE where p2.IDFAVORI=".$favid." and p1.NUMORDRE='1' and p2.NUMORDRE='2' and TO_DAYS(p1.DATE)>=".$dateD." and TO_DAYS(p1.DATE)<=".$dateA;
	$result = $db->query($query);
	while($requte = $db->fetchAssoc($result))
	{
		if(($requte['DATE']>$dateD && $requte['DATE']<$dateA)
		|| ($requte['DATE']==$dateD && $requte['HEUREFIN']>=$time0)
		||($requte['DATE']==$dateA && $requte['HEUREFIN']<$time1))
		{
			$idre=$requte['IDREQUETE'];
			if(changer_Etat("Prise en charge",$idre,$db))
			{
				$insertcom="insert into comporte values (".$idre.",".$proplemid.")";
				$db->query($insertcom);
			}
			else
			continue;
		}

	}
	$db->freeResult($result);
	$db->closeConnexion();
}

/**
 *
 * changer l'état de la requête
 * Etat peut être Effectué,A prendre en charge, Non traité, Satisfait, Non satisfait or Prise en charge
 * @param varchar $order
 *                 état de la requête
 * @param bigint $idrequete
 * @param BD $bd
 *              une base de données
 */
function changer_Etat($order,$idrequete,$bd)
{
	$resultetat= $bd->query("SELECT * FROM `change` WHERE IDREQUETE=".$idrequete." AND IDETAT=(select IDETAT from etat where INTITULE='".$order."')");
	if(mysql_fetch_row($resultetat))
	$allow=false;
	else
	{
		$requ="select IDETAT from etat where INTITULE='".$order."'";
		$resl=$bd->query($requ);
		$idetat=mysql_fetch_row($resl);
		$id=$idetat[0];
		$now=date('Y-m-d H:i:s');
		$sql="insert into `change` values(".$idrequete.",".$id.",'".$now."')";
		$bd->query($sql);
		$allow=true;
	}
	return $allow;
}

/**
 *
 * obtenir favoriID selon latitude ,longitude d'un client
 * @param bigint $userid
 *                IDPERSONNE
 * @param BD $BD
 *             une base de données
 * @param decimal $lat
 *                latitude
 * @param decimal $lng
 *                 longitude
 * @return bigint $arr[0]
 *            IDFAVORI  
 */
function getFavID($userid,$BD,$lat,$lng)
{
	$query =	"select IDFAVORI FROM `favori`".
				"INNER JOIN point ON favori.IDPOINT=point.IDPOINT WHERE (`IDPERSONNE` ='".$userid."' OR `IDPERSONNE` =0) AND `LATITUDE`='".$lat."' AND `LONGITUDE`='".$lng."'";

	$res=$BD->query($query);
	$arr=mysql_fetch_row($res);
	return $arr[0];
}


/**
 *
 * obtenir problèmes définis
 * @param BD $BD
 *           une base de données
 * @return ArrayObject $listPros
 *              liste de problèmes
 */
function getProblems($BD)
{
	$query = 'select IDPROBLEME,DATEBEGIN,TIMEBEGIN,DATEOVER,TIMEOVER,probleme.COMMENTAIRE,probleme.IDFAVORI,ALIAS,LATITUDE,LONGITUDE from probleme inner join favori on probleme.IDFAVORI=favori.IDFAVORI inner join point on favori.IDPOINT=point.IDPOINT';
	$result = $BD->query($query);
	$listPros=array();
	while($pro = $BD->fetchAssoc($result)) {
		$listPros[] = $pro;
	}
	$BD->freeResult($result);
	return $listPros;
}

/**
 *
 * changer l'état d'un problème
 * Etat peut être Non traité, Satisfait, Non satisfait,or Prise en charge
 * @param char $order
 *                 l'état d'un problème
 * @param bigint $idpro
 *                IDPROBLEME 
 * @param BD $bd
 *            une base de données
 */
function changer_Etat_Pro($order,$idpro,$bd)
{
	$sql="update `probleme` set COMMENTAIRE='".$order."' where IDPROBLEME=".$idpro;
	$bd->query($sql);
}


/**
 *
 * obtenir toutes les requêtes d'un problème
 * @param BD $BD
 *              une base de données
 * @param bigint $IDPRO
 *               IDPROBLEME
 * @return ArrayObject $listRes
 *           liste de IDREQUETE d'un problème
 */
function getProDetail($BD,$IDPRO)
{
	$query = 'SELECT `requete`.`IDREQUETE`
			  FROM `probleme` INNER JOIN `comporte` ON `probleme`.`IDPROBLEME`=`comporte`.`IDPROBLEME` INNER JOIN `requete` ON `comporte`.`IDREQUETE`=`requete`.`IDREQUETE` WHERE `probleme`.`IDPROBLEME`='.$IDPRO;
	$result = $BD->query($query);
	$listRes=array();
	while($requ = $BD->fetchAssoc($result)) {
		$listRes[] = $requ['IDREQUETE'];
	}
	$BD->freeResult($result);
	return $listRes;
}

/**
 *
 * obtenir tous les IDrequêtes
 * @param BD $DB
 *             une base de données
 * @return ArrayObject $listReqs
 *           liste de IDREQUETE
 */
function getAllRequests($DB) {
	$query = 'SELECT IDREQUETE
			  FROM requete';
	$result = $DB->query($query);
	while($req = $DB->fetchAssoc($result)) {
		$listReqs[] = $req['IDREQUETE'];
	}
	$DB->freeResult($result);
	return $listReqs;
}

/**
 *
 * obtenir le trajet et ordre du trajet d'une requête
 * @param BD $DB
 *             une base de données
 * @param bigint $idrequete
 * @return ArrayObject $req
 *             IDTRAJET et ORDRE de la requête dans ce trajet  
 */
function getIDtrajetparrequete($DB,$idrequete) {
	$query = 'SELECT IDTRAJET,NUMORDRE FROM prevision WHERE IDREQUETE='.$idrequete;
	$result = $DB->query($query);
	$req = $DB->fetchAssoc($result);
	return $req;
}

/**
 *
 * obtenir les adresses que le trajet parcourt d'un client, par exemple, un client dont l'ordre est 2 dans un trajet, les adresses dont l'ordre est plus que 2 dans ce trajet sont obtenues
 * cette fonction est développée pour les clients à visualiser son trajet quand sa requête est satisfaite
 * @param  BD $DB
 *              une base de données
 * @param bigint $idtrajet
 * @param int $ordre
 *            ordre du client dans le trajet
 * @return ArrayObject $listReqs
 *            positions géographyques des adresses parcouvertes d'un client dans un trajet
 */
function getTrajetparRequete($DB,$idtrajet,$ordre) {
	$query = 'SELECT LATITUDE,LONGITUDE FROM point INNER JOIN favori ON point.IDPOINT=favori.IDPOINT INNER JOIN routeprev ON favori.IDFAVORI=routeprev.IDFAVORI WHERE routeprev.IDTRAJET='.$idtrajet.' AND routeprev.ORDRE>'.$ordre.' ORDER BY routeprev.ORDRE ASC';
	$result = $DB->query($query);
	while($req = $DB->fetchAssoc($result)) {
		$listReqs[] = $req;
	}
	$DB->freeResult($result);
	return $listReqs;
}
?>