<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Maintenance Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Maintenance
 */
class Module_Maintenance extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Maintenance',
                                'br' => 'Manutenção',
			),
			'description' => array(
				'en' => 'Manage the site cache and export information from the database.',
                                'br' => 'Gerencie o cache do seu site e exporte informações da base de dados.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'data',
		);
	}


	public function install()
	{
		return true;
	}


	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}


	public function upgrade($old_version)
	{
		return true;
	}

}
