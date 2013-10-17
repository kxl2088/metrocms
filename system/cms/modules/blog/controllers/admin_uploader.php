<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_uploader extends Admin_Controller {

    public function __construct() {
        
        parent::__construct();
        
        $this->load->library('files/files');
        $this->load->model(array('files/file_m', 'blog/blog_galleries_m'));
        $this->lang->load('users/ion_auth');
        
        if( !is_logged_in() )
        {
            show_error(utf8_decode(lang('login_unsuccessful')));
            exit();
        }
    }

    public function index() {

        echo form_open_multipart('admin/blog/uploader/upload/1');        
        echo form_hidden('folder', 3);
        echo form_upload('userfile');
        echo form_submit('', 'Upload');
        echo form_close();
        //show_404();
        
    }

    public function upload($id = 0) {

        $data = new stdClass();
        $folder = $this->blog_galleries_m->get_folder();;
        
        $request = (object) Files::upload($folder, FALSE, 'userfile');
        
        if($request->status)
        {                
            $data = (object) $request->data;
            if(file_path($data->id) && $id)
            {
                $this->blog_galleries_m->insert(array(
                    'blog_id' => $id,
                    'file_id' => $data->id,
                    'sort' => 0
                ));
            } 
        }
        
        $this->output->set_header('Content-Type: application/json');        
        echo json_encode($request);
        
    }
    
    public function delete($id = 0) {
        
        $id = $id ? $id : $this->input->post('id');
        
        $this->blog_galleries_m->count_by(array('file_id' => $id)) 
                                                    ? $this->blog_galleries_m->delete_by(array('file_id' => $id)) 
                                                    : '';
         
        $delete_image = Files::delete_file($id);   
                    
        $this->output->set_header('Content-Type: application/json');
            
        if ($delete_image['status'] == TRUE) {
            
            $data = array('process' => 'success');
            $data += $delete_image;
            echo json_encode($data);      
            
        }
        else
        {
            
            $data = array('process' => 'error');
            $data += $delete_image;
            echo json_encode($data);  
            
        }         
        
    }
}