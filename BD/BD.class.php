<?php
/**
 * @package BD
 */
//session_start();
if ( ! isset($_SESSION['params'])) {
	$request_URI=explode('/',$_SERVER['REQUEST_URI']); // $_SERVER['REQUEST_URI'] : la référence  du fichier p/r à la racine du site web
	$size = count($request_URI)-1;
	$racine=$_SERVER['DOCUMENT_ROOT'];
	// On prend tout sauf le dernier ...
	for($i=1;$i<$size;$i++)
	$racine=$racine.'/'.$request_URI[$i];
	$nomhost = $_SERVER['SERVER_NAME'];
	if (strcmp($nomhost,"localhost") == 0) {
		$_SESSION['params']= $racine.'/config/localParams.php';
	} else if (strcmp($nomhost,"www.lgi2a.univ-artois.fr") == 0) {
		$_SESSION['params']=$racine.'/config/lgi2aParams.php';
	}
}

include_once ($_SESSION['params']);

/**
 *
 * Classe qui aide dans la manipule de la base de données
 * @author xuedong
 * @package BD
 */
class BD {

	protected $host,$user,$mdp,$db;
	protected $debug = true;
	protected $link;

	/**
	 * Constructeur pour se connecter à la base
	 */
	function __construct($h=HOSTNAME,$u=USER,$m=PASSWD,$d=DB) {
		$this->host = $h;
		$this->user = $u;
		$this->mdp  = $m;
		$this->db = $d;
		$this->link = mysql_connect($this->host,$this->user,$this->mdp);
		if (!$this->link) {
			die('Connexion impossible : ' . mysql_error());
		}
		mysql_select_db($this->db);
		mysql_query("SET NAMES 'utf8'");
	}

/**
	 * fonction pour se déconnecter de la base
	 */
	function closeConnexion(){
		mysql_close($this->link);
	}
/**
 *
 * ajouter, modifier et supprimer les données dans la BD
 * @param String $sql
 */
	function query($sql) {
		$res = mysql_query($sql);
		if($this->debug && mysql_errno()!=0) {
			echo "$sql<br />";
			die(mysql_error());
		}
		return $res;
	}

	function escapeString($variable) {
		return mysql_escape_string($variable);
	}

	function fetchAssoc($result) {
		return mysql_fetch_assoc($result);
	}

	function fetchArray($result) {
		return mysql_fetch_array($result);
	}

	function fetchRow($result) {
		return mysql_fetch_row($result);
	}

	function freeResult($result) {
		mysql_free_result($result);
	}

}

?>
