<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Navigation Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Navigation
 */
class Module_Navigation extends Module {

	public $version = '1.1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Navigation',
				'br' => 'Navegação',
			),
			'description' => array(
				'en' => 'Manage links on navigation menus and all the navigation groups they belong to.',
				'br' => 'Gerenciar links do menu de navegação e todos os grupos de navegação pertencentes a ele.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'	  => 'structure',

		    'shortcuts' => array(
				array(
				    'name' => 'nav:group_create_title',
				    'uri' => 'admin/navigation/groups/create',
				    'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('navigation_groups');
		$this->dbforge->drop_table('navigation_links');

		$tables = array(
			'navigation_groups' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'abbrev' => array('type' => 'VARCHAR', 'constraint' => 50, 'key' => true),
			),
			'navigation_links' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
                                'lang' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true,),
				'parent' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'link_type' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'uri',),
				'page_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'module_name' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => '',),
				'url' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'uri' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'navigation_group_id' => array('type' => 'INT', 'constraint' => 5, 'default' => 0, 'key' => 'navigation_group_id'),
				'position' => array('type' => 'INT', 'constraint' => 5, 'default' => 0,),
				'target' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => true,),
				'restricted_to' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true,),
				'class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
			),
		);
		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$groups = array(
			array('title' => 'Cabeçalho', 'abbrev' => 'header',),
			array('title' => 'Sidebar', 'abbrev' => 'sidebar',),
			array('title' => 'Rodapé', 'abbrev' => 'footer',),
		);
		foreach ($groups as $group)
		{
			if ( ! $this->db->insert('navigation_groups', $group))
			{
				return false;
			}
		}

		$links = array(
			array('title' => 'Home', 'lang' => '', 'link_type' => 'page', 'page_id' => 1, 'navigation_group_id' => 1, 'position' => 1,),
			array('title' => 'Blog', 'lang' => '', 'link_type' => 'module', 'page_id' => null, 'navigation_group_id' => 1, 'position' => 2, 'module_name' => 'blog'),
			array('title' => 'Contato', 'lang' => '', 'link_type' => 'page', 'page_id' => 2, 'navigation_group_id' => 1, 'position' => 3,),
		);
		foreach ($links as $link)
		{
			if ( ! $this->db->insert('navigation_links', $link))
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