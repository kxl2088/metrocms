<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_column_blog_gallery extends CI_Migration {

	public function up()
	{
		if( !$this->db->field_exists('sort', 'blog_galleries') )
                {
                    $fields = array(
                        'sort' => array('type' => 'INT', 'constraint' => 11, 'null' => true)
                    );
                    if($this->dbforge->add_column('blog_galleries', $fields))
                    {
                        $this->db->update('blog_galleries', array('sort' => 0));
                    }
                }
                
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