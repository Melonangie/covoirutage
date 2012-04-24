<?php
session_start();
include_once('./modules/operation.class.php'); // ici pour les operations " classiques "
include_once('./modules/operationMembre.class.php'); // ici pour les operations des membres
include_once('./modules/operationAdmin.class.php'); // ici pour les operations de l'Administrateur
include_once('./BD/BD.class.php');
$boolMember = 0; // boolean de contrôle de membre
$boolTriche = 0 ; // boolean de contrôle de triche
$boolAdmin = 0 ; // boolean de contrôle de d'administrateur
if (isset($_SESSION['admin'])) {
	$boolAdmin = 1;
}
if (isset($_SESSION['login'])) {
	$boolMember = 1;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta content="text/html; Charset=UTF-8" http-equiv="Content-Type" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Application Google Maps : Système de Covoiturage</title>
	<link rel="shortcut icon" href="./images/favicon.png" />
	<link rel="stylesheet" type="text/css" href="./CSS/style.css" media="screen, projection" id="css"/>
	<link rel="stylesheet" type="text/css" href="./themes/black-tie/jquery-ui-1.8.4.custom.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="./CSS/timePicker.css" />
	<link rel="stylesheet" type="text/css" href="./CSS/demo_table.css" />

<!-- Scripts génériques -->
	<script src="./javascript/fichier-script.js" type="text/javascript"></script>
	<script src="./javascript/oXHR.js" type="text/javascript"></script>
	<script src="./javascript/ajax.js" type="text/javascript"></script>

<!-- API JQuery -->
	<script src="./javascript/JQuery/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="./javascript/JQuery/jquery.ui.datepicker-fr.js" type="text/javascript"></script>
	<script src="./javascript/JQuery/jquery.timePicker.min.js" type="text/javascript"></script>
	<script src="./javascript/JQuery/jquery-ui-1.8.4.custom.min.js" type="text/javascript"></script>
	<script src="./javascript/JQuery/jquery.dataTables.min.js" type="text/javascript"></script>

<!-- Script spécifique aux membres -->
<?php
	if ($boolMember == 1) {
		echo ('
			<script src="./javascript/constants.js" type="text/javascript"></script>
			<script src="./javascript/prototype/List.Prototype.js" type="text/javascript"></script>
			<script src="./javascript/prototype/Map.Prototype.js" type="text/javascript"></script>
			<script src="./javascript/prototype/Favourite.Prototype.js" type="text/javascript"></script>
			<script src="./javascript/prototype/Request.Prototype.js" type="text/javascript"></script>
			<script src="./javascript/validation.functions.js" type="text/javascript"></script>
			');
	}
	if ($boolAdmin == 1) {
	echo ('<script src="./javascript/validation.functions.js" type="text/javascript"></script>');
	}
?>
</head>


<!-- Test pour connaitre la page chargé -->
	<!-- Page des favoris -->
	<!-- Page des requêtes -->

<?php
if (isset($_GET['action']) && $_GET['action']=='favoris')
echo('<body onload="init()">');
else if (isset($_GET['action']) && $_GET['action']=='prefavourite')
echo('<body onload="init()">');
else if (isset($_GET['action']) && $_GET['action']=='routing')
echo('<body onload="g_map()">');
else
echo('<body>');
?>

<!-- Chargement de la bannière du site -->
	<div id="home">
	<?php
		include('./headers/head.php');
	?>
		<div id="contener">
		<?php
			$monAction = new myOperation();
			$monActionMembre = new myOperationMembre();
			$monActionAdmin = new myOperationAdmin();
			$op = "index";

			if (isset($_GET['action']) && $boolTriche == 0) {
				$op = (string)$_GET['action'];
			}
			
			if($boolAdmin == 1) {
				$monActionAdmin->doActionAdmin($op);
			} else if ($boolMember == 1) {
				$monActionMembre->doActionMembre($op);
			} else {
				$monAction->doAction($op);
			}
		?>
		</div>
<!-- Fermeture de contener -->
	<?php
		include('./headers/footer.php');
	?>
	</div>
<!-- Fermeture du Home -->

</body>
</html>

