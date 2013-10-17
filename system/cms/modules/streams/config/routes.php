<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Admin
$route['streams/admin/fields(/:any)?']		= 'admin_fields$1';
$route['streams/admin/entries(/:any)?']		= 'admin_entries$1';
$route['streams/admin/api(/:any)?']		= 'admin_api$1';

// Public
$route['streams(?!(/admin))(/:any)?']           = 'streams_api/index$1';