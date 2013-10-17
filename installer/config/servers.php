<?php
/*
|--------------------------------------------------------------------------
| Supported servers
|--------------------------------------------------------------------------
|
| An array that contains a list of servers supported by MetroCMS.
|
*/

$config['supported_servers'] = array(

	'apache_wo' => array(
		'name' => 'Apache (sem mod_rewrite)',
		'rewrite_support' => FALSE
	),
	
	'apache_w' => array(
		'name' => 'Apache (com mod_rewrite)',
		'rewrite_support' => TRUE
	),
	'nginx_wo' => array(
		'name' => 'nginx (sem HttpRewriteModule‎)',
		'rewrite_support' => FALSE
	),
	
	'nginx_w' => array(
		'name' => 'nginx (com HttpRewriteModule‎)',
		'rewrite_support' => TRUE
	),
        'iis_wo' => array(
		'name' => 'Microsoft IIS (sem URL Rewrite)',
		'rewrite_support' => FALSE
	),
	
	'iis_w' => array(
		'name' => 'Microsoft IIS (com URL Rewrite)',
		'rewrite_support' => TRUE
	),
	
	'abyss' => array(
		'name' => 'Abyss Web Server X1/X2',
		'rewrite_support' => FALSE
	),
	
	'cherokee' => array(
		'name' => 'Cherokee Web Server 0.99.x',
		'rewrite_support' => FALSE
	),
	
	'uniform' => array(
		'name' => 'Uniform Server 4.x/5.x',
		'rewrite_support' => FALSE
	),
	
	'zend' => array(
		'name' => 'Zend Server',
		'rewrite_support' => TRUE
	),
	
	'other'	=> array(
		'name' => 'Outro',
		'rewrite_support' => FALSE
	)
);