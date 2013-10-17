<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Locking_some_stream_fields extends CI_Migration {

	public function up()
	{
                $this->db->update('data_fields', array('is_locked' => 'yes'), array('field_slug' => 'image', 'field_namespace' => 'blogs'));
                $this->db->update('data_fields', array('is_locked' => 'yes'), array('field_slug' => 'intro', 'field_namespace' => 'blogs'));
                $this->db->update('data_fields', array('is_locked' => 'yes'), array('field_slug' => 'body', 'field_namespace' => 'pages'));
                
                return true;
	}

	public function down()
	{                
		return true;
	}
}