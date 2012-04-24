<?php
	session_unset();  
	
/**
 * @package pagesmembre
 */
	

echo " <span class='h1'> Module de Verification de Déconnexion </span>";
		
	$varclef = "<img src='images/loading.gif' /> Déconnexion en cours ...";
	
	if (isset($varclef)){ 
		echo "<span class=\"h2\">Déconnection : </span>";
		echo "
		<span class=\"paragraphe\">$varclef</span>
		<span class=\"important\">(Vous pouvez maintenant effacer manuellement vos cookies ...)</span>
		";
	}
	
	echo '
	<script language="Javascript">
		setTimeout("window.location=\'index.php\'",1000);
	</script>';
	
?>