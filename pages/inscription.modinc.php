<?php
 /**
 * @package pages
 */
    include_once ('./BD/user.sql.php');
    include_once ('./BD/vehicule.sql.php');
    require(dirname(__FILE__).DIRECTORY_SEPARATOR.'captcha.php');
    if(isset($_POST['captchaResult']))
    {
        if(checkCaptcha())
        $result = 456;
        else
        $result = 123;
    }
    else 
    $result = '';
    
    $captcha = getCaptcha();
?>
<h1>Inscription</h1>
<article>
<?php
    include('protection-sql.php');
    
    /*
     1 = champ non rempli
     2 = mail non valide
     3 = mail existant
     4 = login existant
     5 = mots de passe differents
     */
    
    if($result==456)
    {
        $erreur = verification();
        switch($erreur){
            case 1 :
                echo "<span class='redtext'> Un ou plusieurs champ(s) n'ont pas été rempli(s)</span></span>";
                break;
            case 2 :
                echo "<span class='redtext'> L'adresse de couriel n'est pas valide</span>";
                break;
            case 3 :
                echo "<span class='redtext'> L'adresse de couriel est déjà utilisée</span>";
                break;
            case 4 :
                echo "<span class='redtext'> Le login est déjà utilisé.</span>";
                break;
            case 5 :
                echo "<span class='redtext'> Les mots de passe sont differents</span>";
                break;
            default :
                performInscription();
                echo "<p>Inscription réussi.</p>";
                break;         
        }
    }
    if($result==123)
    echo "<p>Le champ anti-rot doit être bien rempli.</p>";
?>

<span class="inscription">
    <form method='POST' action='#'>
        <table cellspacing="15">
            <tr>
                <td>Nom <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="text" name="surname"\></td>
            </tr>
            <tr>
                <td>Prénom <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="text" name="name"\></td>
            </tr>
            <tr>
                <td>Login <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="text" name="login"\></td>
            </tr>
            <tr>
                <td>Mot de passe <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="password" name="password"\></td>
            </tr>
            <tr>
                <td>Confirmation du mot de passe <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="password" name="confirmPassword"\></td>
            </tr>
            <tr>
                <td>Adresse de courriel <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="text" name="e-mail"\></td>
            </tr>
            <tr>
                <td>Je possède une voiture</td>
                <td><input type="checkbox" name="voiture"
                    onchange="changer(this.checked)"\> Oui</td>
            </tr>
            <tr>
                <td><span id="cacher">Nombre de places <abbr title="Champ Obligatoire">*</abbr></span></td>
                <td>
                    <span id="cacher2"> 
                        <select id="nbplace" size="1" name="nbplace">
                            <option value="2">2</option>
                            <!--<input type="text" name="nbplace" \>-->
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select> 
                    </span></td>
            </tr>
            <tr>
                <td><span id="cacher3">Immatriculation <abbr title="Champ Obligatoire">*</abbr></span></td>
                <td><span id="cacher4"> <input type='text' name='imma'\> </span></td>
            </tr>
            <tr>
                <td><?php echo $captcha;?> <abbr title="Champ Obligatoire">*</abbr></td>
                <td><input type="text" name="captchaResult" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="valider"
                    value="Valider l'enregistrement"\></td>
            </tr>
        </table>
    </form>
</span>

<?php
/**
 * 
 *  fonction qui verifie si le champs est vide
 * 
 */
function verif_null($var){ 
	if(!$var!="") {
		return 1;
	}
}

/**
 * 
 *  fonction qui verifie si le champs est vide
 * 
 */
function isEmptyField($var) {
	if (is_string($var) && strlen($var) > 0) {
		return false;
	} else {
		return true;
	}
}

/**
 * 
 *  fonction qui verifie s'il existe des champs vides
 * 
 */
function existEmptyField($array) {
	foreach ($array as $variable) {
		if(isEmptyField($variable)) {
			return true;
		}
	}
	return false;
}

/**
 * 
 * vérifier si l'adresse mail est valide
 * @param String $email
 */
function isValidEmailAddress($email) {
	$atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';
	$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';
	$regex = '/^' . $atom . '+' . '(\.' . $atom . '+)*' . '@' . '(' . $domain . '{1,63}\.)+' . $domain . '{2,63}$/i';
	if (preg_match($regex, $email)) {
	    return true;
	} else { 
	    return false;
	}
}

/**
 * 
 * vérifier si l'adresse mail existe dans la base de données
 * @param String $email
 */
function isReferencedEmail($email) {
	$db = new BD();
	$exist = existEMailAddress($email, $db);
	$db->closeConnexion();
	return $exist;
	
}

/**
 * 
 * vérifier si login existe dans la base de données
 * @param String $login
 */
function isReferencedLogin($login) {
	$db = new BD();
	$userID = getUserId($login, $db);
	$db->closeConnexion();
	return $userID != 0;
	
}

/**
 * 
 * Inscription d'un utilisateur
 */
function performInscription(){
	
if(isset($_POST['voiture']))
	{
		if(trim($_POST['imma'])=='')
		{
		echo " <span class='redtext'> Un ou plusieurs champ(s) n'ont pas été rempli(s)</span></span>";	
			exit;
		}
		$db = new BD();
	$login = $_POST['login'];
	$password = $_POST['password'];
	$email = $_POST['e-mail'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	addUser($login, $password, $email, $name, $surname, $db);
		
	$per_id=getUserId($login, $db);
	$nombre=$_POST['nbplace'];	
	$imma=$_POST['imma'];
	addVoiture($imma,$per_id,$nombre,$db);
	
	$db->closeConnexion();
	}
	else
	{
	$db = new BD();
	$login = $_POST['login'];
	$password = $_POST['password'];
	$email = $_POST['e-mail'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	addUser($login, $password, $email, $name, $surname, $db);
	
		
	$db->closeConnexion();
}
}

/**
 * 
 * Vérifier les informations de l'inscription avant d'enregistrer dans la base de données 
 */
function verification(){

	if (existEmptyField(array($_POST['surname'], $_POST['name'], $_POST['login'],
								$_POST['password'], $_POST['confirmPassword'], $_POST['e-mail']))) {
		return 1;
	}

	if(!isValidEmailAddress($_POST['e-mail'])) {
		return 2;
	}
	
	if(isReferencedEmail($_POST['e-mail'])) {
		return 3;
	}
	
	if(isReferencedLogin($_POST['login'])) {
		return 4;
	}

	if ($_POST['password'] != $_POST['confirmPassword']) {
		return 5;
	}
	
	return 0;
}
	
?>