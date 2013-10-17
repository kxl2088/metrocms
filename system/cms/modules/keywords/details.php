<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Keywords module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Keywords
 */
class Module_Keywords extends Module {

	public $version = '1.1.0';

	public $_tables = array('keywords', 'keywords_applied');

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Keywords',
				'br' => 'Palavras-chave',
			),
			'description' => array(
				'en' => 'Maintain a central list of keywords to label and organize your content.',
				'br' => 'Mantém uma lista central de palavras-chave para rotular e organizar o seu conteúdo.',
			),
			'frontend' => false,
			'backend'  => true,
			'menu'     => 'data',
			'shortcuts' => array(
				array(
			 	   'name' => 'keywords:add_title',
				   'uri' => 'admin/keywords/add',
				   'class' => 'add',
				),
			),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('keywords');
		$this->dbforge->drop_table('keywords_applied');

		return $this->install_tables(array(
			'keywords' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'name' => array('type' => 'VARCHAR', 'constraint' => 50,),
			),
			'keywords_applied' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => '',),
				'keyword_id' => array('type' => 'INT', 'constraint' => 11,),
			),
		));
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
