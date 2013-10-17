<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Enable_blacklist_module extends CI_Migration {

	public function up()
	{
                if (!$this->db->table_exists('blacklist'))
                {
                    $fields = array(
                        'id' => array(
                            'type' => 'INT',
                            'constraint' => 11,
                            'auto_increment' => TRUE,
                        ),
                        'ip' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 15
                        ),
                        'reason' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 250,
                            'null' => TRUE,
                            'default' => NULL
                        )
                    );
                    $this->dbforge->add_field($fields);
                    $this->dbforge->add_key('id', TRUE);                
                    $this->dbforge->create_table('blacklist');
                }
                
                if(!defined('CURRENT_LANGUAGE')) define ('CURRENT_LANGUAGE', 'br');
                
                $this->load->helper('date');
                $this->load->library('settings/settings');
                $this->load->model('addons/module_m');
                                
                $this->module_m->import_unknown();
                $this->module_m->enable('blacklist');
                
                return true;
	}

	public function down()
	{                
		return true;
	}
}