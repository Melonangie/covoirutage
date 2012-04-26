<?php
/**
 * @package pagesAdmin
 */
	//session_start();

?>

<script type="text/javascript" charset="utf-8">
		jQuery(document).ready(function() {
			jQuery('#usersTable').dataTable({
					"bJQueryUI": true
			});
		});
</script>


<span class="gendarme">
	<span class="h1">
		Gérer les utilisateurs
	</span>
	<span class="paragraphe">
		Vous pouvez gérer les differentes propriété des utilisateurs du site.
	</span>
</span>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="usersTable">
	<thead>
		<tr>
			<th>Login</th>
			<th>Courriel</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Administrateur</th>
		</tr>
	</thead>
	<tbody>
		<?php
			include_once('./BD/user.sql.php');
			$db = new BD();
			$users = getUsers($db);
			$db->closeConnexion();
			for ($i=0; $i< count($users); $i++) {
				$user = $users[$i];
				echo('<tr class="odd gradeU">');
				echo('<td>'.$user['PSEUDO'].'</td>');
				echo('<td>'.$user['MAIL'].'</td>');
				echo('<td>'.$user['NOM'].'</td>');
				echo('<td>'.$user['PRENOM'].'</td>');
				if($user['USR_ADMIN'] == 1) {
					echo('<td>'.'X'.'</td>');
				} else {
					echo('<td>'.''.'</td>');
				}
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th>Login</th>
			<th>Courriel</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Administrateur</th>
		</tr>
	</tfoot>
</table>


<div id="output" style="color: red;"></div>
