<?php
/**
 * @package modules
 */
/**
 * 
 * classe qui offre des fonctions à opérer le compte
 * @author xudong
 *
 */
class myOperation {
	

	function myOperation(){
		//ne rien faire
	}
		/**
		 * 
		 * opérer les pages
		 * @param String $action
		 *              des actions
		 */
	function doAction($action) {
	
		switch($action) {
			case "index" :
				$this->doAction1();
				break;
			case "presentation" : 
				$this->doAction2();
				break;	
			case "documentation" :
				$this->doAction3();
				break;
			case "checkConnexion" :
				$this->doAction4();
				break;				
			case "inscription" :
				$this->doAction5();
				break;
			case "triche" :
				$this->doAction404();
				break;
			default : 
				$this->doAction1();		
		}
	}
					
	
	function doAction1() {	
		include('./pages/accueil.inc.php');	
	}
	
	function doAction2() {	
		include('./pages/presentation.inc.php');	
	}
		
	function doAction3() {
		include('./pages/documentation.inc.php');
	}
	
	function doAction4(){
		include('./pages/checkConnexion.modinc.php');	
	}
			
	function doAction5(){
		include('./pages/inscription.modinc.php');	
	}
	
	function doAction404(){
		include('./pages/triche.inc.php');	
	}
	
		
}
?>
