<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * MetroStreams CPF Field Type
 *
 * @package		MetroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_brazilian_cpf
{
	public $field_type_slug			= 'brazilian_cpf';
	
	public $db_col_type				= 'varchar';

	public $extra_validation			= 'valid_cpf';

	public $version					= '1.1.0';

	public $author					= array('name'=>'Fabricio Rabelo', 'url'=>'http://fabriciorabelo.com');
	

	// --------------------------------------------------------------------------

	/**
	 * Process before outputting
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function pre_output($input)
	{
		
		$this->CI->load->helper('text');
		return escape_tags($input);
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		
		return form_input($options);
	}

}