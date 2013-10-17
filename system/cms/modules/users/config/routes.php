<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Admin Routes
$route['users/admin/fields(/:any)?']		= 'admin_fields$1';

// User Routes
$route['(users)/jquery/jquery.masks.config.js']            = 'users/masked_settings';