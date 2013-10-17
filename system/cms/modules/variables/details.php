<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Variables Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Variables
 */
class Module_Variables extends Module {

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Variables',
				'br' => 'Variáveis',
			),
			'description' => array(
				'en' => 'Manage global variables that can be accessed from anywhere.',
				'br' => 'Gerencia as variáveis globais acessíveis de qualquer lugar.',

			),
                        'frontend'	=> false,
			'backend'	=> true,
			'menu'		=> 'data',
			'shortcuts' => array(
				array(
				    'name' => 'variables:create_title',
				    'uri' => 'admin/variables/create',
					'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('variables');

		$tables = array(
			'variables' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 250, 'null' => true,),
				'data' => array('type' => 'VARCHAR', 'constraint' => 250, 'null' => true,),
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