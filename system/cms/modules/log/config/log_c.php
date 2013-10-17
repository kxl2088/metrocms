<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['maximum_log_size']     = 1000000;              // the maximum a log file may be to be read and stored
$config['maximum_batch_size']   = 990000;               // the maximum batch size to send at once to the database, in bytes
$config['checkbox_disabled_at'] = 325;                  // disable the ability to filter for error types at this number (or above), improves stability
$config['log_directory']        = 'system/cms/logs/';   // shouldn't be changed really
$config['sync_all_limit']       = 0;                    // 0 is inifinity, so all of them. If a limit is set, it will start from the latest added file till the limit is reached