<?php
    session_start();
// Operations " classiques "
    include_once('./modules/operation.class.php');
// Operations des membres
    include_once('./modules/operationMembre.class.php'); 
// Operations de l'Administrateur
    include_once('./modules/operationAdmin.class.php'); 
// Conexion BD
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

<!DOCTYPE HTML>
<!--[if lte IE 8]> <html class="ie" lang="fr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="fr"><!--<![endif]-->
<head>

<!-- Basic Page Needs
  ================================================== -->
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Application Google Maps : Système de Covoiturage</title>
		
<!-- Mobile and IE Specific Metas
  ================================================== -->		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/libs/modernizr-2.5.3.min.js"></script>

<!-- CSS
  ================================================== -->
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css" />
		<link rel="stylesheet" type="text/css" href="./CSS/style.css" media="screen, projection" id="css"/>
		<link rel="stylesheet" type="text/css" href="./themes/black-tie/jquery-ui-1.8.4.custom.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="./CSS/timePicker.css" />
		<link rel="stylesheet" type="text/css" href="./CSS/demo_table.css" /> 
		
<!-- Favicons
	================================================== -->	
		<link rel="shortcut icon" href="./images/favicon.png" />
		
</head>

<!-- Page Content Starts
  ================================================== -->
	<!-- Loads body -->
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

	<div class="container"> <!-- Loads the container: width & font size-->
		<?php include('./headers/header.php'); ?>
		<section>
			<?php
                $monAction = new myOperation();
                $monActionMembre = new myOperationMembre();
                $monActionAdmin = new myOperationAdmin();
                $op = "index";
    
                if (isset($_GET['action']) && $boolTriche == 0)
                    $op = (string)$_GET['action'];
                if($boolAdmin == 1) {
                    $monActionAdmin->doActionAdmin($op);
                } else if ($boolMember == 1) {
                    $monActionMembre->doActionMembre($op);
                } else {
                    $monAction->doAction($op);
                }
            ?>
		</section>
		<?php include('./modules/nav.php');?> 
		<?php include('./headers/footer.php'); ?> 
	</div> <!-- contentainer -->
	
<!-- JS
	================================================== -->
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
	<!-- Fermeture du Home -->
		<script src="./javascript/fichier-script.js" type="text/javascript"></script>
		<script src="./javascript/oXHR.js" type="text/javascript"></script>
		<script src="./javascript/ajax.js" type="text/javascript"></script>
	<!-- API JQuery -->
		<script src="./javascript/JQuery/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="./javascript/JQuery/jquery.ui.datepicker-fr.js" type="text/javascript"></script>
		<script src="./javascript/JQuery/jquery.timePicker.min.js" type="text/javascript"></script>
		<script src="./javascript/JQuery/jquery-ui-1.8.4.custom.min.js" type="text/javascript"></script>
		<script src="./javascript/JQuery/jquery.dataTables.min.js" type="text/javascript"></script>
</body>
</html>

