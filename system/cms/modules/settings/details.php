<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Settings module
 *
 * @author  MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Settings
 */
class Module_Settings extends Module
{

	public $version = '1.0.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Settings',
				'br' => 'Configurações',
			),
			'description' => array(
				'en' => 'Allows administrators to update settings like Site Name, messages and email address, etc.',
				'br' => 'Permite com que administradores e a equipe consigam trocar as configurações do website incluindo o nome e descrição.',
			),
			'frontend' => false,
			'backend' => true,
			'skip_xss' => true,
			'menu' => 'settings',
		);
	}

	public function admin_menu(&$menu)
	{
		unset($menu['lang:cp:nav_settings']);

		$menu['lang:cp:nav_settings'] = 'admin/settings';

		add_admin_menu_place('lang:cp:nav_settings', 7);
	}

	public function install()
	{
		$this->dbforge->drop_table('settings');

		log_message('debug', '-- Settings: going to install the settings table');
		$tables = array(
			'settings' => array(
				'slug' => array('type' => 'VARCHAR', 'constraint' => 30, 'primary' => true, 'unique' => true, 'key' => 'index_slug'),
				'title' => array('type' => 'VARCHAR', 'constraint' => 100,),
				'description' => array('type' => 'TEXT',),
				'type' => array('type' => 'set', 'constraint' => array('text', 'textarea', 'password', 'select', 'select-multiple', 'radio', 'checkbox'),),
				'default' => array('type' => 'TEXT',),
				'value' => array('type' => 'TEXT',),
				'options' => array('type' => 'VARCHAR', 'constraint' => 255,),
				'is_required' => array('type' => 'INT', 'constraint' => 1,),
				'is_gui' => array('type' => 'INT', 'constraint' => 1,),
				'module' => array('type' => 'VARCHAR', 'constraint' => 50,),
				'order' => array('type' => 'INT', 'constraint' => 10, 'default' => 0,),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}
		log_message('debug', '-- -- ok settings table');

		log_message('debug', '-- Settings: going to install the default settings');
		// Regarding ordering: any additions to this table can have an order
		// value the same as a sibling in the same section. For example if you
		// add to the Email tab give it a value in the range of 983 to 975.
		// Third-party modules should use lower numbers or 0.
		$settings = array(
			'site_name' => array(
				'title' => 'Site Name',
				'description' => 'The name of the website for page titles and for use around the site.',
				'type' => 'text',
				'default' => 'Site sem nome',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 1000,
			),
			'site_slogan' => array(
				'title' => 'Site Slogan',
				'description' => 'The slogan of the website for page titles and for use around the site',
				'type' => 'text',
				'default' => '',
				'value' => 'Adicione seu slogan aqui',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 999,
			),
			'meta_topic' => array(
				'title' => 'Meta Topic',
				'description' => 'Two or three words describing this type of company/website.',
				'type' => 'text',
				'default' => 'Gerenciamento de Conteúdo',
				'value' => 'Adicione seu slogan aqui',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 998,
			),
			'site_lang' => array(
				'title' => 'Site Language',
				'description' => 'The native language of the website, used to choose templates of e-mail notifications, contact form, and other features that should not depend on the language of a user.',
				'type' => 'select',
				'default' => DEFAULT_LANG,
				'value' => DEFAULT_LANG,
				'options' => 'func:get_supported_lang',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 997,
			),
			'site_public_lang' => array(
				'title' => 'Public Languages',
				'description' => 'Which are the languages really supported and offered on the front-end of your website?',
				'type' => 'checkbox',
				'default' => DEFAULT_LANG,
				'value' => DEFAULT_LANG,
				'options' => 'func:get_supported_lang',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 996,
			),
                    
                        'recaptcha_public_key' => array(
                                'title' => 'reCAPTCHA Public Key',
                                'description' => 'Type your reCAPTCHA Public Key for send information with security via forms on this site.',
                                'type' => 'text',
                                'default' => '',
                                'value' => '',
                                'options' => '',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => '',
                                'order' => 995,
                         ),
                         'recaptcha_private_key' => array(
                                'title' => 'reCAPTCHA Private Key',
                                'description' => 'Type your reCAPTCHA Private Key for send information with security via forms on this site.',
                                'type' => 'text',
                                'default' => '',
                                'value' => '',
                                'options' => '',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => '',
                                'order' => 994,
                         ),
                    
			'date_format' => array(
				'title' => 'Date Format',
				'description' => 'How should dates be displayed across the website and control panel? Using the <a target="_blank" href="http://php.net/manual/en/function.date.php">date format</a> from PHP - OR - Using the format of <a target="_blank" href="http://php.net/manual/en/function.strftime.php">strings formatted as date</a> from PHP.',
				'type' => 'text',
				'default' => 'F j, Y g:i a',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 993,
			),
			'currency' => array(
				'title' => 'Currency',
				'description' => 'The currency symbol for use on products, services, etc.',
				'type' => 'text',
				'default' => 'R$',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 992,
			),
			'records_per_page' => array(
				'title' => 'Records Per Page',
				'description' => 'How many records should we show per page in the admin section?',
				'type' => 'select',
				'default' => '25',
				'value' => '',
				'options' => '5=5|10=10|25=25|50=50|100=100|200=200',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 991,
			),
			'rss_feed_items' => array(
				'title' => 'Feed item count',
				'description' => 'How many items should we show in RSS/blog feeds?',
				'type' => 'select',
				'default' => '25',
				'value' => '',
				'options' => '5=5|10=10|25=25|50=50|100=100|200=200',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 990,
			),
			'dashboard_rss' => array(
				'title' => 'Dashboard RSS Feed',
				'description' => 'Link to an RSS feed that will be displayed on the dashboard.',
				'type' => 'text',
				'default' => 'http://www.fabriciorabelo.com/blog/rss/all.rss',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 989,
			),
			'dashboard_rss_count' => array(
				'title' => 'Dashboard RSS Items',
				'description' => 'How many RSS items would you like to display on the dashboard?',
				'type' => 'text',
				'default' => '5',
				'value' => '5',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 988,
			),
			'frontend_enabled' => array(
				'title' => 'Site Status',
				'description' => 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenance.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Open|0=Closed',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 987,
			),
			'unavailable_message' => array(
				'title' => 'Unavailable Message',
				'description' => 'When the site is turned off or there is a major problem, this message will show to users.',
				'type' => 'textarea',
				'default' => 'Desculpe, o site está fechado temporariamente para manutenção.',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => '',
				'order' => 986,
			),
                        'blog_intro_limit' => array(
				'title' => 'Blog intro limit',
				'description' => 'Default intro limit to the list of blog posts.',
				'type' => 'text',
				'default' => 100,
				'value' => 100,
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'blog',
				'order' => 999,
			),
                        'blog_use_intro_limit' => array(
				'title' => 'Use blog\'s intro limit?',
				'description' => 'The intro will be limited as text and will have a limit of words, defined before this.',
				'type' => 'radio',
				'default' => 1,
				'value' => '',
				'options' => '1=Yes|0=No',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'blog',
				'order' => 998,
			),
                        'blog_intro_delimiter' => array(
				'title' => 'Blog delimiter to blog intro',
				'description' => 'Adds a delimiter at the end of the text in the blog\'s intro. Ex: ... or [...]',
				'type' => 'text',
				'default' => '...',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'blog',
				'order' => 997,
			),
                        'blog_enable_gallery' => array(
				'title' => 'Enable blog gallery',
				'description' => 'Enable to use a gallery in the blog posts.',
				'type' => 'radio',
				'default' => '0',
				'value' => '',
				'options' => '1=Yes|0=No',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'blog',
				'order' => 996,
			),
			'ga_tracking' => array(
				'title' => 'Google Tracking Code',
				'description' => 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 985,
			),
			'ga_profile' => array(
				'title' => 'Google Analytic Profile ID',
				'description' => 'Profile ID for this website in Google Analytics',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 984,
			),
			'ga_email' => array(
				'title' => 'Google Analytic E-mail',
				'description' => 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 983,
			),
			'ga_password' => array(
				'title' => 'Google Analytic Password',
				'description' => 'This is also needed to show the graph on the dashboard. You will need to allow access to Google to get this to work. See <a href="https://accounts.google.com/b/0/IssuedAuthSubTokens?hl=en_US" target="_blank">Authorized Access to your Google Account</a>',
				'type' => 'password',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'integration',
				'order' => 982,
			),
			'contact_email' => array(
				'title' => 'Contact E-mail',
				'description' => 'All e-mails from users, guests and the site will go to this e-mail address.',
				'type' => 'text',
				'default' => DEFAULT_EMAIL,
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 944,
			),
			'server_email' => array(
				'title' => 'Server E-mail',
				'description' => 'All e-mails to users will come from this e-mail address.',
				'type' => 'text',
				'default' => 'admin@localhost',
				'value' => '',
				'options' => '',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 943,
			),
			'mail_protocol' => array(
				'title' => 'Mail Protocol',
				'description' => 'Select desired email protocol.',
				'type' => 'select',
				'default' => 'mail',
				'value' => 'mail',
				'options' => 'mail=Mail|sendmail=Sendmail|smtp=SMTP',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 942,
			),
			'mail_smtp_host' => array(
				'title' => 'SMTP Host Name',
				'description' => 'The host name of your smtp server.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 938,
			),
			'mail_smtp_pass' => array(
				'title' => 'SMTP password',
				'description' => 'SMTP password.',
				'type' => 'password',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 936,
			),
			'mail_smtp_port' => array(
				'title' => 'SMTP Port',
				'description' => 'SMTP port number.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 937,
			),
			'mail_smtp_user' => array(
				'title' => 'SMTP User Name',
				'description' => 'SMTP user name.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 935,
			),
			'mail_sendmail_path' => array(
				'title' => 'Sendmail Path',
				'description' => 'Path to server sendmail binary.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 934,
			),
                        'mail_line_endings' => array(
				'title' => 'Email Line Endings',
				'description' => 'Change from the standard \r\n line ending to PHP_EOL for some email servers.',
				'type' => 'select',
				'default' => 1,
				'value' => '1',
				'`options`' => '0=PHP_EOL|1=\r\n',
				'is_required' => false,
				'is_gui' => 1,
				'module' => 'email',
				'order' => 972,
			),
			// @todo 'twitter_username' setting is not used anywhere, maybe remove this? (Check thouroughly first)
			'twitter_username' => array(
				'title' => 'Username',
				'description' => 'Twitter username.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'twitter',
				'order' => 971,
			),
			// @todo 'twitter_feed_count' setting is not used anywhere, maybe remove this? (Check thouroughly first)
			'twitter_feed_count' => array(
				'title' => 'Feed Count',
				'description' => 'How many tweets should be returned to the Twitter feed block?',
				'type' => 'text',
				'default' => '5',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'twitter',
				'order' => 970,
			),
			'twitter_cache' => array(
				'title' => 'Cache time',
				'description' => 'How many seconds should your Tweets be stored?',
				'type' => 'text',
				'default' => '300',
				'value' => '',
				'options' => '',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'twitter',
				'order' => 969,
			),
			'admin_force_https' => array(
				'title' => 'Force HTTPS for Control Panel?',
				'description' => 'Allow only the HTTPS protocol when using the Control Panel?',
				'type' => 'radio',
				'default' => false,
				'value' => '',
				'options' => '1=Yes|0=No',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => '',
				'order' => 0,
			),
			// @todo It should be possibile to move this into the users module. (but would it make sense?)
			'api_enabled' => array(
				'title' => 'API Enabled',
				'description' => 'Allow API access to all modules which have an API controller.',
				'type' => 'select',
				'`default`' => false,
				'value' => '0',
				'`options`' => '0=Disabled|1=Enabled',
				'is_required' => false,
				'is_gui' => false,
				'module' => 'api',
				'order' => 0,
			),
			// @todo It should be possibile to move this into the users module. (but would it make sense?)
			'api_user_keys' => array(
				'title' => 'API User Keys',
				'description' => 'Allow users to sign up for API keys (if the API is Enabled).',
				'type' => 'select',
				'`default`' => false,
				'value' => '0',
				'`options`' => '0=Disabled|1=Enabled',
				'is_required' => false,
				'is_gui' => false,
				'module' => 'api',
				'order' => 0,
			),
			'cdn_domain' => array(
				'title' => 'CDN Domain',
				'description' => 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.',
				'type' => 'text',
				'default' => '',
				'value' => '',
				'options' => '',
				'is_required' => false,
				'is_gui' => true,
				'module' => 'integration',
				'order' => 1000,
			),      
		);

		// Lets add the settings for this module.
		foreach ($settings as $slug => $setting_info)
		{
			log_message('debug', '-- Settings: installing '.$slug);
			$setting_info['slug'] = $slug;
			if ( ! $this->db->insert('settings', $setting_info))
			{
				log_message('debug', '-- -- could not install '.$slug);

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