<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * MetroStreams Text Field Type
 *
 * @package		MetroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_colorpicker
{
	public $field_type_slug			= 'colorpicker';
	
	public $db_col_type			= 'varchar';

	public $version				= '1.0.0';

	public $author				= array('name'=>'Parse19', 'url'=>'http://parse19.com');
	
	public $custom_parameters		= array('colorpicker_type', 'default_value');
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data)
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		
		$out = "";
		
		if( $data['custom']['colorpicker_type'] == 'colorpicker')
		{	    
		    $out .= '<div class="input-append color colorpicker" data-color="rgb(255, 146, 180)" data-color-format="rgb">';
		    $out .= form_input($options);
		    $out .= '<span class="add-on"><i style="background-color: rgb(255, 146, 180);"></i></span>';
		    $out .= '</div>';
		}
		else
		{
		    $options['class']	= $data['custom']['colorpicker_type'];
		    $out .= form_input($options);
		}
		
		return $out;
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 * 
	 * @return string
	 */
	public function pre_output($input)
	{
		return $input;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Param to Select the Color Format
	 *
	 * @access	public
	 * @param	[string - value]
	 * @return	string
	 */
	public function param_colorpicker_type($value = null)
	{
		return form_dropdown('colorpicker_type', array('colorpicker' => 'RGB', 'hexpicker' => 'HEX'), $value);
	}
}