<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Widgets Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Widgets
 */
class Module_Widgets extends Module {

	public $version = '1.2.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Widgets',
				'br' => 'Widgets',
			),
			'description' => array(
				'en' => 'Manage small sections of self-contained logic in blocks or "Widgets".',
				'br' => 'Gerenciar pequenas seções de conteúdos em bloco conhecidos como "Widgets".',
			),
			'extra' => array(
			    'sections_icon' => 'icon-th',
			),
			'frontend' 	=> false,
			'backend'  	=> true,
			'menu'	  	=> 'content',
			'skip_xss'	=> true,

			'sections' => array(
			    'instances' => array(
				    'name' => 'widgets:instances',
				    'uri' => 'admin/widgets',
				),
				'areas' => array(
				    'name' => 'widgets:areas',
				    'uri' => 'admin/widgets/areas',
				    'shortcuts' => array(
						array(
						    'name' => 'widgets:add_area',
						    'uri' => 'admin/widgets/areas/create',
                                                    'class' => 'add'
						),
				    ),
			    ),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('widget_areas');
		$this->dbforge->drop_table('widget_instances');
		$this->dbforge->drop_table('widgets');

		$tables = array(
			'widget_areas' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true,),
			),

			'widget_instances' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true,),
				'widget_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'widget_area_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true,),
				'options' => array('type' => 'TEXT'),
				'order' => array('type' => 'INT', 'constraint' => 10, 'default' => 0,),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),

			'widgets' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'title' => array('type' => 'TEXT', 'constraint' => 100,),
				'description' => array('type' => 'TEXT', 'constraint' => 100,),
				'author' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => '',),
				'website' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'version' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 0,),
				'enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 1,),
				'order' => array('type' => 'INT', 'constraint' => 10, 'default' => 0,),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		// Add the default data
		$default_widget_areas = array(
			'title' => 'Sidebar',
			'slug' 	=> 'sidebar',
		);

		if ( ! $this->db->insert('widget_areas', $default_widget_areas))
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
