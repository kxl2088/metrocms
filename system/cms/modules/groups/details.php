<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Groups module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Groups
 */
 class Module_Groups extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Groups',
				'br' => 'Grupos',
			),
			'description' => array(
				'en' => 'Users can be placed into groups to manage permissions.',
				'br' => 'Usuários podem ser inseridos em grupos para gerenciar suas permissões.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'users',
                        'roles'	=> array('admin_groups'),
			'shortcuts' => array(
				array(
					'name' => 'groups:add_title',
					'uri' => 'admin/groups/add',
					'class' => 'add'
				),
			)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('groups');

		$tables = array(
			'groups' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'description' => array('type' => 'VARCHAR', 'constraint' => 250, 'null' => true,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$groups = array(
			array('name' => 'admin', 'description' => 'Administrador',),
			array('name' => 'user', 'description' => 'Usuário',),
		);

		foreach ($groups as $group)
		{
			if ( ! $this->db->insert('groups', $group))
			{
				return false;
			}
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