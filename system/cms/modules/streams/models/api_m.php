<?php defined('BASEPATH') or exit('No direct script access allowed');

class Api_m extends MY_Model {
    
    protected $_table = 'data_stream_api';

    public function count_by($params = array()) {
        
        if((isset($params['enabled']) && !empty($params['enabled'])) && $params['enabled'] == 'all'){
            
            $this->db->where_in('enabled', array('yes','no'));
            unset($params['enabled']);
        }
        
        if(isset($params['keywords']) && !empty($params['keywords'])) {
            
            $this->db->like('application', trim($params['keywords']))
                     ->like('contact', trim($params['keywords']));
        }        
        //unset data
        unset($params['keywords']);
        
        return parent::count_by($params);
    }
    
    public function get_many_by($params = array()) {
        
        if((isset($params['enabled']) && !empty($params['enabled'])) && $params['enabled'] == 'all'){
            
            $this->db->where_in('enabled', array('yes','no'));
            unset($params['enabled']);
        }
        
        if(isset($params['keywords']) && !empty($params['keywords'])) {
            
            $this->db->like('application', trim($params['keywords']))
                     ->or_like('contact', trim($params['keywords']));
        }
        
        //unset data
        unset($params['keywords']);
        
        return parent::get_many_by($params);
    }    
}