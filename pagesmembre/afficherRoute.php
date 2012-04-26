<?php 
/**
 * @package pagesmembre
 */
    include_once('./BD/requests.sql.php');
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="./javascript/constants.js" type="text/javascript"></script>
<script src="./javascript/itineraireshow.js" type="text/javascript"></script>
<script src="./javascript/direction.functions.js" type="text/javascript"></script>

<?php
    //obtenir start,end et endroits parcouris de la BD, pour donner les valeurs a document.start,document.end et document.waypts
    $startlat=$_POST["startlat"];
    $startlng=$_POST["startlng"];
    $endlat=$_POST["endlat"];
    $endlng=$_POST["endlng"];
    $idrequ=$_POST["idreque"];
    $db=new BD();
    $traordre=getIDtrajetparrequete($db,$idrequ);
    $idtraj=$traordre['IDTRAJET'];
    $order=$traordre['NUMORDRE'];
    $pointsway=getTrajetparRequete($db,$idtraj,$order);
    $db->closeConnexion();
    for($i=0;$i<count($pointsway);$i++)
    {
        $point=$pointsway[$i];
        $lati=$point["LATITUDE"];
        $lngi=$point["LONGITUDE"];
    
        echo '<script language="Javascript">
    var pt=new google.maps.LatLng('.$lati.','.$lngi.');
    document.waypts.push({
                location:pt,
                stopover:true});
    </script>';
    }
    echo '<script language="Javascript">
    var departre=new google.maps.LatLng('.$startlat.','.$startlng.');
    var endre=new google.maps.LatLng('.$endlat.','.$endlng.');
                      document.start=departre;
                      document.end=endre;
                      </script>';
?>

<h1>Itinéraires</h1>
<article>
    <p>Itinéraire prévisionnelle</p>
    <input type="checkbox" name="prevision" id="preiti" onClick="showDirection()" checked="checked">
    <img src="./images/blue.JPG" width="39" height="12"> 
    <p>Itinéraire réelle</p>
    <input type="checkbox" name="reel" id="reeliti" onClick="showDirection()" checked="checked">
    <img src="./images/red.JPG" width="39" height="12">
    <div id="map_canvas" style="float:left;width:55%;height:100%;"></div>
    <div id="control_panel" style="float:right;width:40%;text-align:left;padding-top:10px">
    <button id="preroute">Itinéraire prévisionnelle</button>
    <button id="relroute">Itinéraire réelle</button>
    <div id="directions_panel"></div>
    <div id="directions_panel1"></div>
</article>

