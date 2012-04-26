<?php
	session_unset();  
/**
 * @package pagesmembre
 */

    echo " <h1> Module de Verification de Déconnexion </h1>";
	$varclef = "<img src='images/loading.gif' /> Déconnexion en cours ...";
	if (isset($varclef)){ 
		echo "  <article>
                    <h2>Déconnection : </h2>
                    $varclef
                    <span class=\"important\">
                        (Vous pouvez maintenant effacer manuellement vos cookies ...)
                    </span>
                </article>
		";
	}
	
	echo '
	<script language="Javascript">
		setTimeout("window.location=\'index.php\'",1000);
	</script>';
?>