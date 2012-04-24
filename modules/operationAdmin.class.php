<?php
/**
 * @package modules
 */
/**
 * 
 * classe qui offre des fonctions pour administrateurs à gérer les pages 
 * @author xudong
 *
 */
class myOperationAdmin {


	function myOperationAdmin(){
		//ne rien faire
	}

	/**
		 * 
		 * opérer les pages
		 * @param String $action
		 *              des actions
		 */
	function doActionAdmin($action) {

		switch($action) {
			case "index" :
				$this->doActionIndex();
				break;
			case "users" :
				$this->doActionUsers();
				break;
			case "matrice" :
				$this->doActionMatrice();
				break;
			case "prefavourite" :
				$this->doActionPrefav();
				break;
			case "problem" :
				$this->doActionProblem();
				break;
			case "ajouterclients" :
				$this->doActionAjouterClients();
				break;
			case "request" :
				$this->doActionRequest();
				break;
			case "aide" :
				$this->doActionAide();
				break;
			case "checkDeconnexion" :
				$this->doActionLogOut();
				break;
			default :
				$this->doActionDefault();
		}
	}
		

	function doActionIndex() {
		include('./pagesmembre/accueilMembre.modinc.php');
		echo " <span class='h3'>Vous êtes bien l'administrateur</span>";
	}
	
function doActionRequest() {
		include('./pagesAdmin/manageRequests.modinc.php');
	}
	
	function doActionUsers() {
		include('./pagesAdmin/manageUsers.modinc.php');
	}
	
function doActionAjouterClients() {
		include('./pagesAdmin/addUsers.modinc.php');
	}
	
	function doActionMatrice() {
		include('./pagesAdmin/manageAddress.modinc.php');
	}
	
	function doActionPrefav() {
		include('./pagesAdmin/definePrefavourite.modinc.php');
	}
	
	
function doActionProblem(){
		include('./pagesAdmin/defineProblem.modinc.php');
	}
	
function doActionAide(){
		include('./pages/aide.modinc.php');
	}


	function doActionLogOut(){
		include('./pagesmembre/checkDeconnexion.modinc.php');
	}

	function doActionDefault(){
		$this->doActionIndex();
	}

}
?>
