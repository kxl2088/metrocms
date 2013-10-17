<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Blacklist Events Class
 * 
 * @package         PyroCMS
 * @subpackage      Blacklist Module
 * @category        events
 * @author          Blazej Adamczyk
 * @website        http://sein.com.pl
 */
class Events_Blacklist {

    protected $ci;

    public function __construct() {
        $this->ci = & get_instance();

        //register the public_controller event
        Events::register('public_controller', array($this, 'run'));
    }

    public function run() {
        $this->ci->load->model('blacklist/blacklist_m');
        $this->ci->lang->load('blacklist/blacklist');
        $user_ip = $this->ci->input->ip_address();

        $is_blacklisted = $this->ci->blacklist_m->get_by('ip', $user_ip);

        if ($is_blacklisted) {
            log_message('error', $user_ip . '[' . $is_blacklisted->reason . '] was trying to access site');
            $data = array('ip' => $user_ip, 'reason' => $is_blacklisted->reason);
            $this->ci->output->set_status_header(403);
            $this->ci->template
                    ->set_layout(FALSE)
                    ->title(lang('blacklist:forbidden_title'))
                    ->build('blacklist/forbidden', $data);
            exit;
        }
    }

}

/* End of file events.php */