<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The Language Handler Library.
 * 
 * @author      MetroCMS Dev Team
 * @copyright   Copyright (c) 2013
 * @package 	MetroCMS\Core\Libraries 
 */
require APPPATH."libraries/MX/Lang.php";

/**
 * General Language library class for using in MetroCMS
 */
class MY_Lang extends MX_Lang
{

	/**
	 * Fetch a single line of text from the language array
	 *
	 * @param string $line the language line
	 * @return string
	 */
	public function line($line = '')
	{
		$translation = ($line == '' OR !isset($this->language[$line])) ? false : $this->language[$line];

		// Because killer robots like unicorns!
		if ($translation === false)
		{
			log_message('debug', 'Could not find the language line "'.$line.'"');
		}

		return $translation;
	}

}