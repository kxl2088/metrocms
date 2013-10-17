<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log_m extends MY_Model
{
    protected $_table = 'log';

    function get_many_by($params = array())
    {
        if (isset($params['where_in'])) {
            $this->db->where_in($params['where_in'][0], $params['where_in'][1]);
        }
        $this->db->order_by('date', 'DESC');
        return $this->get_all();
    }

    function get_all_names()
    {
        $this->db->select('name');
        return $this->get_all();
    }
}