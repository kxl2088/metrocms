<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * HTTPS Redirect plugin
 *
 * @package		Https Plugins
 * @author		Steve Williamson
 *
 */
class Plugin_Https extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Https',
	);
	public $description = array(
		'en' => 'Redirect or force secure connection session on front-end.',
	);

	/**
	 * Returns a PluginDoc array that MetroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'redirect' => array(
				'description' => array(
					'en' => 'Uses admin setting to determine whether or not to redirect to https.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
				),
			),// end first method
			'force' => array(
				'description' => array(
					'en' => 'Redirects to https if not viewing securely.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
				),
                            )
		);
	
		return $info;
	}
        
	/**
	 * redirect
	 *
	 * Usage:
	 * {{ https:redirect }}
	 *
	 * Uses admin setting to determine whether or not to redirect to https
	 */
	function redirect()
	{
		if ($this->settings->admin_force_https and strtolower(substr(current_url(), 4, 1)) != 's')
		{
			redirect(str_replace('http:', 'https:', current_url()).'?session='.session_id());
		}
	}

	/**
	 * force
	 *
	 * Usage:
	 * {{ https:force }}
	 *
	 * Redirects to https if not viewing securely
	 */
	function force()
	{
		if (strtolower(substr(current_url(), 4, 1)) != 's')
		{
			redirect(str_replace('http:', 'https:', current_url()).'?session='.session_id());
		}
	}
}