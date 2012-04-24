<span class="h1">Modification de compte</span>

<?php
/**
 * @package pagesmembre
 */
	
if(!isset($_SESSION['login'])){
	echo "Acces interdit (vous devez être connecté).";
} else {
	?>

<script
	src="./javascript/account.functions.js" type="text/javascript"></script>


<span class="paragraphe">
	<a href="javascript:void(0)" id="passwordBtn">- Modifier mon mot de passe</a><br/>
	<a href="javascript:void(0)" id="emailBtn">- Modifier mon adresse de courriel</a><br />
</span>

<div id="emailDialog" style="DISPLAY: none" title="Modifier mon adresse de courriel">
<table>
	<tr>
		<td>Nouvelle adresse de courriel</td>
		<td><input id='newEmail' type='text'\></td>
	</tr>
</table>
</div>

<div id="passwordDialog" style="DISPLAY: none" title="Modifier mon mot de passe">
<table>
	<tr>
		<td>Ancien mot de passe</td>
		<td><input name='oldPassword' type='password'\></td>
	</tr>
	<tr>
		<td>Nouveau mot de passe</td>
		<td><input name='newPassword' type='password'\></td>
	</tr>
	<tr>
		<td>Confirmation</td>
		<td><input name='confirmPassword' type='password'\></td>
	</tr>
</table>
</div>

<?php
}
?>