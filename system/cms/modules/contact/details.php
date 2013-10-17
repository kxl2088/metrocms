<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Contact module
 *
 * @author  MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Contact
 */
class Module_Contact extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Contact',
				'br' => 'Contato',
			),
			'description' => array(
				'en' => 'Adds a form to your site that allows visitors to send emails to you without disclosing an email address to them.',
				'br' => 'Adiciona um formulário para o seu site permitir aos visitantes que enviem e-mails para voce sem divulgar um endereço de e-mail para eles.',
			),
			'frontend' => false,
			'backend' => false,
			'menu' => false,
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('contact_log');

		$tables = array(
			'contact_log' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'email' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'subject' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '',),
				'message' => array('type' => 'TEXT',),
				'sender_agent' => array('type' => 'VARCHAR', 'constraint' => 64, 'default' => '',),
				'sender_ip' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => '',),
				'sender_os' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => '',),
				'sent_at' => array('type' => 'INT', 'constraint' => 11, 'default' => 0,),
				'attachments' => array('type' => 'TEXT',),
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