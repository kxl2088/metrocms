<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Languages Plugin
 *
 *
 * @author  Fabricio P. Rabelo
 * @package MetroCMS\Core\Plugins
 */
class Plugin_Languages extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Languages',
	);
	public $description = array(
		'en' => 'Create a list of supported languages on your front-end.',
	);

	/**
	 * Returns a PluginDoc array that MetroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 * @todo  I did the __call magic method... the others still need to be documented
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'dropdown' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Output the dropdown of supported languages on your front-end tracking code to your theme.'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'code|name|direction|folder|link|formated_link|codes|ckeditor',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(),
			),
		);
	
		return $info;
	}

	public function dropdown()
	{
                //Get language config
                $this->config->load('language');                
                $config_langs = $this->config->item('supported_languages');     
                //Create a array to use to the supported languages
                $config = array();
                //Get avaliable languages
                $lang_settings = $this->db->where('slug', 'site_public_lang')
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