<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * This is a Robots module for MetroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	MetroCMS
 * @subpackage 	Robots Module
 */
class Module_Robots extends Module {

	public $version = '1.0.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Robots',
                                'br' => 'Robôs'
			),
			'description' => array(
				'en' => 'This module manages the robots.txt file used by search engines.',
                                'br' => 'Este módulo gerencia o arquivo robots.txt usado pelos mecanismos de busca.'

			),
			'frontend'	=> TRUE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'data',
			'author'	=> 'Fabricio P Rabelo',
					
			'sections' => array(
			)
		);
	}

	public function install()
	{
		$txt = "";
		$txt .= "# www.robotstxt.org/\n";
		$txt .= "# www.google.com/support/webmasters/bin/answer.py?hl=en&answer=156449\n";
		$txt .= "User-agent: *\n";
		$txt .= "Allow: /\n";
                $txt .= "Disallow: /admin/\n";
		$txt .= "Sitemap: " . str_replace('/installer', '', base_url('sitemap.xml'));
                
		$this->dbforge->drop_table('robots');
                
                $tables = array(
                    'robots' => array(
                            'robots_id' => array('type' => 'INT', 'constraint' => 11, 'null' => false, 'auto_increment' => true, 'primary' => true),
                            'sites_id' => array('type' => 'INT', 'constraint' => 5, 'primary' => true),
                            'site_ref' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
                            'txt' => array('type' => 'TEXT', 'null' => true)
                    ),
                );
                
                $site_id = $this->db->query("SELECT `id` FROM `core_sites` WHERE ref = '" . $this->site_ref . "' LIMIT 1")->result();
                
                $data = array(
                    'sites_id' => $site_id[0]->id,
                    'site_ref' => $this->site_ref,
                    'txt' => $txt,
                );
                                
                if($this->install_tables($tables) AND
                            $this->db->insert('robots', $data)){
                    
                    return TRUE;
                    
                }else{
                    
                    return FALSE;
                    
                }
	}

	public function uninstall()
	{
		return TRUE;
	}


	public function upgrade($old_version)
	{
		return TRUE;
		
	}

}
/* End of file details.php */