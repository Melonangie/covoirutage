<?php 
/**
 * @package modules
 */
?>
<div id="newProblem" style="DISPLAY: none" title="Définir un nouveau problème" class="tabs">
	<ul class="tabNavigation">
		<li><a href="#tabOnce">Problème</a></li>
		
	</ul>	
	
	<div class="tabContainer">
	<div id="tabOnce" class="tabContent">
		<form>
		<fieldset>
			<!-- Départ -->
			<span class="dialogBoxContent">
			<span class="dialogBoxContent">Partir</span>
			<span class="dialogBoxContent"></span>
				<label class="required" for="departureDate">Depuis le</label>
				<span class="dialogBoxContent">
				<input type="text" id="departureDate" title="cliquez ici pour afficher le calendrier" 
		 	   		style="width: 9em;"/>
				 <input type="text" id="departureTimeStart" style="width: 4em;" value="08:00">
			</span>
			</span>
			<span class="dialogBoxContent">Avant le</span>
			<!-- Arrivée -->
			<span class="dialogBoxContent">
				<input type="text" id="departureDate1" title="cliquez ici pour afficher le calendrier" 
		 	   		style="width: 9em;"/>
			 <input type="text" id="departureTimeStart1" style="width: 4em;" value="10:00">
			
			</span>
			
			<span class="dialogBoxContent"></span>
			<span class="dialogBoxContent">
				<label for="arrival" class="required">Destination</label>
				<select id="arrival" style=" width:60%;"></select>
			</span>
			
		</fieldset>
		</form>
	</div>

	</div>
</div>

