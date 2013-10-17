<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Helpers
 *
 * @package	CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author	Fabricio Pereira Rabelo
 */
// ------------------------------------------------------------------------

/**
 * Create a introduction of blog posts of this is bigger what predefined.
 * 
 * @access public
 * @return string
 */
if (!function_exists('prepare_intro'))
{
        function prepare_intro($intro = NULL, $limit = NULL, $delimiter = NULL)
        {
            // setting limit
            is_null($limit) ? $limit = 100 : $limit = $limit;
            // delimiter
            is_null($delimiter) ? $delimiter = '...' : $delimiter = $delimiter;

            // remove html tags
            $intro = strip_tags($intro);    
            // if the value intro is not null
            $intro_broke = explode(' ', $intro);
            $intro_count = count($intro_broke);    
            $return = $intro;

            if( !is_null($intro) && $intro_count > $limit)
            {
                // intro
                $intro = strip_tags($intro);
                // retorno
                $words = explode(" ", $intro);        
                // string
                $str = "";
                for ($i = 0; $i < $limit; $i++)
                {
                        $str .= $words[$i] . " ";
                }
                $return = $str . $delimiter;
            }
            else
            {
                // return intro
                $return = $intro;
            }    

            return $return;
        }
}
/* End of file helpers/introduce_helper.php */