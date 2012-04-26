<?php
 /**
 * @package traitement
 */
session_start();
header("Content-Type: text/plain");

$idMembre = $_SESSION['id'];

include('../BD/BD.class.php');
include('../BD/Request.func.php');

 /***** IDENTIFIANT PERSONNE ******/
 

if (isset($_POST['source']) && isset($_POST['outward_date']) && isset($_POST['outward_time'])) 
{	
		 $madb = new BD();
		 
		 $depart = $_POST['source'];
		 		
		/**********	TABLE REQUETES************/

		// récupération d'une date correctement :
		
		include('../modules/fonctionsUtiles.php');
		
		$maDate = formatDate($_POST['outward_date'],$_POST['outward_time']);
		
		if($maDate != null){ 
				
			// On verifie si la requete pour une même date n'a pas déjà été faite par notre utilisateur
			$requeteDejaEnvoye =  $madb->query("SELECT id FROM requete WHERE personne_id='".$_SESSION['id']."' AND jourSouhaitee='".$maDate."'");
			
			$analyse = mysql_fetch_array($requeteDejaEnvoye);
							
			mysql_free_result($requeteDejaEnvoye);
			
			if($analyse['id'] != null){			
				echo "Suppressions ancienne requete pour cette même date : OK ";
				$delete = $madb->query("DELETE FROM requete WHERE id='".$analyse['id']."'");
			}			
			$reponserequete = $madb->query("INSERT INTO requete VALUES (NULL,".$idMembre.",'".htmlentities($depart)."','".$maDate."')");
			echo "Envoi requete : OK";
			
		}
		
		$madb->closeConnexion();

}
else
	echo "FAIL";
	
?>

