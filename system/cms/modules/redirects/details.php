<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Redirects module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Redirects
 */
class Module_Redirects extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Redirects',
				'br' => 'Redirecionamentos',
			),
			'description' => array(
				'en' => 'Redirect from one URL to another.',
				'br' => 'Redirecionamento de uma URL para outra.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'structure',

			'shortcuts' => array(
				array(
				    'name' => 'redirects:add_title',
				    'uri' => 'admin/redirects/add',
				    'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('redirects');

		$tables = array(
			'redirects' => array(
				'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'from' => array('type' => 'varchar', 'constraint' => 250, 'key' => 'request'),
				'to' => array('type' => 'varchar', 'constraint' => 250,),
				'type' => array('type' => 'int','constraint' => 3,'default' => 302),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

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
