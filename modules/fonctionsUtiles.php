<?php
/**
 * @package modules
 */


/**
 * Fonction qui adapte la date provenant du DatePicker pour être insérer dans la base de données avec le bon format
 */
function formatDate($date,$time){
	$montableauDate = explode("/",$date);
	if(sizeof($montableauDate) == 3){
		$maDateFormat = $montableauDate[2].'-'.$montableauDate[1].'-'.$montableauDate[0];
		$maDateFormat = $maDateFormat." ".$time.":00:00";
		return $maDateFormat;
	}
	else
	return null;
}


/**
 *Fonction permettant de transposer un tableau PHP en tableau JS 
 * 
 * 
 */
function php2js ($var) {
	if (is_array($var)) {
		$res = "[";
		$array = array();
		 
		foreach ($var as $a_var) {
			$array[] = php2js($a_var);
		}
		return "[" . join(",", $array) . "]";
	}
	elseif (is_bool($var)) {
		return $var ? "true" : "false";
	}
	elseif (is_int($var) || is_integer($var) || is_double($var) || is_float($var)) {
		return $var;
	}
	elseif (is_string($var)) {
		return "\"" . addslashes(stripslashes($var)) . "\"";
	}
	// autres cas: objets, on ne les gère pas
	return FALSE;
}


/**
 *avant de supprimer ou modifier un favori, vérifier si le favori est utilisé dans un trajet 
 * 
 * @param decimal $lat
 *                  latitude de l'adresse
 * @param decimal $lng
 *                longitude de l'adreese
 * @param bigint $userID
 *                  idpersonne
 */
function fav_utilise($lat,$lng,$userID)
{
	$db = new BD();
	$result=$db->query("SELECT IDFAVORI FROM `favori` INNER JOIN point ON favori.IDPOINT=point.IDPOINT WHERE `IDPERSONNE`='".$userID."' AND point.`LATITUDE`='".$lat."' AND point.`LONGITUDE`='".$lng."'");
	$arr=mysql_fetch_row($result);
	$favID=$arr[0];
	$check="SELECT INTITULE FROM favori INNER JOIN passepar ON favori.IDFAVORI=passepar.IDFAVORI INNER JOIN requete ON passepar.IDREQUETE=requete.IDREQUETE INNER JOIN `change` ON requete.IDREQUETE=`change`.IDREQUETE INNER JOIN etat ON `change`.IDETAT=etat.IDETAT WHERE favori.IDFAVORI='".$favID."'";
	$recheck=$db->query($check);
	$reponse=$favID;
	while($arrfav=mysql_fetch_row($recheck))
	{
		if($arrfav[0]!="Effectué" && $arrfav[0]!="Non traité" && $arrfav[0]!="Non satisfait")
		{$reponse=null;
		break;}
	}
	$db->closeConnexion();
	return $reponse;
}


/**
 * 
 * Afficher options des couleurs pour checkbox 
 */
function Html_Option()
{
	$couleurs=array("#FF0000","#495CFF","#D400FF","#B9121B","#05966D","#5EB6DD","#8FCF3C","#FFB6B8","#FF5B2B","#B78178","#2F574D");
	$options="<option value='0'>Couleur</option>";
	for($nc=0;$nc<count($couleurs);$nc++)
	{
	$options.="<option value='".$couleurs[$nc]."'  style='background:".$couleurs[$nc]."'></option>";	
	}
    echo $options;
}

?>