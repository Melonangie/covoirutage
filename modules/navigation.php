<?php
/**
 * @package modules
 */
		if(!isset($_SESSION['login'])){
		  echo '					
			 <nav>
				<a href="index.php?module=1&amp;action=index">Accueil</a>
				<a href="index.php?module=1&amp;action=presentation">Presentation</a>
				<a href="index.php?module=1&amp;action=documentation">Documentation</a>
				<a href="index.php?module=1&amp;action=inscription">Inscription</a>
			 </nav>
		  ';	
		
	   } else if (isset($_SESSION['admin'])) {
	   	echo('
		  <nav>
		  	<a href="index.php?module=1&amp;action=index">Accueil</a>
		  	<a href="index.php?module=1&amp;action=users">Membres</a>
		  	<a href="index.php?module=1&amp;action=matrice">Matrice</a>
		  	<a href="index.php?module=1&amp;action=problem">Problèmes</a>
		  	<a href="index.php?module=1&amp;action=request">Requêtes</a>
		  	<a href="index.php?module=1&amp;action=prefavourite">Favoris</a>
		  	<a href="index.php?module=1&amp;action=ajouterclients">Ajouts</a>
		  	<a href="index.php?module=1&amp;action=aide">Aide</a>
		  </nav>
		');
  	   } else {
  	   		 echo '
			 <nav>
				<a href="index.php?module=1&amp;action=index">Accueil</a>
				<a href="index.php?module=1&amp;action=consulter">Consulter</a>
				<a href="index.php?module=1&amp;action=favoris">Favoris</a>
				<a href="#">Itinéraire</a>
				<a href="index.php?module=1&amp;action=horaire">Horaire</a>	
				<a href="index.php?module=1&amp;action=aide">Aide</a>
			  </nav>
		   ';	  
  	   }
?>