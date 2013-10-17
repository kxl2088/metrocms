<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * Languages helper for CodeIgniter.
 *
 * @author		Fabricio Rabelo
 * @package 	MetroCMS\Core\Helpers
 */

if (!function_exists('languages'))
{
	function languages()
	{
                //Get language config
                ci()->config->load('language');                
                $config_langs = ci()->config->item('supported_languages');     
                //Create a array to use to the supported languages
                $config = array();
                //Get avaliable languages
                $lang_settings = ci()->db->where('slug', 'site_public_lang')
                                          ->get('settings')
                                          ->row();        
                //Exploding "," and create an array
                $langs = explode(',', $lang_settings->value);
                //Test if the variable $langs is an array or execute "else" if the variable $langs isn't an array
	        if ( is_array($langs) )
                {
                    foreach ($langs as &$lang)
                    {
                        $config[$lang] = array(
                            'code'=> $lang, 
                            'link' => current_url().'?lang='.$lang,
                            'formated_link'=> anchor(current_url().'?lang='.$lang, $config_langs[$lang]['name']), 
                        )+$config_langs[$lang];
                        
                    }
                }
                else
                {
                    $config[$langs] = array(
                        'code'=> $langs, 
                        'link' => current_url().'?lang='.$langs,
                        'formated_link'=> anchor(current_url().'?lang='.$langs, $config_langs[$langs]['name']), 
                    )+$config_langs[$langs];
                }
                //Return the variable $config only with the avaliable languages on the system
                return $config;
        }
}