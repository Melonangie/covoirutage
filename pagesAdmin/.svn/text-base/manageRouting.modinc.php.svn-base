<?php
/**
 * @package pagesAdmin
 */
session_start();
$numsolution=$_POST['numsolution'];//idsolution,selon laquelle afficher les itinéraires et chosir les critères d'évalution.
?>
<script
	type="text/javascript"
	src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script
	src="./javascript/tourneesManagement.js" type="text/javascript"></script>
<span class="gendarme"> <span class="h1"> Gérer les tournées </span> <span
	class="paragraphe"> Vous pouvez consulter et administrer les requêtes
		de covoiturage.<?php echo " Solution ".$numsolution; ?> </span> </span>
<div id="g_map"
	style="height: 800px; width: 100%;"></div>
<div id="operate_panel1"
	style="float: left; width: 50%; text-align: center; padding-top: 10px">
	<span class="paragraphe"> <input type="checkbox" id="ptsdepart"
		onclick="operateDiv()" /> Points de départ <input type="checkbox"
		id="ptsarrivee" onclick="operateDiv1()" /> Point d'arrivée <input
		type="checkbox" id="itineraires" onclick="operateDiv2()" />
		Itinéraires </span>
</div>
<div id="operate_panel"
	style="width: 100%; padding-top: 10px; visibility: hidden; float: left;">

<br>
	<table border="1">
<tr><th></th><th>Prévisionnelles</th><th>Réelles</th></tr>
<tr><td>Afficher/Non afficher tout</td>
    <td><input type="checkbox" id="tout_reel" onclick="SelectAllrel_check(this.id)"></td>
    <td><input type="checkbox" id="tout_pre" onclick="SelectAllPre_check(this.id)"></td>
