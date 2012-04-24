	<div id="header">
		
		<div id="baniere">
				          <!--<span class='tagtop'></span> -->
		          <span class='head'>
				      <span class="redtext">Global Covoiturage
				  </center>

		</div>
				
				<span class="horloge">
		
<?php
				
				// Enregistrons les informations de date dans des variables

				$jour = date("d");
				$mois = date("m");
				$annee = date("Y");

				$heure = date("H");
				$minute = date("i");

				// Maintenant on peut afficher ce qu'on a recueilli
				//echo "Date: $jour/$mois/$annee.<img src='images/horloge.png' alt='Horloge'/></a>";
?>								
				</span>			
		</div>
		
<?php
			if(isset($_SESSION['login']))			
				include('./headers/banMembre.php');
			else 
				include('./headers/banLog.php');	
			
		
	include('./modules/menu.modinc.php');		
			
?>
		
	