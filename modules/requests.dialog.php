<?php 
/**
 * @package modules
 */
?>
<div id="newRequest" style="DISPLAY: none" title="Enregistrer une nouvelle requète" class="tabs">
	<ul class="tabNavigation">
		<li><a href="#tabOnce">Requête Ponctuelle</a></li>
		<li><a href="#tabPeriodically">Requête Periodique</a></li>
	</ul>	
	<div class="tabContainer">
	<div id="tabOnce" class="tabContent">
		<form>
		<fieldset>
			<!-- Départ, Arrivée -->
			<span class="dialogBoxContent">
				<label for="departure" class="required">Départ</label>
				<select id="departure" style=" width:81%;"></select>
			</span>
			<span class="dialogBoxContent">
				<label for="arrival" class="required">Arrivée</label>
				<select id="arrival" style=" width:80%;"></select>
			</span>
			
			<!-- Départ -->
			<span class="dialogBoxContent">
				<label class="required" for="departureDate">Partir le</label>
				<input type="text" id="departureDate" title="cliquez ici pour afficher le calendrier" 
		 	   		style="width: 9em;"/>
				entre <input type="text" id="departureTimeStart" style="width: 4em;" value="08:00">
				et <input type="text" id="departureTimeStop" style="width: 4em;" value="09:00">
			</span>
			
			<!-- Arrivée -->
			<span class="dialogBoxContent">
				<label class="required" for="arrivalDate">Arriver</label>
				<select id="arrivalDate" style=" width: 9em;">
					<option value="sameDay">le jour même</option>
					<option value="followingDay">le lendemain</option>		
				</select>
				entre <input type="text" id="arrivalTimeStart" style="width: 4em;" value="10:00">
				et <input type="text" id="arrivalTimeStop" style="width: 4em;" value="11:00">
			</span>
			
			<!-- Voiture -->
			<span class="dialogBoxContent">
				Je peux utiliser ma voiture
				<input type="checkbox" id="driver"/>
			</span>
		</fieldset>
		</form>
	</div>
	<div id="tabPeriodically" class="tabContent">
		<form>
		<fieldset>
		
			<!-- Départ, Arrivée -->
			<span class="dialogBoxContent">
				<label for="departurePer" class="required">Départ</label>
				<select id="departurePer" style=" width:81%;"></select>
			</span>
			<span class="dialogBoxContent">
				<label for="arrivalPer" class="required">Arrivée</label>
				<select id="arrivalPer" style=" width:80%;"></select>
			</span>
			
			<!-- Récurrence -->
			<span class="dialogBoxContent">
				<label for="repeats" class="required">Récurrence</label>
				<select id="repeats" style=" width:71%;">
					<option value="Daily">Tous les jours</option>
					<option value="Weekly">Toutes les semaines</option>
					<option value="Monthly">Tous les mois</option>
					<option value="Yearly">Tous les ans</option>		
				</select>
			</span>
			
			<!-- Récurrence tout les -->
			<span class="dialogBoxContent">
				<label for="repeatEvery" class="required">Répéter tout les</label>
				<select id="repeatEvery" style=" width:20%;">
					<?php
					for ($index = 1; $index < 31; $index++) {
						echo('<option value="every_'.$index.'">'.$index.'</option>');
					} 
					?>
				</select>
				<label for="repeatEvery" class="required" id="repeatEveryLabel">jours</label>
			</span>
			
			<!-- Jours répétés -->
			<span class="dialogBoxContent" id="repeatOn" style="DISPLAY: none">
				<label for="repeatOn" class="required">Répéter le</label>
				<input type="checkbox" id="repeatOnMonday"/>L
				<input type="checkbox" id="repeatOnTuesday"/>M
				<input type="checkbox" id="repeatOnWednesday"/>M
				<input type="checkbox" id="repeatOnThursday"/>J
				<input type="checkbox" id="repeatOnFriday"/>V
				<input type="checkbox" id="repeatOnSaturday"/>S
				<input type="checkbox" id="repeatOnSunday"/>D
			</span>
			
			<!-- Départ -->
			<span class="dialogBoxContent">
				<label class="required" for="departureDatePer">À partir du</label>
				<input type="text" id="departureDatePer" title="cliquez ici pour afficher le calendrier" 
		 	   		style="width: 9em;"/>
				entre <input type="text" id="departureTimeStartPer" style="width: 4em;" value="08:00">
				et <input type="text" id="departureTimeStopPer" style="width: 4em;" value="09:00">
			</span>
			
			<!-- Arrivée -->
			<span class="dialogBoxContent">
				<label class="required" for="arrivalDatePer">Arriver</label>
				<select id="arrivalDatePer" style=" width:9em;">
					<option value="sameDay">le jour même</option>
					<option value="followingDay">le lendemain</option>		
				</select>
				entre <input type="text" id="arrivalTimeStartPer" style="width: 4em;" value="10:00">
				et <input type="text" id="arrivalTimeStopPer" style="width: 4em;" value="11:00">
			</span>
			
			<!-- Date de fin -->
			<span class="dialogBoxContent">
				<label class="required" for="endingDate">Répéter jusqu'au</label>
				<input type="text" id="endingDate" title="cliquez ici pour afficher le calendrier" 
		 	   		style="width: 9em;"/>
			</span>
			
			<!-- Voiture -->
			<span class="dialogBoxContent">
				Je peux utiliser ma voiture
				<input type="checkbox" id="driverPer"/>
			</span>
		</fieldset>
		</form>
	</div>
	</div>
</div>