</tr> </table>
	
	<div style="padding-top: 10px; float: left; width: 50%;">

		<table cellpadding="0" cellspacing="0" border="0" class="display"
			id="trajetTable">
			<thead>
				<tr>
				<?php
				$total_distance_brute=0;
				$total_duration_brute=0;
				$total_distance_pre=0;
				$total_duration_pre=0;
				$infos_image = @getImageSize("./images/details_open.png");
				$largeur = $infos_image[0];
				echo('<th width="'.$largeur.'"></th>');
				?>
					<th>ID trajet</th>
					<th>Valeurs pré</th>
					<th width='120'>Prévisionnelle</th>
					<th width='120'>Réelle</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$idpro=$_POST['idpro'];
			$idfavfin=$_POST['idfavfin'];
			$arrlat=$_POST['latfin'];
			$arrlng=$_POST['lngfin'];


			$db = new BD();
			$arridtras=getTrajetsParPro($db,$idpro);
			if(count($arridtras)==0)
			{
				$arridrequs=getProDetail($db,$idpro);
				$p=1;
				for ($k=0; $k< count($arridrequs); $k++)
				{
					$reque=	$arridrequs[$k];
					$favfrom=getposition_debut($reque,$db);
					$departlat=$favfrom["LATITUDE"];
					$departlng=$favfrom["LONGITUDE"];
					echo '<script language="Javascript">
var end=new google.maps.LatLng('.$arrlat.','.$arrlng.');'.'
document.ends.put('.$p.',end);
</script>';
					echo '<script language="Javascript">
var depart=new google.maps.LatLng('.$departlat.','.$departlng.');'.'
document.begins.put('.$p.',depart);
</script>';
					$p++;
				}
			}
			else
			{
				for ($i=0; $i< count($arridtras); $i++)
				{
					$idtrajet=$arridtras[$i];
					$info_clients=getinfoclientParTra($db,$idtrajet);
					$info_values_per=getvaluesParPer($db,$idtrajet,$idfavfin);
					echo '<script language="Javascript">
var infom_clients=new Array();
var counter=0;
</script>';
					for($m=0; $m< count($info_clients); $m++)
					{

						$infoarr=$info_clients[$m];
						$name=$infoarr['NOM'];
						$firstname=$infoarr["PRENOM"];
						$infovaluearr=$info_values_per[$m];
						$disper=$infovaluearr['DISTANCE'];
						$durper=$infovaluearr["DUREE"];
						echo '<script language="Javascript">
					var infomat_clients=new Array();				
infomat_clients[0]="'.$name.'";
infomat_clients[1]="'.$firstname.'";
infomat_clients[2]='.$disper.';
infomat_clients[3]="'.$durper.'";
infom_clients[counter]=infomat_clients;
counter++;	
</script>';	
					}
					echo '<script language="Javascript">
document.infoClient_trajet.put('.$idtrajet.',infom_clients);
</script>';
					$idfavs=getFavParTra($db,$idtrajet);
					$valeurini=getValeurini_trajet($idfavs,$idfavfin,$db);
					$brudist=($valeurini["DISTANCE"]/1000);//distance brute par trajet km
					$brudu=round($valeurini["DUREE"]/60);//durée brute par trajet min
					$total_distance_brute+=$brudist;
					$total_duration_brute+=$brudu;
					$valuespre=getValeurPre_Trajet($db,$idtrajet);
					$dureepre_trajet=$valuespre["DUREE"];//durée pre par trajet sec
					$dispre_trajet=$valuespre["DISTANCE"];//distance pre par trajet m
					$total_distance_pre+=$dispre_trajet;
					$total_duration_pre+=$dureepre_trajet;
					$dureepre_trajet_min=round($dureepre_trajet/60);//durée pre par trajet min
					$dispre_trajet_km=($dispre_trajet/1000);//distance pre par trajet km
					echo '<script language="Javascript">
var valeurbrute=new Array();
valeurbrute[0]='.$valeurini["DISTANCE"].';
valeurbrute[1]='.$valeurini["DUREE"].';
document.valuesini.put('.$idtrajet.',valeurbrute);
</script>';
					echo '<script language="Javascript">
var valeurpre=new Array();
valeurpre[0]='.$dispre_trajet_km.';
valeurpre[1]='.$dureepre_trajet_min.';
document.valuespre.put('.$idtrajet.',valeurpre);
</script>';
					echo '<script language="Javascript">
var end=new google.maps.LatLng('.$arrlat.','.$arrlng.');
document.ends.put('.$idtrajet.',end);
</script>';

					for ($j=0; $j< count($idfavs); $j++)
					{
						$idfavori=$idfavs[$j];
						$position=getPositionFav($idfavori,$db);
						$lat=$position["LATITUDE"];
						$lng=$position["LONGITUDE"];

						if($j==0)
						echo '<script language="Javascript">
var depart=new google.maps.LatLng('.$lat.','.$lng.');
document.begins.put('.$idtrajet.',depart);
</script>';
						else
						echo '<script language="Javascript">
var pt=new google.maps.LatLng('.$lat.','.$lng.');
document.pts.push({
            location:pt,
            stopover:true});
</script>';
					}
					echo '<script language="Javascript">
  document.waypts.put('.$idtrajet.',document.pts);
  document.pts = new Array();
</script>';	
					echo('<tr class="odd gradeU">');
					echo('<td><img src="./images/details_open.png"></td>');
					echo  '
    <td>'.$idtrajet.'</td><td>'.$dispre_trajet_km.' km--'.$dureepre_trajet_min.' min</td>
    <td><input type="checkbox" id="'.$idtrajet.'r"  value="'.$idtrajet.'" onclick="Gestion_Ways_reel(this.id,this.value)"/>
    <select name="select" size="1" id="'.$idtrajet.'r_color" onchange="defineColor_re(this.id,this.value)" style="width:70px;height:12px">';
Html_Option();
  echo '          
    </select>
    <input type="button" id="'.$idtrajet.'" value="Détail" onclick="detail_re(this.id)"></td>
        <td><input type="checkbox" id="'.$idtrajet.'p"  value="'.$idtrajet.'"  onclick="Gestion_Ways_Pre(this.id,this.value)"/> 
    <select name="select" size="1" id="'.$idtrajet.'p_color" onchange="defineColor_pre(this.id,this.value)" style="width:70px;height:12px">';
Html_Option();  
echo '    
</select>
    <input type="button" id="'.$idtrajet.'" value="Détail" onclick="detail_pre(this.id)"></td>
  </tr>';	
				}
			}
			$db->closeConnexion();
			
			?>

			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<th>ID trajet</th>
					<th>Valeurs pré</th>
					<th>Prévisionnelle</th>
					<th>Réelle</th>
				</tr>
			</tfoot>
		</table>
		<div style="padding-top: 10px; float: left; width: 50%;">
			<table border="1">
				<tr>
					<th>Comparer les valeurs</th>
					<th>Brute</th>
					<th>Prévisionnel</th>
					<th>Réel</th>
				</tr>
				<tr>
					<td>Distance(km)</td>
					<td><div id="disbrut">
					<?php echo $total_distance_brute; ?>
						</div></td>
					<td><div id="disrel">
					<?php
					$total_distance_pre_km=$total_distance_pre/1000;
					echo $total_distance_pre_km; ?>
						</div></td>
					<td><div id="dispre"></div></td>
				</tr>
				<tr>
					<td>Durée(min)</td>
					<td><div id="durbrut">
					<?php echo $total_duration_brute; ?>
						</div></td>
					<td><div id="durrel"></div> <?php
					$total_duration_pre_min=round($total_duration_pre/60);
					echo $total_duration_pre_min; ?>
					</td>
					<td><div id="durpre"></div></td>
				</tr>
			</table>
		</div>
	</div>
	<div id="id_tournee"
		style="text-align: left; padding-top: 10px; float: right; width: 40%;">
	</div>
	<div id="detail"
		style="text-align: left; padding-top: 10px; float: right; width: 40%;">
	</div>
</div>
<div id="output" style="color: red;"></div>
