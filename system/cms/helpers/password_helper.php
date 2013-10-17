<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * Passsword generator helper for CodeIgniter.
 *
 * @author		Fabricio Rabelo
 * @package 	MetroCMS\Core\Helpers
 */
if (!function_exists('password'))
{


    /**
    * Function to generate random passwords
    *
    * @author Fabricio Rabelo <fabricio@fabriciorabelo.com>
    *
    * @param integer $lenght lenght of the password will create
    * @param boolean $uppercase it will have uppercase leters?
    * @param boolean $numbers it will have numbers?
    * @param boolean $simbols it will have simbols?
    *
    * @return string A senha gerada
    */
    function password($lenght = 8, $uppercase = true, $numbers = true, $simbols = false)
    {
    //Strings
    $lmin = 'abcdefghijklmnopqrstuvwxyz';
    $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $num = '1234567890';
    $simb = '!@#$%*-';
    
    //Result to return
    $result = '';
    //Chars to mount return
    $chars = '';
    $chars .= $lmin;
    
    if ($uppercase){ $chars .= $lmai; }
    if ($numbers){ $chars .= $num; }
    if ($simbols){ $chars .= $simb; }

    $len = strlen($chars);
    
    for ($n = 1; $n <= $lenght; $n++) {
        $rand = mt_rand(1, $len);
        $result .= $chars[$rand-1];
    }
    
    return $result;
    
    }   
    
}