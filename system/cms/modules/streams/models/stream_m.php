<?php defined('BASEPATH') or exit('No direct script access allowed');

class Stream_m extends MY_Model {
    
    protected $_table = 'data_streams';
    
    public function __construct() {
        
        $this->lang->load('streams/streams');
        parent::__construct();
    }

    public function build_permissions() {
                
        $results = $this->db->select($this->_table . '.*')
                            ->where_not_in('stream_namespace', array('pages'))
                            ->get($this->_table)
                            ->result();
        
        if( $results ) {
            foreach ($results as &$keys) {
                
                $keys->permissions = (object)array(
                    'insert' => lang('streams:permission_insert'),
                    'update' => lang('streams:permission_update'),
                    'delete' => lang('streams:permission_delete'),
                    'select' => lang('streams:permission_select')
                );
            }
        }
        
        return $results;
    }
}