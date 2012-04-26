<?php
/**
 * @package pagesmembre
 */
	$idMembre = $_SESSION['id'];
    include_once('./modules/requests.dialog.php');
    include_once('./BD/requests.sql.php');
    include_once('./BD/favourites.sql.php');
?>

<script src="./javascript/requests.functions.js" type="text/javascript"></script>
<script src="./javascript/prototype/Request.prototype.js" type="text/javascript"></script>
<script src="./javascript/prototype/List.prototype.js" type="text/javascript"></script>

<h1> Gérer vos requêtes de covoiturage </h1> 
<article>
    <p> 
        Vous pouvez définir une requête de covoiturage qui sera traitée par le système. 
    </p>
    
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="requestsTable">
        <thead>
            <tr>
                <?php
                    $infos_image = @getImageSize("./images/details_open.png");
                    $largeur = $infos_image[0];
                    echo('<th width="'.$largeur.'"></th>'); 
                ?>
                <th>Date</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>RequestID</th>
                <th>Etat</th>
                <th>Itinéraire</th>
            
            </tr>
        </thead>
        <tbody>
            <?php
            
                $db = new BD();
                $requests = getUserRequests($idMembre, $db);
                for ($i=0; $i< count($requests); $i++) {
                    $request = $requests[$i];
                    $favfrom=getfav_debut($request,$db);
                    $favto=getfav_fin($request,$db);
                    $departposi=getposition_debut($request,$db);
                    $departlat=$departposi["LATITUDE"];
                    $departlng=$departposi["LONGITUDE"];
                    $finposi=getposition_fin($request,$db);
                    $finlat=$finposi["LATITUDE"];
                    $finlng=$finposi["LONGITUDE"];
                    $etatar=get_Etats_Requete($request,$db);
                    $eatder=$etatar[0];
                    $etat=$eatder["INTITULE"];
                    $addfrom=$favfrom['ADRESSE'].",".$favfrom['NOM'].",".$favfrom['NOMPAYS'];
                    $addto=$favto['ADRESSE'].",".$favto['NOM'].",".$favto['NOMPAYS'];
                    echo('<tr class="odd gradeU">');
                    echo('<td><img src="./images/details_open.png"></td>');
                    echo('<td>'.$favfrom['DATE'].'</td>');
                    echo('<td>'.$favfrom['ALIAS'].'</td>');
                    echo('<td>'.$favto['ALIAS'].'</td>');
                    echo('<td>'.$request.'</td>');
                    echo('<td>'.$etat.'</td>');
                    echo('<td>');
                    if($etat=="Effectué" || $etat=="Satisfait"){
                    echo('<form method="post" action="./afficherRoute.mediateur.php" target="_blank">');
                    echo('<input type="hidden" name="idreque" value="'.$request.'"/>');
                    echo('<input type="hidden" name="startlat" value="'.$departlat.'"/>');
                    echo('<input type="hidden" name="startlng" value="'.$departlng.'"/>');
                    echo('<input type="hidden" name="endlat" value="'.$finlat.'"/>');
                    echo('<input type="hidden" name="endlng" value="'.$finlng.'"/>');
                    echo('<input type="submit" value="Voir"/>');
                    echo('</form>');
                    }
                    echo('</td>');
                
                echo('<script language="Javascript">document.requests.put(
                                '.$request.',
                                new Request(
                                    "'.$addfrom.'",
                                    "'.$favfrom['ALIAS'].'",
                                    "'.$favfrom['DATE'].'",
                                    "'.$favfrom['HEUREDEBUT'].'",
                                    "'.$favfrom['HEUREFIN'].'",
                                    "'.$addto.'",
                                    "'.$favto['ALIAS'].'",
                                    "'.$favto['DATE'].'",
                                    "'.$favto['HEUREDEBUT'].'",
                                    "'.$favto['HEUREFIN'].'",
                                    '.$favfrom['CONDUCTEUR'].'
                                ));</script>');
                }
                $db->closeConnexion();
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>RequestID</th>
                <th>Etat</th>
                <th>Itinéraire</th>
            </tr>
        </tfoot>
    </table>
    
    <div id="moduleHoraire">
        <?php
            $db = new BD();
            $favourites = getUserFavourites($idMembre, $db);
            $db->closeConnexion();
            for ($i=0; $i< count($favourites); $i++) {
                $favourite = $favourites[$i];
                echo ('<script language="Javascript">document.favourites.add(new Favourite(
                                            "'.$favourite['ADRESSE'].'",
                                            '.$favourite['LATITUDE'].',
                                            '.$favourite['LONGITUDE'].',
                                            "'.$favourite['NOMPAYS'].'",
                                            "'.$favourite['NOM'].'",
                                            "'.$favourite['CP'].'",
                                            "'.$favourite['ALIAS'].'",
                                            "'.$favourite['COMMENTAIRE'].'",
                                            '.$favourite['PREDEFINI'].'
                                        ));</script>');
            }
            echo ('<script language="Javascript">addFavouritesToHTML(document.favourites, "departure")</script>');
            echo ('<script language="Javascript">addFavouritesToHTML(document.favourites, "arrival")</script>');
            echo ('<script language="Javascript">addFavouritesToHTML(document.favourites, "departurePer")</script>');
            echo ('<script language="Javascript">addFavouritesToHTML(document.favourites, "arrivalPer")</script>');
        ?>
    </div>
    
    <input value="Émettre une nouvelle requête" type="button" id="newReqBtn">
    <div id="output" style="color: red;"></div>
</article>