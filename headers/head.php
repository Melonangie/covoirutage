<header>
	<a class="logo" href="#"></a>
	<h1>Global Covoiturage</h1>
	<span class="horloge">
<?php
		// Enregistrons les informations de date dans des variables
		$jour = date("d");
		$mois = date("m");
		$annee = date("Y");
		$heure = date("H");
		$minute = date("i");
		// Maintenant on peut afficher ce qu'on a recueilli
?>	
	</span>
<?php
		if(isset($_SESSION['login']))			
			include('./headers/banMembre.php');
		else 
			include('./headers/banLog.php');					
?>
</header>
	