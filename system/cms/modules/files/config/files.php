<?php /* Provision for the installer */ 
if ( ! defined('UPLOAD_PATH')) define('UPLOAD_PATH', null);

$config['files:path'] = UPLOAD_PATH.'files/';

$config['files:encrypt_filename'] = false;

$config['files:allowed_file_ext'] = array(
	'a'	=> array('mpga', 'mp2', 'mp3', 'ra', 'rv', 'wav'),
	'v'	=> array('mpeg', 'mpg', 'mpe', 'mp4', 'flv', 'qt', 'mov', 'avi', 'movie'),
	'd'	=> array('pdf', 'xls', 'ppt', 'pptx', 'txt', 'text', 'log', 'rtx', 'rtf', 'xml', 'xsl', 'doc', 'docx', 'xlsx', 'word', 'xl', 'csv', 'pages', 'numbers','ttf','otf','woff', 'sql', 'psd', 'xhtml', 'css', 'html', 'htm', 'shtml'),
	'i'	=> array('bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif'),
	'o'	=> array('gtar', 'swf', 'tar', 'zip', 'rar', 'gz', 'tgz', 'tgz', 'svg'),
);
