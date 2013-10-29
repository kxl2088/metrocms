<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Addons Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Modules
 */
class Module_Addons extends Module
{
	public $version = '2.0.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Add-ons',
				'br' => 'Complementos',
			),
			'description' => array(
				'en' => 'Allows admins to see a list of currently installed modules.',
				'br' => 'Permite aos administradores ver a lista dos módulos instalados atualmente.',
			),
			'extra' => array(
			    'sections_icon' => 'icon-list-alt',
			),
                        'roles' => array(
                          'admin_themes', 'modules', 'themes', 'plugins', 'widgets', 'fields'  
                        ),
			'frontend' => false,
			'backend' => true,
			'menu' => false,
		);
                
		if (function_exists('group_has_role'))
		{
		    $info['sections'] = array();                

		    if(group_has_role('addons', 'modules'))
		    {
			$info['sections']['modules'] = array(
					    'name' => 'addons:modules',
					    'uri' => 'admin/addons/modules',
			);
		    }
		    if(group_has_role('addons', 'themes'))
		    {
			$info['sections']['themes'] = array(
					    'name' => 'global:themes',
					    'uri' => 'admin/addons/themes',
			);
		    }
		    if(group_has_role('addons', 'admin_themes'))
		    {
			$info['sections']['admin_themes'] = array(
					    'name' => 'addons:admin_themes',
					    'uri' => 'admin/addons/admin_themes',
			);
		    } 
		    if(group_has_role('addons', 'plugins'))
		    {
			$info['sections']['plugins'] = array(
					    'name' => 'global:plugins',
					    'uri' => 'admin/addons/plugins',
			);
		    }
		    if(group_has_role('addons', 'widgets'))
		    {
			$info['sections']['widgets'] = array(
					    'name' => 'global:widgets',
					    'uri' => 'admin/addons/widgets',
			);
		    }
		    if(group_has_role('addons', 'field_types'))
		    {
			$info['sections']['field_types'] = array(
					    'name' => 'global:field_types',
					    'uri' => 'admin/addons/field-types',
			);
		    }
		}
                	
		// Add upload options to various modules
		if ( ! class_exists('Module_import') and Settings::get('addons_upload'))
		{
			$info['sections']['modules']['shortcuts'] = array(
				array(
					'name' => 'global:upload',
					'uri' => 'admin/addons/modules/upload',
					'class' => 'add modal-resize',
				),
			);

			$info['sections']['themes']['shortcuts'] = array(
				array(
					'name' => 'global:upload',
					'uri' => 'admin/addons/themes/upload',
					'class' => 'add modal-resize',
				),
			);
		}

		return $info;
	}

	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_addons'] = array();
                
                $this->lang->load('addons/addons');                
                
                if(group_has_role('addons', 'modules'))
                {
                    $menu['lang:cp:nav_addons']['lang:cp:nav_modules'] = 'admin/addons';
                }
                if(group_has_role('addons', 'themes'))
                {
                    $menu['lang:cp:nav_addons']['lang:global:themes'] = 'admin/addons/themes';
                }
                
                if(group_has_role('addons', 'admin_themes'))
                {
                    $menu['lang:cp:nav_addons']['lang:addons:admin_themes'] = 'admin/addons/admin_themes';
                }
                 
                if(group_has_role('addons', 'plugins'))
                {
                    $menu['lang:cp:nav_addons']['lang:global:plugins'] = 'admin/addons/plugins';
                }
                if(group_has_role('addons', 'widgets'))
                {
                    $menu['lang:cp:nav_addons']['lang:global:widgets'] = 'admin/addons/widgets';
                }
                if(group_has_role('addons', 'fields'))
                {
                    $menu['lang:cp:nav_addons']['lang:global:field_types'] = 'admin/addons/field-types';
                }                	

		add_admin_menu_place('lang:cp:nav_addons', 6);
	}

	public function install()
	{
		$this->dbforge->drop_table('theme_options');

		$tables = array(
			'theme_options' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 30),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100),
				'description' => array('type' => 'TEXT', 'constraint' => 100),
				'type' => array('type' => 'set', 'constraint' => array('text', 'textarea', 'password', 'select', 'select-multiple', 'radio', 'checkbox', 'colour-picker')),
				'default' => array('type' => 'VARCHAR', 'constraint' => 255),
				'value' => array('type' => 'VARCHAR', 'constraint' => 255),
				'options' => array('type' => 'TEXT'),
				'is_required' => array('type' => 'INT', 'constraint' => 1),
				'theme' => array('type' => 'VARCHAR', 'constraint' => 50),
			),
		);

		if ( ! $this->install_tables($tables)) {
			return false;
		}

		// Install settings
		$settings = array(
			array(
				'slug' => 'addons_upload',
				'title' => 'Addons Upload Permissions',
				'description' => 'Keeps mere admins from uploading addons by default',
				'type' => 'text',
				'default' => '0',
				'value' => '0',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 0,
				'module' => '',
				'order' => 0,
			),
			array(
				'slug' => 'default_theme',
				'title' => 'Default Theme',
				'description' => 'Select the theme you want users to see by default.',
				'type' => '',
				'default' => 'default',
				'value' => 'default',
				'options' => 'func:get_themes',
				'is_required' => 1,
				'is_gui' => 0,
				'module' => '',
				'order' => 0,
			),
			array(
				'slug' => 'admin_theme',
				'title' => 'Control Panel Theme',
				'description' => 'Select the theme for the control panel.',
				'type' => '',
				'default' => '',
				'value' => 'metrocms',
				'options' => 'func:get_themes',
				'is_required' => 1,
				'is_gui' => 0,
				'module' => '',
				'order' => 0,
			),
		);

		foreach ($settings as $setting)
		{
			if ( ! $this->db->insert('settings', $setting))
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
