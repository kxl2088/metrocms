<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Robots module for MetroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	MetroCMS
 * @subpackage 	Robots Module
 */
class Robots extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('robots_m');
		$this->load->language('robots');
                $this->data = new stdClass();
	}
	
	public function index()
	{
		$this->data->robots_txt = $this->robots_m->get_robots_txt();
		$this->output->set_content_type('text/plain');
		$this->load->view('robots', $this->data);
	}
}
/* End of file robots.php */