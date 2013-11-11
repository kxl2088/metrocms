<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * UTF8 helper for CodeIgniter.
 *
 * @author		Fabricio Rabelo
 * @package 	MetroCMS\Core\Helpers
 */

if (!function_exists('utf8_to_html'))
{
    function utf8_to_html($data)
    {
        
            $utf8 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "ñ", "Ñ", "ý", "Ý", "®", "©", "ø", "Ø", "Ð", "ð", "Æ", "æ", "Þ", "þ", "ß");
            $iso = array("&aacute;","&agrave;","&acirc;","&atilde;","&auml;","&eacute;","&egrave;","&ecirc;","&euml;","&iacute;","&igrave;","&icirc;","&iuml;","&oacute;","&ograve;","&ocirc;","&otilde;","&ouml;","&uacute;","&ugrave;","&ucirc;","&uuml;","&ccedil;","&Aacute;","&Agrave;","&Acirc;","&Atilde;","&Auml;","&Eacute;","&Egrave","&Ecirc;","&Euml;","&Iacute;","&Igrave;","&Icirc;","&Iuml;","&Oacute;","&Ograve;","&Ocirc;","&Otilde;","&Ouml;","&Uacute;","&Ugrave;","&Ucirc;","&Uuml;","&Ccedil","&ntilde;","&Ntilde;","&yacute;","&Yacute;","&reg;","&copy;","&oslash;","&Oslash;","&ETH;","&eth;","&AElig;","&aelig;","&THORN","&thorn;","&szlig;");
            
            $fixed = str_replace($utf8, $iso, $data);
            
            return $fixed;
    }
}
if (!function_exists('utf8_remove'))
{
    function utf8_remove($data)
    {
        
        $utf8 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", "ñ", "Ñ", "ý", "Ý", "®", "©", "ø", "Ø", "Ð", "ð", "Æ", "æ", "Þ", "þ", "ß");
        $iso = array("a","a","a","a","a","e","e","e","e","i","i","i","i","o","o","o","o","o","u","u","u","u","c","A","A","A","A","A","E","E","E","E","I","I","I","I","O","O","O","O","O","U","U","U","U","C","n","N","y","Y","","","","","","","","","","","");
        
        $fixed = str_replace($utf8, $iso, $data);
        
        return $fixed;
    } 
}