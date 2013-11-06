<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * MetroStreams IDE Editor Field Type
 *
 * @package		MetroCMS\Core\Modules\Streams Core\Field Types
 * @author		Fabricio Rabelo
 * @copyright		Copyright (c) 2013 - Fabricio Rabelo
 * @link		http://fabriciorabelo.com/
 */
class Field_ace_editor
{
	public $field_type_slug			= 'ace_editor';
	
	public $db_col_type			= 'longtext';

	public $custom_parameters 		= array('editor_type', 'allow_tags');
	
	public $version				= '1.0.0';

	public $author				= array('name'=>'Fabricio Rabelo', 'url'=>'http://fabriciorabelo.com');
	

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		$options['name'] 	= $data['form_slug'];
		$options['id']		= $data['form_slug'];
		$options['value']	= $data['value'];
		
		// Set editor type
		if (isset($data['custom']['editor_type']))
		{
			$options['class']	= $data['custom']['editor_type'];
		}
					
		return form_textarea($options, htmlentities($options['value']));
	}

	// --------------------------------------------------------------------------

	/**
	 * Pre Output
	 *
	 * No MetroCMS tags in text input fields.
	 *
	 * @return string
	 */
	public function pre_output($input)
	{
		$input = str_replace('&#123;&#123; url:site &#125;&#125;', site_url().'/', $input);

		$parse_tags = ( ! isset($params['allow_tags'])) ? 'n' : $params['allow_tags'];

		// If this isn't the admin and we want to allow tags,
		// let it through. Otherwise we will escape them.
		if ( ! defined('ADMIN_THEME') and $parse_tags == 'y')
		{
			return $this->CI->parser->parse_string($input, array(), true);
		}
		else
		{
			$this->CI->load->helper('text');
			return escape_tags($input);
		}	
	}
	
        // --------------------------------------------------------------------------
        
        /**
	 * Pre-Save content
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	string
	 */
	public function pre_save($input)
	{		
		return html_entity_decode($input);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Editor Type Param
	 *
	 * Choose the type of editor.
	 */
	public function param_editor_type($value = null)
	{
		$types = array(			
			'html_editor' => lang('streams:ace_editor.html'),
			'css_editor' => lang('streams:ace_editor.css'),
			'js_editor' => lang('streams:ace_editor.js'),
			'java_editor' => lang('streams:ace_editor.java'),	
			'jsp_editor' => lang('streams:ace_editor.jsp'),
			'markdown_editor' => lang('streams:ace_editor.markdown'),
			'php_editor' => lang('streams:ace_editor.php'),
			'sql_editor' => lang('streams:ace_editor.sql'),
			'xml_editor' => lang('streams:ace_editor.xml'),
		);
	
		return form_dropdown('editor_type', $types, $value);
	}	

	// --------------------------------------------------------------------------
	
	/**
	 * Allow tags param.
	 *
	 * Should tags go through or be converted to output?
	 */
	public function param_allow_tags($value = null)
	{
		$options = array(
			'y'	=> lang('global:yes'),
			'n'	=> lang('global:no'),			
		);
	
		// Defaults to No
		$value = ($value) ? $value : 'y';

		return form_dropdown('allow_tags', $options, $value);
	}
}