<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_modules extends CI_Migration {

	public function up()
	{        
                
                if(!defined('CURRENT_LANGUAGE')) define ('CURRENT_LANGUAGE', 'br');
                
                $this->load->helper('date');
                $this->load->library('settings/settings');
                $this->load->model('addons/module_m');
                                
                $this->module_m->import_unknown(); 
                $this->module_m->import_unknown(); 
                $this->module_m->import_unknown();                
                return true;
	}

	public function down()
	{                
		return true;
	}
}