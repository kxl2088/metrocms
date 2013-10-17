<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Blacklist module
 *
 * @author 		Blazej Adamczyk
 * @website		http://sein.com.pl
 * @package             PyroCMS
 * @subpackage          Blacklist Module
 */
class Blacklist_m extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->_table = 'blacklist';
    }

    //create a new item
    public function create($input) {
        $to_insert = array(
            'ip' => $input['ip'],
            'reason' => $input['reason'],
        );

        return $this->db->insert($this->_table, $to_insert);
    }

}
