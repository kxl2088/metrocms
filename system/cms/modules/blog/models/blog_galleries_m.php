<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author  MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Blog\Models
 */
class Blog_galleries_m extends MY_Model
{
	protected $_table = 'blog_galleries';
        
	public function __construct()
	{
		parent::__construct();

                $this->load->library('files/files');
		$this->lang->load('blog');
        }
        
        public function get_all() 
        {
            $this->db->order_by('sort', 'asc');
            return parent::get_all();
        }
        
        public function get_many_by($params = array())
        {
            $this->db->order_by('sort', 'asc');
            return parent::get_many_by($params);
        }
        
        public function update_order($primary_value, $data)
        {
            return $this->db->update($this->_table, $data, array('file_id' => $primary_value));
        }
        
        public function get_folder()
        {
            $this->db->where('slug', 'galerias-blog');
            $result = $this->db->get('file_folders');
            
            return $result->row()->id;
        }
        
        public function delete_many_by($params = array()) {
            
            if($params and array_key_exists('id', $params))
            {
                $images = $this->get_many_by(array('blog_id' => $params['id']));                
                if($images)
                {
                    foreach ($images as $image)
                    {
                        $delete_image = Files::delete_file($image->file_id);   
                        if ($delete_image['status'] == TRUE) {
                            $this->delete_by(array('file_id' => $image->file_id));
                        }
                    }
                    return TRUE;
                }
            }
            return FALSE;
        }

}