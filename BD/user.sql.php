<?php
/**
 * @package BD
 */
/**
 * Get the ID of an user.
 * @param varchar $login
 * 			 the user login
 * @param BD $DB
 * 			 a database
 * @return bigint $row['IDPERSONNE']
 *                the user's ID
 */
function getUserId($login, $DB) {
	$formatedLogin = $DB->escapeString($login);
	$result = $DB->query("SELECT `IDPERSONNE` FROM `personne` WHERE `PSEUDO`='".$formatedLogin."' LIMIT 1");
	$row = $DB->fetchArray($result);
	$DB->freeResult($result);
	return $row['IDPERSONNE'];
}

/**
 * Check if the user is referenced as an administrator
 * @param bigint $userID
 * 			 the user ID
 * @param BD $DB
 * 			 a database
 * @return boolean 
 *                true if the user is an administrator
 */
function isAdmin($userID, $DB) {
	$query = 	'SELECT `USR_ADMIN` FROM `personne` WHERE `IDPERSONNE`= "'.$userID.'" ';
	$result = $DB->query($query);
	$array = $DB->fetchArray($result);
	$DB->freeResult($result);
	if ($array[0] == 1) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the login is referenced in the database.
 * @param varchar $login
 * 			 the user's login
 * @param char $password
 * 			 the user's password
 * @param BD $DB
 * 			 a database
 * @return int 
 *        the number of referenced user
 */
function existID($login, $password, $DB) {
	$formatedLogin = $DB->escapeString($login);
	$formatedPWD = md5($DB->escapeString($password));
	$query = 	'SELECT COUNT(*) FROM `personne`
				 WHERE `PSEUDO` = "'.$formatedLogin.'" AND `MDP` = "'.$formatedPWD.'"';
	$result = $DB->query($query);
	$array = $DB->fetchArray($result);
	$DB->freeResult($result);
	return $array[0];
}

/**
 * Test the exitence of an email address in the database
 * @param varchar $eMail
 * 			a well formated email address
 * @param BD $DB
 * 			 a database
 * @return boolean
 *           true if the email address is referenced
 */
function existEMailAddress($email, $DB) {
	$formatedEmail = $DB->escapeString($email);
	$query = 	'SELECT COUNT(*) FROM `personne`
				 WHERE `MAIL` = "'.$formatedEmail.'"';
	$result = $DB->query($query);
	$array = $DB->fetchArray($result);
	$DB->freeResult($result);
	return $array[0] > 0;
}

/**
 * Add a new user to the database
 * @param varchar $login
 * 			 the user's login
 * @param char $password
 * 			 the user's password
 * @param varchar $email
 * 			 the user's e-mail address
 * @param varchar $name
 * 			 the user's name
 * @param varchar $surname
 * 			 the user's surname
 * @param BD $DB
 * 			 a database
 */
function addUser($login, $password, $email, $name, $surname, $DB) {
	$formatedLogin = $DB->escapeString($login);
	$formatedPWD = md5($DB->escapeString($password));
	$formatedEmail = $DB->escapeString($email);
	$formatedName = $DB->escapeString($name);
	$formatedSurname = $DB->escapeString($surname);
	$query = 'INSERT INTO `personne`
			  VALUES (NULL,"'.$formatedName.'","'.$formatedSurname.'","'.$formatedLogin.'","'.$formatedPWD.'","'.$formatedEmail.'",0)';
	$result = $DB->query($query);
}

/**
 * Return an array containing user's usefull informations
 * @param BD $DB
 * 			 a database
 * @return ArrayObject $listUsers
 *         an array of user's information
 */
function getUsers($DB) {
	$result = $DB->query("
		SELECT `PSEUDO`, `MAIL`, `NOM`, `PRENOM`, `USR_ADMIN`
		FROM `personne`
	");
	while($user = $DB->fetchAssoc($result)) {
		$listUsers[] = $user;
	}
	$DB->freeResult($result);
	return $listUsers;
}

?>