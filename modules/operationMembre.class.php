<?php
/**
 * @package modules
 */
/**
 * 
 * classe qui offre des fonctions pour membres à gérer les pages 
 * @author xudong
 *
 */
class myOperationMembre {
	

	function myOperationMembre(){
		//ne rien faire
	}
		
		/**
		 * 
		 * opérer les pages
		 * @param String $action
		 *              des actions
		 */
	function doActionMembre($action) {
	
		switch($action) {
			case "index" :
				$this->doActionMembre1();
				break;
			case "favoris" :
				$this->doActionMembre2();
				break;
			case "validationFavoris" :
				$this->doActionMembre3();
				break;
			case "checkDeconnexion" :
				$this->doActionMembre4();
				break;
			case "horaire" :
				$this->doActionMembre5();
				break;
			case "validationHoraire" :
				$this->doActionMembre6();
				break;
			case "itineraire" :
				$this->doActionMembre7();
				break;
			case "consulter" :
				$this->doActionMembre8();
				break;	
			case "aide" :
				$this->doActionAide();
				break;	
			default : 
				$this->doActionMembre1();		
		}
	}
					
	
	function doActionMembre1() {	
		include('./pagesmembre/accueilMembre.modinc.php');
	}
	
	function doActionMembre2() {
		include('./pagesmembre/favoris.modinc.php');
	
	}
	
	function doActionMembre3(){
		include('./pagesmembre/validationFavoris.checkinc.php');	
	}
	
	function doActionMembre4(){
		include('./pagesmembre/checkDeconnexion.modinc.php');	
	}
	
	function doActionMembre5(){
		include('./pagesmembre/horaire.modinc.php');	
	}
	
function doActionAide(){
		include('./pages/aide.modinc.php');
	}
			
	function doActionMembre6(){
		include('./pagesmembre/validationHoraire.checkinc.php');
	}
	
	function doActionMembre7(){
		include('./pagesmembre/formDistance.php');	
	}
	
	function doActionMembre8(){
		include('./pagesmembre/consulter.modinc.php');	
	}
		
}
?>
