<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a Robots module for MetroCMS
 *
 * @author 		Jacob Albert Jolman
 * @website		http://www.odin-ict.nl
 * @package 	MetroCMS
 * @subpackage 	Robots Module
 */
class Robots_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		$this->_table = 'default_robots';
	}
	
	public function get_robots_txt()
	{
		return $this->db->select('*')
                        ->where('site_ref', SITE_REF)
                        ->limit(1)
                        ->get($this->_table)
                        ->row();
	}
	
	public function update_robots_txt($input)
	{
		return $this->db->where('site_ref', SITE_REF)
                                ->update($this->_table, array('txt' => $input['txt']));
	}
}