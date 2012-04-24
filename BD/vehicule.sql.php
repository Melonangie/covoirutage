<?php
/**
 * @package BD
 */
/**
 * ajouter un véhicule dans la base de données
 * @param char $imma
 *               IMMATRICULATION du véhicule
 * @param bigint $per_id
 *                idpersonne de ce véhicule
 * @param int $nbplace
 *             nombre de places du véhicule
 * @param BD $DB
 *           une base de données
 */
function addVoiture($imma,$per_id,$nbplace,$DB)
{
	$imma = $DB->escapeString($imma);
	$query = 'INSERT INTO `vehicule`
			  VALUES ("'.$imma.'","'.$per_id.'","'.$nbplace.'")';
	$result = $DB->query($query);
}
?>