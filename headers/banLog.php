<?php 
/**
 * @package headers
 */
?>
<div class='id'>				
	<form method="post" action="index.php?module=1&amp;action=checkConnexion"> <!--index.php?module=2&amp;action=1-->
		<span class="connect">Identifiant :<input class="zonesaisie" type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>" /></span> 
		<span class="connect">Mot de passe :<input class="zonesaisie" type="password" name="pass" /></span>   
		<input type="submit" name="connexion" value="Connexion" class="bouton_perso" />
	</form>
</div>