<?php
 /**
 * @package traitement
 */
    include_once('../BD/BD.class.php');
    include_once('../BD/ODMatrix.sql.php');
    include_once ('../BD/favourites.sql.php');
    include_once('../modules/fonctionsUtiles.php');
    if(isset($_POST['address']))
    {
        $idusr=$_POST['idusr'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $db = new BD();
        $idpoint=getIDPOINT($db,round($lat,7),round($lng,7));
        if($idpoint==null)
        {
            $queryIDville  = 'SELECT `ID_VILLE`
                        FROM `ville`
                        WHERE `NOM` = "'.$city.'"';
    
            $idville = $db->query($queryIDville);
            $result = mysql_fetch_row($idville);
            $cityID=$result[0];
            $queryAddPOINT = 'INSERT INTO `point`
                        (`IDVILLE`, `ADRESSE`,`LATITUDE`,`LONGITUDE`)
                        VALUES ('.$cityID.', "'.$address.'", '.$lat.', '.$lng.')';
            $db->query($queryAddPOINT);
            $sqllast="select LAST_INSERT_ID()";
            $idadd= mysql_fetch_row($db->query($sqllast));
            $idpoint=$idadd[0];
            addAddressODMatrix($idpoint, $db);
        }
        $queryAddFav = 'INSERT INTO `favori`
                        (`ALIAS`, `COMMENTAIRE`, `PREDEFINI`,`IDPERSONNE`,`IDPOINT`)
                        VALUES ("favori 1",null ,0,'.$idusr.','.$idpoint.')';
        $db->query($queryAddFav);
        $db->closeConnexion();
    }
    
    if(isset($_POST['nofound']))
    {
        $db = new BD();
        $idusr=$_POST['idusr'];
        $sqlinsert='insert into favori values("","erreur",null,0,'.$idusr.',0)';
        $db->query($sqlinsert);
        $db->closeConnexion();
    }
?>