<?php 
/**
 * @package headers
 */
?>
	<div id='login'>
			<table><tbody>
				<tr><td>Bienvenue : <span class='redtext'><?php echo htmlentities(trim($_SESSION['login'])).' - '.htmlentities(trim($_SESSION['id'])); ?></span></td></tr>
				<tr><td><a href='index.php?module=1&amp;action=checkDeconnexion'><img src='images/logout.png' width=20 height=31/>Se déconnecter</a></td></tr>
			</tbody></table>
	</div>