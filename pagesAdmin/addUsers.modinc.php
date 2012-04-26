<?php
/**
 * @package pagesAdmin
 */
?>

<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="./javascript/prototype/Map.Prototype.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
document.clientfavs=new Map();;
var i=0;
var idpersonne;
function getCity(address) {
	var lastCommaPos = address.lastIndexOf(",", address.length);
	var firstCommaPos = address.indexOf(",");
	if (lastCommaPos != firstCommaPos)
		return address.substring(firstCommaPos + 8, lastCommaPos);
	else
		return address.substring(0, lastCommaPos);
};

function getShortAddress(address) {
	var firstCommaPos = address.indexOf(",");
	var lastCommaPos = address.lastIndexOf(",", address.length);
	if (lastCommaPos != firstCommaPos)
		return address.substring(0, firstCommaPos);
	else
		return "";
};

function timey()
{
	i++;
	remplir();
	}


function remplir()
{

	
	if(i<document.clientfavs.size())
	{
	geocoder = new google.maps.Geocoder();
	var idpers=document.clientfavs.keyArray();
	 idpersonne=idpers[i];
	var ad=document.clientfavs.get(idpersonne);
	geocoder.geocode( {
		'address' : ad
	}, geocode);
	setTimeout("timey()",1000);
	}	

	}

function geocode(results, status)
{
	if (!results || (status != google.maps.GeocoderStatus.OK))
	{
		  var err="ddd";
			jQuery.post("./traitement/ajouterClients.php", {
				nofound : err,
				idusr:idpersonne
			   },
			   callback
			 );
		}
	else
		      {
	    	  var address = results[0].formatted_address;
	  		var city = getCity(address);
	  		var shoradr = getShortAddress(address);
	  		var longitude = results[0].geometry.location.lng();
			var latitude = results[0].geometry.location.lat();
			jQuery.post("./traitement/ajouterClients.php", {
				address: shoradr,
				city : city,
				lat : latitude,
				lng : longitude,
				idusr:idpersonne
			   },
			   callback
			 );

				      } 
	    
	}

function callback(oData)
{}
</script>


<?php
include_once('./BD/BD.class.php');
include_once('./BD/user.sql.php');
include_once('./BD/vehicule.sql.php');

if(isset($_POST['ajoutclient']))
{
	$db = new BD();
	$res = $db->query('select * from nouvelle_liste_clients');
	while($conte=$db->fetchAssoc($res))
	{$nom=trim($conte["NOM"]);
	$prenom=trim($conte["PRENOM"]);
	$adresse=trim($conte["ADRESSE"]);
	$cp=trim($conte["CP"]);
	$ville=trim($conte["VILLE"]);
	$adr=$adresse." ,".$cp." ,".$ville.' France';
	$mdp=md5($nom);
	//$mail=$conte["MAIL"];
	//$imm=$conte["IMMATRICULATION"];
	//$capa=$conte["CAPACITE"];
	addUser($nom, $mdp, "", $nom, $prenom, $db);
	$idper="select LAST_INSERT_ID()";
	$idfav= mysql_fetch_row($db->query($idper));
	$idusr=$idfav[0];
	//if($imm!=null)
	//{
	//addVoiture($imm,$idusr,$capa,$db);
		
	//	}
	echo '
  	<script language="javascript" type="text/javascript">
document.clientfavs.put('.$idusr.',"'.$adr.'");
</script>';

	}
	$db->closeConnexion();
}
?>

<h1> Ajouter les nouveaux clients </h1S>
<article> 
    <p>Vous pouvez ajouter les nouveaux clients par
    la fiche en cliquant le button. </p> 
    <form method="post" action="">
        <input type="hidden" name="ajoutclient" /> 
        <input type="submit" value="Ajouter clients" />
    </form>
    <input type='button' onclick='remplir()' value='Ajouter les adresses'></input>
    <div id="output" style="color: red;"></div>
</article>