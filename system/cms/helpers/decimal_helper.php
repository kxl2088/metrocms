<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * Decimal number conversor helper for CodeIgniter.
 *
 * @author		Fabricio Rabelo
 * @package 	MetroCMS\Core\Helpers
 */

if (!function_exists('decimal_usa_to_br'))
{
    function decimal_usa_to_br($dado){
        if ($dado != ""){
            return number_format($dado, 2, ",", ".");
        }else{
            return "";
        }
    }
}

if (!function_exists('decimal_br_to_usa'))
{
    function decimal_br_to_usa($dado){
            if ($dado != ""){
                return str_replace(",",'',number_format($dado, 2));
            } else {
                return "";
            }
    }
}