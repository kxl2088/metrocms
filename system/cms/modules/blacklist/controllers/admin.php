<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Blacklist module
 *
 * @author 		Blazej Adamczyk
 * @website		http://sein.com.pl
 * @package             PyroCMS
 * @subpackage          Blacklist Module
 */

class Admin extends Admin_Controller {
    

    public function __construct() {
        parent::__construct();

        // Load all the required classes
        $this->load->model('blacklist_m');
        $this->load->library('form_validation');
        $this->lang->load('blacklist');
        $this->data = new stdClass();

        // Set the validation rules
        $this->item_validation_rules = array(
            array(
                'field' => 'ip',
                'label' => 'lang:blacklist:ip',
                'rules' => 'trim|max_length[15]|valid_ip|required'
            ),
            array(
                'field' => 'reason',
                'label' => 'lang:blacklist:reason',
                'rules' => 'trim|max_length[250]|required'
            ),
        );
    }

    /**
     * List all items
     */
    public function index() {
        $items = $this->blacklist_m->get_all();

        // Build the view with sample/views/admin/items.php
        $this->template->title($this->module_details['name'])
                ->build('admin/items', array('items' => $items));
    }

    public function create() {
        $this->form_validation->set_rules($this->item_validation_rules);

        // check if the form validation passed
        if ($this->form_validation->run()) {
            // See if the model can create the record
            if ($this->blacklist_m->create($this->input->post())) {
                // All good...
                $this->session->set_flashdata('success', lang('blacklist:success'));
                redirect('admin/blacklist');
            }
            // Something went wrong. Show them an error
            else {
                $this->session->set_flashdata('error', lang('blacklist:error'));
                redirect('admin/blacklist/create');
            }
        }

        foreach ($this->item_validation_rules AS $rule) {
            $this->data->{$rule['field']} = $this->input->post($rule['field']);
        }

        // Build the view using sample/views/admin/form.php
        $this->template->title($this->module_details['name'], lang('blacklist:create'))
                ->build('admin/form', $this->data);
    }

    public function edit($id = 0) {
        $this->data = $this->blacklist_m->get($id);

        // Set the validation rules from the array above
        $this->form_validation->set_rules($this->item_validation_rules);

        // check if the form validation passed
        if ($this->form_validation->run()) {
            unset($_POST['btnAction']);

            // See if the model can create the record
            if ($this->blacklist_m->update($id, $this->input->post())) {
                // All good...
                $this->session->set_flashdata('success', lang('blacklist:success'));
                redirect('admin/blacklist');
            }
            // Something went wrong. Show them an error
            else {
                $this->session->set_flashdata('error', lang('blacklist:error'));
                redirect('admin/blacklist/edit/'.$id);
            }
        }

        // Build the view using sample/views/admin/form.php
        $this->template->title($this->module_details['name'], lang('blacklist:edit'))
                ->build('admin/form', $this->data);
    }

    public function delete($id = 0) {
        // make sure the button was clicked and that there is an array of ids
        if (isset($_POST['btnAction']) AND is_array($_POST['action_to'])) {
            // pass the ids and let MY_Model delete the items
            $this->blacklist_m->delete_many($this->input->post('action_to'));
        } elseif (is_numeric($id)) {
            // they just clicked the link so we'll delete that one
            $this->blacklist_m->delete($id);
        }
        redirect('admin/blacklist');
    }

}
