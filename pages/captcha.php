<?php
 /**
 * @package pages
 */
 /**
  * Created on 4 mai 07
  *
  * @autor : The Kankrelune
  * @copyright : The WebFaktory © 2006/2007
  * 
  */

function _captchaLettres()
{
    $str = 'abcdefghijklmnopqrstuvwxyz';// on crée la chaine
    $str .= strtoupper($str);
    $length = mt_rand(5,12);
    $str = substr(str_shuffle($str),0,$length);
    $pos = mt_rand(2,$length-1); // on choisi la position
    
    if(!isset($_SESSION))// on met le résultat en session puis on renvois la question
        session_start();
    
    $_SESSION['captchaResult'] = $str[$pos-1];
    
    return 'Dans <b>'.$str.'</b> quelle lettre se trouve entre <b>'.$str[$pos-2].'</b> et <b>'.$str[$pos].'</b>'; 
}

function _captchaCalculChiffres()
{
    $operators = array('-','+','*');
    $operator = $operators[array_rand($operators)];// on récup&egrave;re l'opérateur de calcul
    
    $nb1 = rand(1, 10);
    $nb2 = ($operator === '-') ? mt_rand(1, $nb1) : mt_rand(1, 10); // on évite les résultats négatif en cas de soustraction
    
    $calcul = $nb1.' '.$operator.' '.$nb2;
    
    if(!isset($_SESSION))// on met le résultat en session puis on renvois la question
        session_start();
    
    eval('$_SESSION[\'captchaResult\'] = strval('.$nb1.$operator.$nb2.');');

    return 'Combien font <b>'.$nb1.' '.($operator === '*' ? 'x' : $operator).' '.$nb2.'</b>';
}

function _captchaCalculLettres()
{
    $operators = array('-' => 'moins', '+' => 'plus', '*' => 'fois');
    $operator = array_rand($operators);
    $op = $operators[$operator]; // on récup&egrave;re l'opérateur de calcul
    
    $num = array(
                'zero', 'un', 'deux', 'trois',
                'quatre', 'cinq', 'six', 'sept',
                'huit', 'neuf', 'dix'
                );

    $nb1 = array_rand($num);
    $nb2 = array_rand($num);
    
    if($operator === '-' && $nb1 < $nb2)
        while($nb1 < ($nb2 = array_rand($num))); // on évite les résultats négatif en cas de soustraction
    
    if(!isset($_SESSION)) // on met le résultat en session puis on renvois la question
        session_start();

    eval('$_SESSION[\'captchaResult\'] = strval('.$nb1.$operator.$nb2.');');

    return 'Combien font <b>'.$num[$nb1].' '.$op.' '.$num[$nb2].'</b>';
} 

function _captchaAlphaNum()
{
    $str = md5(time()); // création de la chaine
    $length = mt_rand(5,12);
    $str = substr($str,0,$length);
    $pos = mt_rand(1,$length); // on choisi la position
    
    if(!isset($_SESSION))// on met le résultat en session puis on renvois la question
        session_start();
    
    $_SESSION['captchaResult'] = $str[$pos-1];
    
    if($pos === 1)
        $pos = 'le premier';
            elseif($pos === 2)
                $pos = 'le second';
                    elseif($pos === $length)
                        $pos = 'le dernier';
                            elseif($pos === ($length-1))
                                $pos = 'l\'avant dernier';
                                    else
                                        $pos = 'le '.$pos.'&egrave;me';
    
    return 'Quel est '.$pos.' caract&egrave;re dans <b>'.$str.'</b>';
}


function getCaptcha()
{
    $functions = array(
                    '_captchaLettres',  '_captchaCalculChiffres',
                    '_captchaCalculLettres', '_captchaAlphaNum'
                    );
    
    $captcha = $functions[array_rand($functions)];
    return $captcha();
}


function checkCaptcha()
{
    if(!isset($_SESSION))
        session_start();
	
	if(!isset($_SESSION['captchaResult']))
		return false;
	
	if(!is_numeric($_SESSION['captchaResult']))
	{
		$_POST['captchaResult'] = strtolower($_POST['captchaResult']);
		$_SESSION['captchaResult'] = strtolower($_SESSION['captchaResult']);
	}
	
	return ($_POST['captchaResult'] === $_SESSION['captchaResult']);
}

?>