<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_api extends Admin_Controller {

    protected $section = 'api';
    protected $validation_rules = array(
            array(
                    'field' => 'application',
                    'label' => 'lang:streams:application_label',
                    'rules' => 'trim|required|max_length[100]|is_unique[data_stream_api.application]'
            ),
            array(
                    'field' => 'token',
                    'label' => 'lang:streams:token_label',
                    'rules' => 'trim|required|max_length[44]|is_unique[data_stream_api.token]'
            ),
            array(
                    'field' => 'contact',
                    'label' => 'lang:streams:contact_label',
                    'rules' => 'trim|max_length[100]'
            ),
            array(
                    'field' => 'company',
                    'label' => 'lang:streams:company_label',
                    'rules' => 'trim|max_length[100]'
            ),
            array(
                    'field' => 'nip',
                    'label' => 'lang:streams:nip_label',
                    'rules' => 'trim|max_length[50]'
            ),
            array(
                    'field' => 'phone',
                    'label' => 'lang:streams:phone_label',
                    'rules' => 'trim|max_length[50]'
            ),
            array(
                    'field' => 'email',
                    'label' => 'lang:streams:email_label',
                    'rules' => 'trim|max_length[50]'
            ),            
            array(
                    'field' => 'permissions',
                    'label' => 'lang:streams:permissions_label',
                    'rules' => 'trim'
            ),
            array(
                    'field' => 'expires_on',
                    'label' => 'lang:streams:expires_on_label',
                    'rules' => 'trim|required'
            ),
            array(
                    'field' => 'enabled',
                    'label' => 'lang:streams:enabled_label',
                    'rules' => 'trim|required'
            ),
        
    );
    
    public function __construct()
    {
            parent::__construct();

            $this->load->driver('Streams');
            $this->load->config('streams/streams');        
            $this->load->helper('streams/streams');
            $this->load->model(array('streams/api_m', 'streams/stream_m'));
            $this->lang->load('streams');

            // Set our namespace
            $this->namespace = $this->config->item('streams:core_namespace');

            // Count all entries
            $this->ordering_count = $this->api_m->count_all();
    }

    public function index()
    {
            //set the base/default where clause
            $base_where = array('enabled' => 'all');

            //add post values to base_where if f_module is posted		
            $this->input->post('f_enabled') ? $base_where['enabled'] = $this->input->post('f_enabled') : FALSE;

            $this->input->post('f_keywords') ? $base_where['keywords'] = $this->input->post('f_keywords') : FALSE;

            // Create pagination links
            $total_rows = $this->api_m->count_by($base_where);
            $pagination = create_pagination('admin/streams/api/index', $total_rows);

            // Using this data, get the relevant results
            $apis = $this->api_m->limit($pagination['limit'], $pagination['offset'])
                                ->get_many_by($base_where);

            //do we need to unset the layout because the request is ajax?
            $this->input->is_ajax_request() and $this->template->set_layout(false);

            $this->template->title($this->module_details['name'])
                           ->append_js('admin/filter.js')
                           ->append_css('module::api.css')
                           ->set_partial('filters', 'admin/api/partials/filters')
                           ->set('pagination', $pagination)
                           ->set('apis', $apis);

            $this->input->is_ajax_request()
                            ? $this->template->build('admin/api/tables/streams')
                            : $this->template->build('admin/api/index');
    }
    
    public function add()
    {
            $data = new stdClass();
                 
            $permissions_list = $this->stream_m->build_permissions();
   
            $data->permissions_list = $permissions_list;
            
            $this->form_validation->set_rules($this->validation_rules);
            
            $input = $this->input->post();
            
            // Got validation?
            if ($this->form_validation->run())
            {
                    $extra = array(
                        'created' => date('Y-m-d H:i:s'),
                        'expires_on' => $input['expires_on'],
                        'updated' => NULL,
                        'created_by' => $this->current_user->id,
                        'ordering_count' => $this->ordering_count,
                        'application' => $input['application'],
                        'contact' => $input['contact'],
                        'company' => $input['company'],
                        'nip' => $input['nip'],
                        'phone' => $input['phone'],
                        'email' => $input['email'],
                        'token' => $input['token'],
                        'permissions' => serialize($input['permissions']),
                        'enabled' => $input['enabled'],
                    );
                
                    if ($id = $this->api_m->insert($extra))
                    {
                            $this->session->set_flashdata('success', lang('redirects:add_success'));
                            $input['btnAction'] == 'save_exit' ? redirect('admin/streams/api') : redirect('admin/streams/api/edit/' . $id);
                    }
                    else
                    {
                            $this->session->set_flashdata('success', lang('redirects:add_success'));
                            redirect(current_url());
                    }
            }
            
            // Loop through each validation rule
            foreach($this->validation_rules as $rule)
            {
                    $data->{$rule['field']} = $this->input->post($rule['field']);
            }
            
            $data->token = $data->token ? $data->token : token(44);
            $data->permissions = $data->permissions ? $data->permissions : $input['permissions'];
            
            $this->template->title($this->module_details['name'], lang('streams:create_api'))
                           ->append_js('module::api.js')
                           ->append_css('module::api.css')
                           ->build('admin/api/form', $data);
    }
    
    public function edit( $id = 0)
    {            
            $data = $this->api_m->get($id);
            $data OR redirect('admin/streams/api');
            
            $permissions_list = $this->stream_m->build_permissions();
   
            $input = $this->input->post();
            
            $this->validation_rules[0] = array(
                            'field' => 'application',
                            'label' => 'lang:streams:application_label',
                            'rules' => 'trim|required|max_length[100]' . ($input['application'] != $data->application ? '|is_unique[data_stream_api.application]' : '')
            );
            $this->validation_rules[1] = array(
                            'field' => 'token',
                            'label' => 'lang:streams:token_label',
                            'rules' => 'trim|required|max_length[44]' . ($input['token'] != $data->token ? '|is_unique[data_stream_api.token]' : '')
            );
            
            $data->permissions_list = $permissions_list;
            $data->permissions = unserialize( ($input['permissions'] ? $input['permissions'] : $data->permissions) );
            
            $this->form_validation->set_rules($this->validation_rules);
            
            // Got validation?
            if ($this->form_validation->run())
            {
                    $extra = array(
                        'updated' => date('Y-m-d H:i:s'),
                        'expires_on' => $input['expires_on'],
                        'application' => $input['application'],
                        'contact' => $input['contact'],
                        'company' => $input['company'],
                        'nip' => $input['nip'],
                        'phone' => $input['phone'],
                        'email' => $input['email'],
                        'permissions' => serialize($input['permissions']),
                        'enabled' => $input['enabled'],
                    );
                
                    if ($this->api_m->update($id, $extra))
                    {
                            $this->session->set_flashdata('success', lang('redirects:add_success'));
                            $input['btnAction'] == 'save_exit' ? redirect('admin/streams/api') : redirect(current_url());
                    }
                    else
                    {
                            $this->session->set_flashdata('success', lang('redirects:add_success'));
                            redirect(current_url());
                    }
            }

            $this->template->title($this->module_details['name'], sprintf(lang('streams:edit_api'), $data->application))
                           ->append_js('module::api.js')
                           ->append_css('module::api.css')
                           ->build('admin/api/form', $data);
    }
    
    public function delete( $id = 0 )
    {  
            $id_array = ( ! empty($id)) ? array($id) : $this->input->post('action_to');

            // Delete multiple
            if( ! empty($id_array))
            {
                    $deleted = 0;
                    $to_delete = 0;
                    foreach ($id_array as $id)
                    {
                            if ($this->api_m->delete($id))
                            {
                                    $deleted++;
                            }
                            else
                            {
                                    $this->session->set_flashdata('error', sprintf(lang('streams:mass_delete_error'), $id));
                            }
                            $to_delete++;
                    }

                    if ($deleted > 0)
                    {
                            $this->session->set_flashdata('success', sprintf(lang('streams:mass_delete_success'), $deleted, $to_delete));
                    }

            }
            else
            {
                    $this->session->set_flashdata('error', lang('streams:no_select_error'));
            }		

            redirect('admin/streams/api');
    }
}