<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Update_files_module extends CI_Migration {

	public function up()
	{        
                
		$this->load->config('files/files');
        $this->load->library('settings/settings');
        $this->load->helper('files/files');
		$this->load->helper('file');	
		$this->load->model('files/file_m');
		
		//Default files path
		$path = $this->config->item('files:path');
		//Get files
		$files = $this->db->get('files')->result();
		//Mode files
		if($files)
		{
		    foreach ($files as $file)
		    {
				$newpath = $path . date('Y/m', $file->date_added) . '/';
				
				if( !is_dir($newpath) )
				{
				    mkdir ($newpath, 0777, true);
				    write_file ($newpath .'index.html', '');
				}
				
				rename($path . $file->filename, $newpath . $file->filename);
		    }
		}
		
        return true;
	}

	public function down()
	{                
		return true;
	}
}