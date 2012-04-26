<span class="gendarme"> <span class="h1"> Introduction en vidéo flash </span> </span>
<?php
if (isset($_SESSION['admin']))
echo '
<a href="./flashaide/admin/aide-admin.htm" target="_blank">* Flash aide</a>
';
else 
echo '
<a href="./flashaide/client/aide-user.htm" target="_blank">* Flash aide</a>
';
?>