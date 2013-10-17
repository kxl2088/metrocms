<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The admin class is basically the main controller for the backend.
 *
 * @author      MetroCMS Dev Team
 * @copyright   Copyright (c) 2013
 * @package	 	MetroCMS\Core\Controllers
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();
                $this->load->helper('admin_theme');
		$this->load->helper('users/user');
	}

	/**
	 * Show the control panel
	 */
	public function index()
	{
		$this->template
			->enable_parser(true)
			->title(lang('global:dashboard'));

		if (is_dir('./installer'))
		{
			$this->template
				->set('messages', array('notice' => '<button id="remove_installer_directory" class="btn btn-inverse skip">'.lang('cp:delete_installer').'</button> '.lang('cp:delete_installer_message')));
		} 
                
                // Create shortcut order
                $session_shortcuts = $this->session->userdata('metrocms_shortcuts');     

                $shortcuts = array(
                    'metrocms_site_stats' => 1,
                    'metrocms_recent_comments' => 2,
                    'metrocms_analytics_graph' => 3,
                    'metrocms_news_feed' => 4
                );

                $options = admin_theme_options();
                $user = current_logged_in();
                
                $theme_options = new stdClass();
                
                foreach ($options as $option)
                {
                    $theme_options->{$option['slug']} = $option['value'] ? $option['value'] : $option['default'];
                }
                
                // Create session if not exist
                if ( !$session_shortcuts )
                {
                    $shortcuts_data = array();
                    
                    if($this->db->table_exists('user_shortcuts') && $this->db->where(array('user_id' => $user->id))->count_all_results('user_shortcuts') > 0 )
                    {
                        $db_shortcuts = $this->db->where(array('user_id' => $user->id))
                                              ->order_by('sort', 'asc')
                                              ->get('user_shortcuts')
                                              ->result();

                        foreach ($db_shortcuts as $sc)
                        {       
                            $shortcuts_data['metrocms_shortcuts'][$sc->sort] = $sc->slug;
                        }
                    }
                    else
                    {
                        // Create table if not exists
                        if( !$this->db->table_exists('user_shortcuts') )
                        {
                            $user_shortcuts_fields = array(
                                    'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
                                    'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false),
                                    'user_id' => array('type' => 'INT', 'constraint' => 11, 'null' => false),
                                    'sort' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
                            );  
                            $this->dbforge->add_field($user_shortcuts_fields);
                            $this->dbforge->add_key('id', TRUE);
                            $this->dbforge->create_table('user_shortcuts');
                        }
                        
                        foreach ($shortcuts as $short_key => $short_value)
                        {               
                                $extra = array(
                                        'slug' => $short_key,
                                        'user_id' => $user->id,
                                        'sort' => $short_value
                                );
                                $this->db->insert('user_shortcuts', $extra);
                                $shortcuts_data['metrocms_shortcuts'][$short_value] = $short_key;                             
                        }
                    }
                    $this->session->set_userdata($shortcuts_data);
                    redirect(current_url());
                }
                
                $session_shortcuts = $this->session->userdata('metrocms_shortcuts');    
                
                // Add metrocms_analytics_graph if not exist and if it's activated and configuration setted
                if ( $session_shortcuts || (!isset($session_shortcuts['metrocms_analytics_graph']) && ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->metrocms_analytics_graph == 'yes')))
                {
                    $data_reverse = array();
                    foreach ($session_shortcuts as $key => $value)
                    {
                        $data_reverse[$value] = $key;
                    }    

                    if(!array_key_exists('metrocms_analytics_graph', $data_reverse))
                    {
                            $shortcuts_data = array();
                            foreach ($shortcuts as $short_key => $short_value)
                            {
                                $shortcuts_data['metrocms_shortcuts'][$short_value] = $short_key;
                            }
                            $this->session->set_userdata($shortcuts_data);
                            redirect(current_url());
                    }
                }
                
                $data = new stdClass();
                
                // Site Status
                $data->total_files = total_files();
                $data->total_pages = total_pages();
                $data->total_users = total_users();
                $data->total_comments = total_comments();
                
		$this->template
                        ->set('session_shortcuts', $session_shortcuts)
                        ->append_js(array(
                            'jquery/jquery.flot.js', 
                            'jquery/jquery.flot.selection.js', 
                            'jquery/jquery.flot.pie.js', 
                            'jquery/jquery.flot.stack.js',
                            'jquery/jquery.flot.time.js',
                            'jquery/jquery.flot.tooltip.js',
                            'jquery/jquery.flot.resize.js',
                            'jquery/excanvas.js'
                            ))
			->build('admin/dashboard', $data);
	}

	/**
	 * Log in
	 */
	public function login()
	{
		// Set the validation rules
		$this->validation_rules = array(
			array(
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'required|callback__check_login'
			),
			array(
				'field' => 'password',
				'label' => lang('global:password'),
				'rules' => 'required'
			)
		);

		// Call validation and set rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->validation_rules);

		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run() or $this->ion_auth->logged_in())
		{
			// if they were trying to go someplace besides the 
			// dashboard we'll have stored it in the session
			$redirect = $this->session->userdata('admin_redirect');
			$this->session->unset_userdata('admin_redirect');

			redirect($redirect ? $redirect : 'admin');
		}

		$this->template
			->set_layout(false)
			->build('admin/login');
	}

	/**
	 * Logout
	 */
	public function logout()
	{
		$this->load->language('users/user');
		$this->ion_auth->logout();
		$this->session->set_flashdata('success', lang('user:logged_out'));
		redirect('admin/login');
	}

	/**
	 * Callback From: login()
	 *
	 * @param string $email The Email address to validate
	 *
	 * @return bool
	 */
	public function _check_login($email)
	{
		if ($this->ion_auth->login($email, $this->input->post('password'), (bool)$this->input->post('remember')))
		{
			Events::trigger('post_admin_login');
			
			return true;
		}

		Events::trigger('login_failed', $email);
		error_log('Login failed for user '.$email);

		$this->form_validation->set_message('_check_login', $this->ion_auth->errors());
		return false;
	}

	/**
	 * Display the help string from a module's
	 * details.php file in a modal window
	 *
	 * @param	string	$slug	The module to fetch help for
	 *
	 * @return	void
	 */
	public function help($slug)
	{
		$this->template
			->set_layout(FALSE)
			->set('help', ($this->module_m->help($slug) != 1 ? $this->module_m->help($slug) : ''))
			->build('admin/partials/help');
	}

	public function remove_installer_directory()
	{
		if ( ! $this->input->is_ajax_request())
		{
			die('Nope, sorry');
		}

		header('Content-Type: application/json');

		if (is_dir('./installer'))
		{
			$this->load->helper('file');
			// if the contents of "installer" delete successfully then finish off the installer dir
			if (delete_files('./installer', true) and count(scandir('./installer')) == 2)
			{
				rmdir('./installer');
				// This is the end, tell Sally I loved her.
				die(json_encode(array('status' => 'success', 'message' => lang('cp:delete_installer_successfully_message'))));
			}
		}

		die(json_encode(array('status' => 'error', 'message' => lang('cp:delete_installer_manually_message'))));
	}
        
        public function update_shortcuts_order()
	{
		header('Content-Type: application/json');  
                
		$shortcuts = explode(',', $this->input->post('order'));
                $shortcuts_data = array();
                                
                $i = 1;    
		foreach ($shortcuts as $shortcut)
		{
                    $shortcuts_data['metrocms_shortcuts'][$i] = $shortcut;
                    
                    $this->session->set_userdata($shortcuts_data);
                    
                    ++$i;
		}
                
                die(json_encode(array('status' => 'warning', 'message' => lang('cp:update_shortcuts_order_success_message'))));                                
	}
        
        public function update_user_shortcuts($order)
	{
		header('Content-Type: application/json');  
                
                // Get post data
		$shortcuts = explode(',', ($order ? $order : $this->input->post('order')));
                $user = current_logged_in();
                                
                // Update order
                $i = 1;
		foreach ($shortcuts as $shortcut)
		{
                    $extra = array(
                            'slug' => $shortcut,
                            'user_id' => $user->id,
                            'sort' => $i
                    );
                    
                    if( $this->db->where(array('slug' => $shortcut, 'user_id' => $user->id))->count_all_results('user_shortcuts') > 0 )
                    {
                        if($this->db->update('user_shortcuts', $extra, array('user_id' => $user->id, 'slug' => $shortcut)))
                        {
                            $result = array('status' => 'success', 'message' => lang('cp:update_user_shortcuts_success_message'));
                        }
                        else
                        {
                            die(json_encode(array('status' => 'error', 'message' => lang('cp:update_user_shortcuts_error_message'))));
                        }
                    }
                    else
                    {
                        if($this->db->insert('user_shortcuts', $extra))
                        {
                            $result = array('status' => 'success', 'message' => lang('cp:update_user_shortcuts_success_message'));
                        }
                        else
                        {
                            die(json_encode(array('status' => 'error', 'message' => lang('cp:update_user_shortcuts_error_message'))));
                        }
                    }
                    $i++;
		}
                
                die(json_encode($result));                
                
	}
        
        public function php_info()
	{            
		$this->template
                        ->set_layout(FALSE)
			->build('admin/partials/phpinfo');
	}
        
        public function info()
	{            
		$this->template
                        ->set_layout(FALSE)
			->build('admin/partials/info');
	}
        
        public function profile()
	{            
                $module_details = array(
                    'description' => lang('global:profile_description'),
                    'slug' => 'profile',
                    'name' => lang('global:my_profile')
                );    
                   
                $this->config->load('language');
                $lang = $this->config->item('supported_languages');
                
		$profile_data = (array)$this->current_user;

		$this->lang->load('streams_core/metrostreams');
		$this->lang->load('users/user');

		$profile = array();

		$profile[] = array(
			'value' => $profile_data['email'],
			'name'  => lang('global:email'),
			'slug'  => 'email'
		);

		$profile[] = array(
			'value' => $profile_data['username'],
			'name'  => lang('user:username'),
			'slug'  => 'username'
		);

		$profile[] = array(
			'value' => $profile_data['group_description'],
			'name'  => lang('user:group_label'),
			'slug'  => 'group_name'
		);

		$profile[] = array(
			'value' => format_date($profile_data['last_login'], Settings::get('date_format')),
			'name'  => lang('profile_last_login_label'),
			'slug'  => 'last_login'
		);

		$profile[] = array(
			'value' => format_date( $profile_data['created_on'], Settings::get('date_format')),
			'name'  => lang('profile_registred_on_label'),
			'slug'  => 'registered_on'
		);

		// Display name and updated on
		$profile[] = array(
			'value' => $profile_data['display_name'],
			'name'  => lang('profile_display_name'),
			'slug'  => 'display_name'
		);
		$profile[] = array(
			'value' => format_date($profile_data['updated_on'], Settings::get('date_format')),
			'name'  => lang('profile_updated_on'),
			'slug'  => 'updated_on'
		);

                
		foreach ($this->ion_auth_model->user_stream_fields as $key => $field)
		{
			if (!isset($profile_data[$key]))
			{
				continue;
			}

			$name = (lang($field->field_name)) ? $this->lang->line($field->field_name) : $field->field_name;

                        if($field->field_slug == 'dob'):
                            $profile[] = array(
                                    'value' => format_date($profile_data[$key], 'd/m/Y'),
                                    'name'  => $this->fields->translate_label($name),
                                    'slug'  => $field->field_slug
                            );
                        elseif($field->field_slug == 'gender'):
                            $profile[] = array(
                                    'value' => $profile_data[$key] == 'm' ? lang('profile_male_label') : lang('profile_female_label'),
                                    'name'  => $this->fields->translate_label($name),
                                    'slug'  => $field->field_slug
                            );
                        elseif($field->field_slug == 'website'):
                            $profile[] = array(
                                    'value' => anchor($profile_data[$key], $profile_data[$key], 'target="_blank"'),
                                    'name'  => $this->fields->translate_label($name),
                                    'slug'  => $field->field_slug
                            );
                        elseif($field->field_slug == 'lang'):
                            $profile[] = array(
                                    'value' => $lang[$profile_data[$key]]['name'],
                                    'name'  => $this->fields->translate_label($name),
                                    'slug'  => $field->field_slug
                            );
                        else:
                            $profile[] = array(
                                    'value' => $profile_data[$key],
                                    'name'  => $this->fields->translate_label($name),
                                    'slug'  => $field->field_slug
                            );
                        endif;

			unset($name);
		}

		$this->template
                        ->set('module_details', $module_details)
                        ->set('_user', $this->current_user)
                        ->set('profile_fields', $profile)
                        ->set('method', $this->method)
                        ->title(lang('global:my_profile'), $this->current_user->display_name)
			->build('admin/partials/profile'); 
        }
        
        
        
        public function profile_edit(){
            
            $id = $this->current_user->id;
            
            $module_details = array(
                    'description' => lang('global:profile_description'),
                    'slug' => 'profile',
                    'name' => lang('profile_edit')
            ); 

            $this->validation_rules = array(
		'email' => array(
			'field' => 'email',
			'label' => 'lang:global:email',
			'rules' => 'required|max_length[60]|valid_email'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'lang:global:password',
			'rules' => 'min_length[6]|max_length[20]'
		),
		'username' => array(
			'field' => 'username',
			'label' => 'lang:user:username',
			'rules' => 'required|alpha_dot_dash|min_length[3]|max_length[20]'
		),
		array(
			'field' => 'group_id',
			'label' => 'lang:user:group_label',
			'rules' => 'required'
		),
		array(
			'field' => 'active',
			'label' => 'lang:user:active_label',
			'rules' => ''
		),
		array(
			'field' => 'display_name',
			'label' => 'lang:profile_display_name',
			'rules' => 'required'
		)
            );
            
            // Get the user's data
            if ( ! ($member = $this->ion_auth->get_user($id)))
            {
                    $this->session->set_flashdata('error', lang('user:edit_user_not_found_error'));
                    redirect('admin');
            }

            // Check to see if we are changing usernames
            if ($member->username != $this->input->post('username'))
            {
                    $this->validation_rules['username']['rules'] .= '|callback__username_check';
            }

            // Check to see if we are changing emails
            if ($member->email != $this->input->post('email'))
            {
                    $this->validation_rules['email']['rules'] .= '|callback__email_check';
            }

            // Get the profile fields validation array from streams
            $this->load->driver('Streams');
            $profile_validation = $this->streams->streams->validation_array('profiles', 'users', 'edit', array(), $id);

            // Set the validation rules
            $this->form_validation->set_rules(array_merge($this->validation_rules, $profile_validation));

            // Get user profile data. This will be passed to our
            // streams insert_entry data in the model.
            $assignments = $this->streams->streams->get_assignments('profiles', 'users');
            $profile_data = array();

            foreach ($assignments as $assign)
            {
                    if (isset($_POST[$assign->field_slug]))
                    {
                            $profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
                    }
                    elseif (isset($member->{$assign->field_slug}))
                    {
                            $profile_data[$assign->field_slug] = $member->{$assign->field_slug};
                    }
            }

            if ($this->form_validation->run() === true)
            {
                    if (METRO_DEMO)
                    {
                            $this->session->set_flashdata('notice', lang('global:demo_restrictions'));
                            redirect('admin');
                    }

                    // Get the POST data
                    $update_data['email'] = $this->input->post('email');
                    $update_data['active'] = $this->input->post('active');
                    $update_data['username'] = $this->input->post('username');
                    // allow them to update their one group but keep users with user editing privileges from escalating their accounts to admin
                    $update_data['group_id'] = ($this->current_user->group !== 'admin' and $this->input->post('group_id') == 1) ? $member->group_id : $this->input->post('group_id');

                    if ($update_data['active'] === '2')
                    {
                            $this->ion_auth->activation_email($id);
                            unset($update_data['active']);
                    }
                    else
                    {
                            $update_data['active'] = (bool) $update_data['active'];
                    }

                    $profile_data = array();

                    // Grab the profile data
                    foreach ($assignments as $assign)
                    {
                            $profile_data[$assign->field_slug] = $this->input->post($assign->field_slug);
                    }

                    // Some stream fields need $_POST as well.
                    $profile_data = array_merge($profile_data, $_POST);

                    // We need to manually do display_name
                    $profile_data['display_name'] = $this->input->post('display_name');

                    // Password provided, hash it for storage
                    if ($this->input->post('password'))
                    {
                            $update_data['password'] = $this->input->post('password');
                    }

                    if ($this->ion_auth->update_user($id, $update_data, $profile_data))
                    {
                            // Fire an event. A user has been updated. 
                            Events::trigger('user_updated', $id);

                            $this->session->set_flashdata('success', $this->ion_auth->messages());
                    }
                    else
                    {
                            $this->session->set_flashdata('error', $this->ion_auth->errors());
                    }

                    // Redirect back to the form or main page
                    $this->input->post('btnAction') === 'save_exit' ? redirect('admin/profile') : redirect('admin/profile/edit');
            }
            else
            {
                    // Dirty hack that fixes the issue of having to re-add all data upon an error
                    if ($_POST)
                    {
                            $member = (object) $_POST;
                    }
            }

            // Loop through each validation rule
            foreach ($this->validation_rules as $rule)
            {
                    if ($this->input->post($rule['field']) !== null)
                    {
                            $member->{$rule['field']} = set_value($rule['field']);
                    }
            }

            // We need the profile ID to pass to get_stream_fields.
            // This theoretically could be different from the actual user id.
            if ($id)
            {
                    $profile_id = $this->db->limit(1)->select('id')->where('user_id', $id)->get('profiles')->row()->id;
            }
            else
            {
                    $profile_id = null;
            }

            $stream_fields = $this->streams_m->get_stream_fields($this->streams_m->get_stream_id_from_slug('profiles', 'users'));

            $profile = $this->db->limit(1)->where('user_id', $id)->get('profiles')->row();

            // Set Values
            $values = $this->fields->set_values($stream_fields, $profile, 'edit');

            // Run stream field events
            $this->fields->run_field_events($stream_fields, array(), $values);
                
            $this->template
                        ->set('module_details', $module_details)
                        ->set('display_name', $member->display_name)
                        ->set('method', $this->method)
                        ->set('_user', $this->current_user)
                        ->append_metadata("\n\t<script type=\"text/javascript\" src=\"". Asset::get_filepath_js('jquery/jquery.maskedinput.min.js', true) ."\"></script>\n\t<script type=\"text/javascript\" src=\"". site_url('users/jquery/jquery.masks.config.js') ."\"></script>")
                        ->set('profile_fields', $this->streams->fields->get_stream_fields('profiles', 'users', $values, $profile_id))
			->set('member', $member)
                        ->title(lang('profile_edit'), $this->current_user->display_name)
			->build('admin/partials/profile'); 
        }
        
        public function change_password(){
            
            $this->load->model('user_m');
            $this->load->library('form_validation');
            
            $validation = array(      
                array(
                     'field'   => 'old_password', 
                     'label'   => 'lang:user:old_password_label', 
                     'rules'   => 'required|trim|min_length[6]|max_length[20]'
                  ),
                array(
                     'field'   => 'password', 
                     'label'   => 'lang:user:new_password_label', 
                     'rules'   => 'required|trim|min_length[6]|max_length[20]'
                  ),
                array(
                     'field'   => 'confirm_password', 
                     'label'   => 'lang:user:password_new_confirm_label', 
                     'rules'   => 'required|trim|min_length[6]|max_length[20]|matches[password]'
                  )
            );

            $this->form_validation->set_rules($validation);
            
            if ($this->form_validation->run())
            {
                    if ($this->input->post('password'))
                    {
                            $update_data['password'] = $this->input->post('password');
                    }
                    
                    if ($this->ion_auth->change_password($this->current_user->email, $this->input->post('old_password'), $this->input->post('password')))
                    {
                            $this->session->set_flashdata('success', $this->ion_auth->messages());
                            redirect('admin/profile');
                    }
                    else
                    {
                            $this->session->set_flashdata('error', $this->ion_auth->errors());
                            redirect(current_url());
                    }  
            }
                
            $module_details = array(
                    'description' => lang('global:profile_description'),
                    'slug' => 'profile',
                    'name' => lang('user:password_section')
                ); 
            
            $this->template
                        ->set('module_details', $module_details)
                        ->set('method', $this->method)
                        ->set('_user', $this->current_user)
                        ->title(lang('user:password_section'), $this->current_user->display_name)
			->build('admin/partials/profile'); 
        }
        
}