<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Templates Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Templates
 */
class Module_Templates extends Module {

	public $version = '1.1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Email Templates',
				'br' => 'Modelos de e-mail',
			),
			'description' => array(
				'en' => 'Create, edit, and save dynamic email templates',
				'br' => 'Criar, editar e salvar modelos de e-mail dinâmicos.',
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'structure',
			'skip_xss' => true,
			'shortcuts' => array(
				array(
				    'name' => 'templates:create_title',
				    'uri' => 'admin/templates/create',
				    'class' => 'add',
				),
		    ),
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('email_templates');

		$tables = array(
			'email_templates' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'unique' => 'slug_lang',),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100,), // @todo rename this to 'title' to keep coherency with the rest of the modules
				'description' => array('type' => 'VARCHAR', 'constraint' => 255,), // @todo change this to TEXT to be coherent with the rest of the modules
				'subject' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'body' => array('type' => 'TEXT'),
				'lang' => array('type' => 'VARCHAR', 'constraint' => 2, 'null' => true, 'unique' => 'slug_lang',),
				'is_default' => array('type' => 'INT', 'constraint' => 1, 'default' => 0,),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => '',),
			),
		);

		if ( !$this->install_tables($tables))
		{
			return false;
		}

		// Insert the default email templates

		// @todo move this to the comments module
		$this->db->insert('email_templates',array(
			'slug' => 'comments',
			'name' => 'Notificação de Comentário',
			'description' => 'E-mail que é enviado ao administrador quando alguém cria um comentário',
			'subject' => 'Você acaba de receber um comentário de {{ name }}',
			'body' => "<h3>Você recebeu um comentário de {{ name }}</h3>
				<p>
				<strong>IP: {{ sender_ip }}</strong><br/>
				<strong>OS: {{ sender_os }}<br/>
				<strong>Navegador: {{ sender_agent }}</strong>
				</p>
				<p>{{ comment }}</p>
				<p>Ver Comentário: {{ redirect_url }}</p>",
			'lang' => 'br',
			'is_default' => 1,
			'module' => 'comments'
		));

		// @todo move this to the contact module
		$this->db->insert('email_templates',array(
			'slug' => 'contact',
			'name' => 'Notificação de Contato',
			'description' => 'Modelo para o formulário de contato',
			'subject' => '{{ settings:site_name }} :: Contato',
			'body' => 'Esta mensagem foi enviada através do formulário de contato com os seguintes detalhes:
				<hr />
				IP: {{ sender_ip }}<br />
				OS: {{ sender_os }}<br />
				Navegador: {{ sender_agent }}
				<hr />
                                Nome: {{ name }}<br />
                                E-mail: {{ email }}<br />
                                Telefone: {{ email }}<br />
                                Mensagem<br>
                                <p>{{ message }}</p>
				',
			'lang' => 'br',
			'is_default' => 1,
			'module' => 'pages'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'registered',
			'name' => 'Novo usuário registrou-se',
			'description' => 'E-mail enviado ao e-mail de contato do site quando um usuário se registra',
			'subject' => '{{ settings:site_name }} :: Você acaba de receber o registro de {{ name }}',
			'body' => '<h3>Você recebeu um registo de {{ name }}</h3>
				<p><strong>IP: {{ sender_ip }}</strong><br/>
				<strong>OS: {{ sender_os }}</strong><br/>
				<strong>Navegador: {{ sender_agent }}</strong>
				</p>',
			'lang' => 'br',
			'is_default' => 1,
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'activation',
			'name' => 'E-mail de Ativação',
			'description' => 'O e-mail que contém o código de ativação que é enviado para um novo usuário',
			'subject' => '{{ settings:site_name }} - Código de Ativação',
			'body' => '<p>Olá {{ user:first_name }},</p>
				<p>Obrigado por se registrar em {{ settings:site_name }}. Antes de podermos ativar sua conta, por favor preencha o processo de registro clicando no link abaixo:</p>
				<p><a href="{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}">{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}</a></p>
				<p>&nbsp;</p>
				<p>No caso do seu programa de e-mail não reconhece o link acima como, por favor direcionar seu navegador para a seguinte URL e digite o código de ativação:</p>
				<p><a href="{{ url:site }}users/activate">{{ url:site }}users/activate</a></p>
				<p><strong>Código de Ativação:</strong> {{ activation_code }}</p>',
			'lang' => 'br',
			'is_default' => 1,
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'forgotten_password',
			'name' => 'E-mail Esqueceu a Senha',
			'description' => 'O e-mail que é enviado com um código de redefinição de senha',
			'subject' => '{{ settings:site_name }} - Senha Esquecida',
			'body' => '<p>Olá {{ user:first_name }},</p>
				<p>Parece que você solicitou uma redefinição de senha. Por favor, clique neste link para completar o reajuste: <a href="{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}">{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}</a></p>
				<p>Se você não solicitar uma nova senha, por favor desconsidere esta mensagem. Nenhuma ação é necessária.</p>',
			'lang' => 'br',
			'is_default' => 1,
			'module' => 'users'
		));

		// @todo move this to the users module
		$this->db->insert('email_templates',array(
			'slug' => 'new_password',
			'name' => 'E-mail Nova Senha',
			'description' => 'Depois de uma senha ser reseta este e-mail é enviado contendo a nova senha',
			'subject' => '{{ settings:site_name }} - Nova Senha',
			'body' => '<p>Olá {{ user:first_name }},</p>
				<p>Sua nova senha é: {{ new_password }}</p>
				<p>Após o login, você pode mudar sua senha, visitando <a href="{{ url:site }}edit-profile">{{ url:site }}edit-profile</a></p>',
			'lang' => 'br',
			'is_default' => 1,
			'module' => 'users'
		));

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
