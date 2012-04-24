<?php 

/**
 * @package pages
 */

?>
<span class='h1'>Présentation du projet : Système de Géolocalisation</span>
		
		<span class='paragraphe'>
			<span class='enteteliste'>Présentation rapide du projet : </span>
				
				<span class='h5'> Informations présentes sur la page de Mr HSU à propos du projet :</span>
				
				<span class='scroll'>
					<span class='para'>La Géolocalisation est un procédé permettant de positionner un objet (une personne, une information, ...) sur un plan ou une carte à l'aide de ses coordonnées géographique. Grâce aux récentes avancées technologiques dans le domaine de la télécommunication et de l'internet, ce type de système devient abordable pour les entreprises. Tout entreprise ayant une flotte de véhicules pourra utiliser ce type de système afin de gérer efficacement ses véhicules.</span> 
					<span class='para'>Le laboratoire LGI2A travaille actuellement sur une application de gestion de tournées des aides soignantes. Dans une première étape on fera une étude sur les systèmes existants. Le choix du système devra répondre au mieux aux exigences de notre application. L'objectif de ce projet est d'installer, configurer et tester le système de géolocalisation choisi en grandeur réelle. Les aspects sécurités de ce système devra être étudiés. </span> 
				</span>
				
				<span class='h5'> Informations mises à jour sur la page n°2 de Mr HSU à propos du projet Alternatif :</span>
				
				<span class='gendarme'>
				
				<span class='enteteliste'>Introduction</span>
				
				<span class='para'>
				
					<span class='gendarme'>
						Le travail proposé ici concerne le domaine d’optimisation de tournées de véhicules, plus particulièrement le problème d’optimisation des systèmes de covoiturages. Cette optimisation a pour but de mettre plusieurs personnes dans un même véhicule, réduisant ainsi le nombre de véhicules en circulation, il présente donc de nombreux intérêts à tous les niveaux :
					</span>
					
					<ul>
					    <li> Sur le plan individuel : il présente un intérêt économique en réduisant le coût de transport et coût d’usure des véhicules. En réduisant le nombre de véhicules en circulation, il peut également permettre de réduire le temps de trajet. En voyageant à plusieurs, Il réduit également le stress des personnes covoiturées, et rend le déplacement plus agréable.</li>
					    <li> Sur le plan des collectivités : il réduit le budget nécessaire pour la création et l’entretien des axes routiers </li>
					    <li> Sur le plan environnemental : il permet de réduire l’émission des gaz d’échappement </li>
					</ul>
				
					<span class='gendarme'>
					Le travail consiste à réaliser une application web permettant de gérer des tournées de covoiturage.
					<p>Cette application se décompose en 2 parties :</p>
					</span>
				
				<div id='none'>
				<span class='paragraphe'>
					<ul>
						<li>1. Partie interface graphique : il s'agit de concevoir des interface conviviales pour différents types d'utilisateurs (administrateur, usagers, ..).</li>
						<li>2. Partie optimisation des tournées : une fois toutes les informations connues (les demandes, les temps et les longueurs des trajets, le nombre de véhicules disponibles, . . . etc.), il faudra réaliser une étude comparative de plusieurs heuristiques d'optimisation de tournées.</li> 
					</ul>
				</span>
				</div>
				
				<span class='enteteliste'>Présentation du projet</span>
				
				<span class='gendarme'>
					L'objectif est de réaliser une application capable de fournir à un ensemble d'usagers (par exemple des étudiants), qui doivent se rendre vers une destination unique (par exemple l'iut) à un instant donné (par exemple à 8h15 du matin), un ensemble de groupes (clusters), où chaque cluster est composé d'un conducteur et d'au plus 3 passagers devant voyager dans un même véhicule. 
				</span>
				
				<span class='gendarme'>
					Le <span class='redtext'>coût total de trajet</span> est défini comme étant la distance totale parcourue par tous les véhicules pour acheminer tous les usagers de leur domicile vers leur destination. L'objectif de l'application est de minimiser le coût total du trajet.
				
				<p>Avant de s'intéresser à l'optimisation des tournées, on va déterminer : </p>
				</span>
				
				<div id='none'>
					<ul>
						<li>1. les données du problème</li>
						<li>2. les fonctionnalités proposées</li> 
					</ul>
				</div>
				
				<span class='enteteliste'>Les Données du problème</span>
				
				<span class='gendarme'>On définit une <span class='redtext'>adresse</span> comme étant un ensemble d'informations contenant : </span>
				
				<span class='scroll'>
					<div id='none'>
					<ul>
					   <li>1.  un identifiant</li>
					   <li>2. une adresse postale (num, nom de rue) : 5 rue de l'université</li>
					   <li>3. un code postal : 62307</li>
					   <li>4. une ville : lens</li>
					   <li>5. un pays : france</li>
					   <li>6. un couple (x,y) correspondant aux coordonnées géographique de l'adresse postale : (50.4382475, 2.8110135)</li> 
					</ul>
					</div>
				</span>
				
				<span class='gendarme'>On définit un <span class='redtext'>trajet</span> comme étant :</span> 
				
				<span class='scroll'>
					<div id='none'>
					<ul>
						<li>1.  un identifiant</li>
						<li>2. une date désirée pour réaliser le trajet</li>
						<li>3. une adresse de départ</li>
						<li>4. une fenêtre de temps (e_d, l_d) représentant l'intervalle de temps à l'intérieur de laquelle on veut partir : (7h00,7h15)</li>
						<li>5. une adresse de d'arrivée</li>
						<li>6. une fenêtre de temps (e_a,l_a) représentant l'intervalle de temps à l'intérieur de laquelle on veut arriver : (8h00,8h10)</li> 
													
					</ul>
					</div>
				</span>
				
				<span class='gendarme'>Tous les <span class='redtext'>utilisateurs</span> sont caractérisés par : </span>
		
				<span class='scroll'>
					
					<div id='none'>
					<ul>
						<li>1. un identifiant</li>
						<li>2. un mot de passe</li>
						<li>3. un nom</li>
						<li>4. un prénom</li>
						<li>5. une adresse correspondant à leur lieu de domicile</li>
						<li>6. un type : conducteur, passager, ...</li>
						<li>7. un profile : utilisateur, administrateur</li>
											
					</ul>
					</div>
				</span>
				
				<span class='gendarme'>
					Une matrice des distances appelée une matrice OD (Origine-Destination). Cette matrice en 2 dimensions permet de fournir pour tout trajet : le temps estimé de parcours et la distance totale à parcourir.
					<p>Exemple : (à faire) </p>
				</span>
				
				<span class='enteteliste'>Les fonctionnalités du système</span>
				
				<span class='gendarme'>Les fonctionnalités que devra fournir cette application pour les différents profils d'utilisateurs : usagers et administrateurs. 
		
				<span class='h3'>Pour un utilisateur</span>

				<span class='gendarme'>On liste ici les fonctionnalités proposées à un utilisateur : </span>
				
					<div id='none'>
						<ul>
						   <li>1.  création de compte</li>
						   <li>2. gestion des trajets (création, demande, ...)</li>
						   <li>3. suivi du covoiturage pour le conducteur et ses passagers, temps réel ?</li>
						</ul>
					</div>
						
				<span class='h3'>Pour un administrateur</span>

				<span class='gendarme'>On liste ici les fonctionnalités proposées à un administrateur : </span>
		
					<div id='none'>
							<ul>
							    <li>1.  gestion des comptes utilisateurs</li>
								<li>2. élaboration d'une journée de covoiturage (optimisation, validation, ...)</li>
								<li>3. gestion des incidents</li>
							</ul>
					</div>
				
				</span>
				
				<span class='enteteliste'>Architecture de l'application</span>
				
					<span class='gendarme'>
					
						<div id='none'>
							<ul>
								<li>Logiciel C-Track de la société situaction :</li>
								<li><a href='http://www.situaction-geolocalisation.com/'>Situaction-Geolocalisation</a></li>

								<li>Suivi temps réel des véhicules : alternative à une balise de géolocalisation ?</li> 
							</ul>
						</div>
					
						<div id='filter'></div>
						<div id='box'>
						<div id='boxcontent'  onclick='closebox()'>  </div> 
						<div id='boxtitle'> Nom de l'image</div></div>
			
						<img class='miniature' onclick="openbox('./images/architecture.jpg');" src="./images/mini_archi.jpg" alt="Architecture du système" />
			
					
					</span>
									
		</span>
