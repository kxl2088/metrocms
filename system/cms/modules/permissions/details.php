<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Permissions Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Permissions
 */
class Module_Permissions extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Permissions',
				'br' => 'Permissões',
			),
			'description' => array(
				'en' => 'Control what type of users can see certain sections within the site.',
				'br' => 'Controle quais tipos de usuários podem ver certas seções no site.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'users',
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('permissions');

		$tables = array(
			'permissions' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'group_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'roles' => array('type' => 'TEXT', 'null' => true,),
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