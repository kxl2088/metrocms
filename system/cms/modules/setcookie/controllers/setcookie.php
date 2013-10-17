<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Setcookie Controller
 *
 * @author 		Fabricio Pereira Rabelo
 * @copyright           Copyright (c) 2013, Fabricio Pereira Rabelo
 * @link		http://fabriciorabelo.com
 * @package		MetroCMS\Apps\Modules\Setcookie\Controllers
 */

class Setcookie extends Public_Controller {
    
    private $request;
    
    public function __construct() 
        {
        parent::__construct();        
        $this->load->helper('cookie');        
        $this->error_message = 'Invalid request';
 
        // Only AJAX gets through!
	if ( !$this->input->is_ajax_request()) die($this->error_message);        
        $this->request = $this->input->post() ? $this->input->post() : $this->input->get();        
        header("Content-Type: application/json; charset=utf-8");
    }

    public function index() {        
        
        $userdata = $this->input->cookie('default_setcookie') ? unserialize($this->input->cookie('default_setcookie')) : array();        
        echo (json_encode((!$userdata ? array('error' => TRUE) : array()) + ($userdata ? $userdata : array())));
    }

    public function set_userdata() {
        
        $dataset = array();
        $userdata = $this->input->cookie('default_setcookie') ? unserialize($this->input->cookie('default_setcookie')) : array();
        
        if(is_array($this->request))
        {
            foreach ($this->request as $key => $value)
            {
                $dataset[$key] = $value;                
            }
        }
        
        $newdata =  array('error' => FALSE) + $dataset + $userdata;  
        setcookie('default_setcookie', serialize($newdata), time()+(60*60*24*365), '/');                        
        echo (json_encode(array('error' => FALSE) + $dataset + $userdata));
    }

}
