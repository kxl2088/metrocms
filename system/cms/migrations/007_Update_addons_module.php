<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_addons_module extends CI_Migration {

	public function up()
	{        
                $fields = array(
                        'extra' => array(
                                'type' => "TEXT",
                                'null' => TRUE,
                         ), 
                );
                $this->dbforge->add_column('modules', $fields);
                
                if(!defined('CURRENT_LANGUAGE')) define ('CURRENT_LANGUAGE', 'br');
                
                $this->load->helper('date');
                $this->load->library('settings/settings');
                $this->load->model('addons/module_m');
                                
                $this->module_m->import_unknown();                
                return true;
	}

	public function down()
	{                
		return true;
	}
}