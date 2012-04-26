<?php
 /**
 * @package pages
 */
/**
 * 
 * transformer String pour SQL et HTML
 * @param String $valeur
 *           String à transformer
 * @return String $valeur
 *            String après transformation
 */
function protection($valeur) {
    $valeur = str_replace("'","",$valeur);
    $valeur = str_replace('"','',$valeur);
    $valeur = str_replace("<","",$valeur);
    $valeur = str_replace(">","",$valeur);
    $valeur = addslashes($valeur);
    $valeur = htmlspecialchars($valeur);
    $valeur = htmlentities($valeur);
    return $valeur;

    }
	
?>