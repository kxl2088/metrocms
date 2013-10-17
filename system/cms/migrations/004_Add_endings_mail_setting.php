<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_endings_mail_setting extends CI_Migration {

	public function up()
	{
                $this->db->set(array(
                                'slug' => 'mail_line_endings',
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
                    )); 
                $this->db->insert('settings'); 
                
                return true;
	}

	public function down()
	{                
		return true;
	}
}
