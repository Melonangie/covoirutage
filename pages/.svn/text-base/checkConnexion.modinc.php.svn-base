<?php
 /**
 * @package pages
 */
include_once('protection-sql.php');
include_once('./BD/user.sql.php');

echo " <span class='h1'> Verification de Connexion </span>";

// on teste si le visiteur a soumis le formulaire de connexion, maybe useless
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
	
	// Test if the login and password are defined.
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) {
		
		$db = new BD();
		$_SESSION['id'] = getUserId($_POST['login'],$db);
		extract($_POST);  // je vous renvoie à la doc de cette fonction
		$exist = existID($_POST['login'], $_POST['pass'], $db);
		$admin = isAdmin($_SESSION['id'], $db);
		$db->closeConnexion();

		// si on obtient une réponse, alors l'utilisateur est un membre
		if ($exist == 1) {

			$_SESSION['login'] = $_POST['login'];
			if ($admin) {
				$_SESSION['admin'] = true;
			}			
			$varclef = "<img src='images/loading.gif'/> Connexion en cours ...";

			if (isset($varclef)){
				echo "<span class='h2'>Connexion : </span>";
				echo "
					<span class='paragraphe'>$varclef</span>
					<span class='important'>(Vérifiez bien que les cookies sont activés pour pouvoir vous connecter ...)</span>
					";
			}
			echo '
				<script language="Javascript">
					setTimeout("window.location=\'index.php\'",1000);
				</script>
				';
		}

		//si on ne trouve aucune réponse, le visiteur s'est trompé soit dans son login, soit dans son mot de passe
		elseif ($retour == 0) {
			$info = "Désolé, mais le compte demandé est non reconnu.";
		}
		// sinon, alors la, il y a un gros problème :)
		else {
			$info = 'Probl&egrave;me dans la base de donn&eacute;es : plusieurs membres ont les mêmes identifiants de connexion.';
		}
	}
	else {
		$info = "Au moins un des champs est vide.";
	}
}

if (isset($info)){
	echo "<span class='h2'>La tentative de connexion a échoué!</span>";
	echo "
			<span class='paragraphe'>$info	
			<a class='retour' href='index.php'>Retour &agrave; l'accueil</a>
			</span>
		";
}

?>