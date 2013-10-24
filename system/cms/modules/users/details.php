<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Users
 */
class Module_Users extends Module {

	public $version = '1.1.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Users',
				'br' => 'Usuários',
			),
			'description' => array(
				'en' => 'Let users register and log in to the site, and manage them via the control panel.',
				'br' => 'Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.',
			),
                        'extra' => array(
                            'dashboard' => array(
                                'class' => 'brown',
                                'title' => 'lang:cp:manage_users',
                                'icon' => 'icon-user'
                            )
                        ),
			'frontend' 	=> false,
			'backend'  	=> true,
			'menu'	  	=> false,
			'roles'		=> array('admin_users','admin_profile_fields')
			);

		if (function_exists('group_has_role'))
		{
                        if(group_has_role('users', 'admin_users'))
			{
                            
                            $info['sections']['users'] = array(
							'name' 	=> 'user:list_title',
							'uri' 	=> 'admin/users',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'user:add_title',
										'uri' 	=> 'admin/users/create',
										'class' => 'add'
										)
									
								),
                                );
                            
                        }
			if(group_has_role('users', 'admin_profile_fields'))
			{
				$info['sections']['fields'] = array(
							'name' 	=> 'user:profile_fields_label',
							'uri' 	=> 'admin/users/fields',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'user:add_field',
										'uri' 	=> 'admin/users/fields/create',
										'class' => 'add'
										)
									)								
						);
			}
		}

		return $info;
	}

	public function admin_menu(&$menu)
	{
		$menu['lang:cp:nav_users']['lang:cp:nav_users'] = 'admin/users';
	}

	/**
	 * Installation logic
	 *
	 * This is handled by the installer only so that a default user can be created.
	 *
	 * @return boolean
	 */
	public function install()
	{
		// Load up the streams driver and convert the profiles table
		// into a stream.
		$this->load->driver('Streams');

		if ( ! $this->streams->utilities->convert_table_to_stream('profiles', 'users', null, 'lang:user_profile_fields_label', 'Perfis para o módulo de usuários.', 'display_name', array('display_name')))
		{
			return false;
		}

		// Go ahead and convert our standard user fields:
		$columns = array(
			'first_name' => array(
				'field_name' => 'lang:user:first_name_label',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 50),
				'assign'	 => array('required' => true),
                                'is_locked' => true
			),
			'last_name' => array(
				'field_name' => 'lang:user:last_name_label',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 50),
				'assign'	 => array('required' => true),
                                'is_locked'         => true
			),
                        'avatar' => array(
				'field_name' => 'lang:user:avatar_label',
				'field_type' => 'image',
				'extra'		 => array(
					'folder' 	=> 1,
					'resize_width' 	=> 250,
					'resize_height'	=> 250,
					'keep_ratio'	=> 'yes',
                                        'allowed_types'	=> 'jpg|jpeg|gif|png'
				),
                                'assign'	 => array('required' => false),
                                'is_locked'         => true
			),
                        'lang' => array(
				'field_name' => 'lang:user:lang',
				'field_type' => 'metro_lang',
				'extra' => array('filter_theme' => 'yes'),
                                'is_locked'         => true
			),
			'company' => array(
				'field_name' => 'lang:profile_company',
				'field_slug' => 'company',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 100),
                                'is_locked' => false
			),
			'bio' => array(
				'field_name' => 'lang:profile_bio',
				'field_type' => 'textarea',
                                'is_locked'         => true
			),			
			'dob' => array(
				'field_name' => 'lang:profile_dob',
				'field_type' => 'datetime',
				'extra'		 => array(
					'use_time' 		=> 'no',
					'storage' 		=> 'unix',
					'input_type'	=> 'dropdown',
					'start_date'	=> '-100Y'
				),
                                'is_locked'         => true
			),
			'gender' => array(
				'field_name' => 'lang:profile_gender',
				'field_type' => 'choice',
				'extra'		 => array(
					'choice_type' => 'dropdown',
					'choice_data' => " : Não especificado\nm : Masculino\nf : Feminino"
				),
                                'is_locked'         => true
                                
			),
			'phone' => array(
				'field_name' => 'lang:profile_phone',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 20),
                                'is_locked' => false
			),
			'mobile' => array(
				'field_name' => 'lang:profile_mobile',
				'field_type' => 'text',
				'extra'		 => array('max_length' => 20),
                                'is_locked' => false
			),
                        'postcode' => array(
                            'field_name' => 'lang:profile_address_postcode',
                            'field_type' => 'text',
                            'extra'		 => array('max_length' => 20),
                            'is_locked' => false
                        ),

                        'address' => array(
                                'field_name' => 'lang:profile_address',
                                'field_type' => 'text',
                                'is_locked' => false
                        ),
                        'number' => array(
                                'field_name' => 'lang:profile_address_number',
                                'field_type' => 'text',
                                'is_locked' => false
                        ),
                        'complement' => array(
                                'field_name' => 'lang:profile_address_complement',
                                'field_type' => 'text',
                                'is_locked' => false
                        ),
			'address_line1' => array(
				'field_name' => 'lang:profile_address_line1',
				'field_type' => 'text',
                                'is_locked' => false
			),
			'address_line2' => array(
				'field_name' => 'lang:profile_address_line2',
				'field_type' => 'text',
                                'is_locked' => false
			),
			'address_line3' => array(
                            'field_name' => 'lang:profile_address_line3',
                            'field_type' => 'brazilian_state',
                            'extra'      => array( 'state_display' => 'full'),
                            'is_locked' => false
                        ),
                        'country' => array(
                            'field_name' => 'lang:profile_country',
                            'field_type' => 'country',
                            'extra'      => array( 'default_country' => 'BR'),
                            'assign'	 => array('required' => false),
                            'is_locked' => false
                        ),
			'website' => array(
				'field_name' => 'lang:profile_website',
				'field_type' => 'url',
                                'is_locked' => false
			),
		);

		// Run through each column and add the field
		// metadata to it.
		foreach ($columns as $field_slug => $column)
		{
			// We only want fields that actually exist in the
			// DB. The user could have deleted some of them.
			if ($this->db->field_exists($field_slug, 'profiles'))
			{
				$extra = array();
				$assign = array();

				if (isset($column['extra']))
				{
					$extra = $column['extra'];
				}

				if (isset($column['assign']))
				{
					$assign = $column['assign'];
				}

				$this->streams->utilities->convert_column_to_field('profiles', 'users', $column['field_name'], $field_slug, $column['field_type'], $extra, $assign, (isset($column['is_locked']) ? $column['is_locked'] : FALSE));

				unset($extra);
				unset($assign);
			}
		}

		// Install the settings
		$settings = array(
			array(
				'slug' => 'auto_username',
				'title' => 'Auto Username',
				'description' => 'Create the username automatically, meaning users can skip making one on registration.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 964,
			),
			array(
				'slug' => 'enable_profiles',
				'title' => 'Enable profiles',
				'description' => 'Allow users to add and edit profiles.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 963,
			),
			array(
				'slug' => 'require_lastname',
				'title' => 'Require last names?',
				'description' => 'For some situations, a last name may not be required. Do you want to force users to enter one or not?',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Required|0=Optional',
				'is_required' => 1,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 962,
			),
			array(
				'slug' => 'activation_email',
				'title' => 'Activation Email',
				'description' => 'Send out an e-mail with an activation link when a user signs up. Disable this so that admins must manually activate each account.',
				'type' => 'select',
				'default' => true,
				'value' => '',
				'options' => '0=activate_by_admin|1=activate_by_email|2=no_activation|3=activate_by_default',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 961,
			),
			array(
				'slug' => 'registered_email',
				'title' => 'User Registered Email',
				'description' => 'Send a notification email to the contact e-mail when someone registers.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 962,
			),
			array(
				'slug' => 'enable_registration',
				'title' => 'Enable user registration',
				'description' => 'Allow users to register in your site.',
				'type' => 'radio',
				'default' => true,
				'value' => '',
				'options' => '1=Enabled|0=Disabled',
				'is_required' => 0,
				'is_gui' => 1,
				'module' => 'users',
				'order' => 961,
			),
			array(
                                'slug' => 'profile_visibility',
                                'title' => 'Profile Visibility',
                                'description' => 'Specify who can view user profiles on the public site',
                                'type' => 'select',
                                'default' => 'public',
                                'value' => '',
                                'options' => 'public=profile_public|owner=profile_owner|hidden=profile_hidden|member=profile_member',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => 'users',
                                'order' => 960,
                        ),
                        array(
                                'slug' => 'enable_recaptcha',
                                'title' => 'Enable reCAPTCHA on user registration?',
                                'description' => 'Specify this if you want to use reCAPTCHA on user registration. reCAPTCHA details on General Tab are needed.',
                                'type' => 'radio',
                                'default' => 0,
                                'value' => '',
                                'options' => '1=Enabled|0=Disabled',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => 'users',
                                'order' => 959,
                        ),
                        array(
                                'slug' => 'enable_maskedinputplugin_admin',
                                'title' => 'Enable jquery masked input plugin on control panel?',
                                'description' => 'Enable jquery masked input plugin in user profile fields on control panel?',
                                'type' => 'radio',
                                'default' => false,
                                'value' => '',
                                'options' => '1=Enabled|0=Disabled',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => 'users',
                                'order' => 958,
                         ),
                         array(
                                'slug' => 'enable_maskedinputplugin_user',
                                'title' => 'Enable masked input plugin on user profiles and register?',
                                'description' => 'Enable masked input plugin in user profile and register on website?',
                                'type' => 'radio',
                                'default' => false,
                                'value' => '',
                                'options' => '1=Enabled|0=Disabled',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => 'users',
                                'order' => 957,
                         ),
                        array(
                                'slug' => 'users_maskedinputplugin_code',
                                'title' => 'Codes of the Masked Input Plugin',
                                'description' => 'Specify the jquery masked input plugin code. You can found more informations on <a href="http://digitalbush.com/projects/masked-input-plugin/" target="_blank">Masked Input Plugin\'s documentation</a>.',
                                'type' => 'textarea',
                                'default' => '',
                                'value' => "jQuery(function($){\r\n     $(\"#phone\").mask(\"(99) 9999-9999\");\r\n     $(\"#mobile\").mask(\"(99) 9999-9999\");\r\n     $(\"#postcode\").mask(\"99999-999\");\r\n});",
                                'options' => '',
                                'is_required' => 0,
                                'is_gui' => 1,
                                'module' => 'users',
                                'order' => 956,
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