<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
 * MY_Form_validation
 * 
 * Extending the Form Validation class to add extra rules and model validation
 *
 * @package 	MetroCMS\Core\Libraries
 * @author      MetroCMS Dev Team
 * @copyright   Copyright (c) 2013
 */
class MY_Form_validation extends CI_Form_validation
{
	/**
	 * The model class to call with callbacks
	 */
	private $_model;

	public function __construct($rules = array())
	{
		parent::__construct($rules);
		$this->CI->load->language('extra_validation');
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha-numeric with underscores dots and dashes
	 *
	 * @param	string
	 * @return	bool
	 */
	public function alpha_dot_dash($str)
	{
		return (bool) preg_match("/^([-a-z0-9_\-\.])+$/i", $str);
	}

	// --------------------------------------------------------------------

	/**
	 * Sneaky function to get field data from
	 * the form validation library
	 *
	 * @param	string
	 * @return	bool
	 */
	public function field_data($field)
	{
		return (isset($this->_field_data[$field])) ? $this->_field_data[$field] : null;
	}
	// --------------------------------------------------------------------

	/**
	 * Formats an UTF-8 string and removes potential harmful characters
	 *
	 * @param	string
	 * @return	string
	 * @todo	Find decent regex to check utf-8 strings for harmful characters
	 */
	public function utf8($str)
	{
		// If they don't have mbstring enabled (suckers) then we'll have to do with what we got
		if ( ! function_exists('mb_convert_encoding'))
		{
			return $str;
		}

		$str = mb_convert_encoding($str, 'UTF-8', 'UTF-8');

		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}

	// --------------------------------------------------------------------

	/**
	 * Sets the model to be used for validation callbacks. It's set dynamically in MY_Model
	 *
	 * @param	string	The model class name
	 * @return	void
	 */
	public function set_model($model)
	{
		if ($model)
		{
			$this->_model = strtolower($model);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Format an error in the set error delimiters
	 *
	 * @param	string
	 * @return	void
	 */
	public function format_error($error)
	{
		return $this->_error_prefix.$error.$this->_error_suffix;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid URL
	 *
	 * @param	string
	 * @return	void
	 */
	public function valid_url($str)
	{
		if (filter_var($str, FILTER_VALIDATE_URL))
		{
			return true;
		}
		else
		{
			$this->set_message('valid_url', $this->CI->lang->line('valid_url'));
			return false;
		}
	}

       
	// --------------------------------------------------------------------

	/**
	 * Executes the Validation routines
	 *
	 * Modified to work with HMVC -- Phil Sturgeon
	 * Modified to work with callbacks in the calling model -- Jerel Unruh
	 *
	 * @param	array
	 * @param	array
	 * @param	mixed
	 * @param	integer
	 * @return	mixed
	 */
	protected function _execute($row, $rules, $postdata = null, $cycles = 0)
	{
		// If the $_POST data is an array we will run a recursive call
		if (is_array($postdata))
		{
			foreach ($postdata as $key => $val)
			{
				$this->_execute($row, $rules, $val, $cycles);
				$cycles++;
			}

			return;
		}

		// --------------------------------------------------------------------

		// If the field is blank, but NOT required, no further tests are necessary
		$callback = false;
		if ( ! in_array('required', $rules) and is_null($postdata))
		{
			// Before we bail out, does the rule contain a callback?
			if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match))
			{
				$callback = true;
				$rules = (array('1' => $match[1]));
			}
			else
			{
				return;
			}
		}

		// --------------------------------------------------------------------

		// Isset Test. Typically this rule will only apply to checkboxes.
		if (is_null($postdata) and $callback == false)
		{
			if (in_array('isset', $rules, true) or in_array('required', $rules))
			{
				// Set the message type
				$type = (in_array('required', $rules)) ? 'required' : 'isset';

				if ( ! isset($this->_error_messages[$type]))
				{
					if (false === ($line = $this->CI->lang->line($type)))
					{
						$line = 'The field was not set';
					}
				}
				else
				{
					$line = $this->_error_messages[$type];
				}

				// Build the error message
				$message = sprintf($line, $this->_translate_fieldname($row['label']));

				// Save the error message
				$this->_field_data[$row['field']]['error'] = $message;

				if ( ! isset($this->_error_array[$row['field']]))
				{
					$this->_error_array[$row['field']] = $message;
				}
			}

			return;
		}

		// --------------------------------------------------------------------

		// Cycle through each rule and run it
		foreach ($rules as $rule)
		{
			$_in_array = false;

			// We set the $postdata variable with the current data in our master array so that
			// each cycle of the loop is dealing with the processed data from the last cycle
			if ($row['is_array'] == true and is_array($this->_field_data[$row['field']]['postdata']))
			{
				// We shouldn't need this safety, but just in case there isn't an array index
				// associated with this cycle we'll bail out
				if ( ! isset($this->_field_data[$row['field']]['postdata'][$cycles]))
				{
					continue;
				}

				$postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
				$_in_array = true;
			}
			else
			{
				$postdata = $this->_field_data[$row['field']]['postdata'];
			}

			// --------------------------------------------------------------------

			// Is the rule a callback?
			$callback = false;
			if (substr($rule, 0, 9) == 'callback_')
			{
				$rule = substr($rule, 9);
				$callback = true;
			}

			// Strip the parameter (if exists) from the rule
			// Rules can contain a parameter: max_length[5]
			$param = false;
			if (preg_match("/(.*?)\[(.*)\]/", $rule, $match))
			{
				$rule	= $match[1];
				$param	= $match[2];
			}

			// Call the function that corresponds to the rule
			if ($callback === true)
			{
				// first check in the controller scope
				if (method_exists(CI::$APP->controller, $rule))
				{
					$result = call_user_func(array(new CI::$APP->controller, $rule), $postdata, $param);
				}
				// it wasn't in the controller. Did MY_Model specify a valid model in use?
				elseif ($this->_model)
				{
					// moment of truth. Does the callback itself exist?
					if (method_exists(CI::$APP->{$this->_model}, $rule))
					{
						$result = call_user_func(array(CI::$APP->{$this->_model}, $rule), $postdata, $param);
					}
					else
					{
						throw new Exception('Undefined callback '.$rule.' Not found in '.$this->_model);
					}
				}
				else
				{
					throw new Exception('Undefined callback "'.$rule.'" in '.CI::$APP->controller);
				}

				// Re-assign the result to the master data array
				if ($_in_array == true)
				{
					$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}
				else
				{
					$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}

				// If the field isn't required and we just processed a callback we'll move on...
				if ( ! in_array('required', $rules, true) and $result !== false)
				{
					continue;
				}
			}
			else
			{
				if ( ! method_exists($this, $rule))
				{
					// If our own wrapper function doesn't exist we see if a native PHP function does.
					// Users can use any native PHP function call that has one param.
					if (function_exists($rule))
					{
						$result = $rule($postdata);

						if ($_in_array == true)
						{
							$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
						}
						else
						{
							$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
						}
					}
					else
					{
						log_message('debug', "Unable to find validation rule: ".$rule);
					}

					continue;
				}

				$result = $this->$rule($postdata, $param);

				if ($_in_array == true)
				{
					$this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
				}
				else
				{
					$this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
				}
			}

			// Did the rule test negatively?  If so, grab the error.
			if ($result === false)
			{
				if ( ! isset($this->_error_messages[$rule]))
				{
					if (false === ($line = $this->CI->lang->line($rule)))
					{
						$line = 'Unable to access an error message corresponding to your field name.'.$rule;
					}
				}
				else
				{
					$line = $this->_error_messages[$rule];
				}

				// Is the parameter we are inserting into the error message the name
				// of another field?  If so we need to grab its "field label"
				if (isset($this->_field_data[$param]) and isset($this->_field_data[$param]['label']))
				{
					$param = $this->_translate_fieldname($this->_field_data[$param]['label']);
				}

				// Build the error message
				$message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

				// Save the error message
				$this->_field_data[$row['field']]['error'] = $message;

				if ( ! isset($this->_error_array[$row['field']]))
				{
					$this->_error_array[$row['field']] = $message;
				}

				return;
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Check Recaptcha callback
	 *
	 * Used for streams but can be used in other
	 * recaptcha situations.
	 *
	 * @param	string
	 * @return	bool
	 */
	public function check_recaptcha($val)
	{
		if ($this->CI->recaptcha->check_answer(
						$this->CI->input->ip_address(),
						$this->CI->input->post('recaptcha_challenge_field'),
						$val))
		{
	    	return true;
		}
		else
		{
			$this->set_message(
						'check_captcha',
						$this->CI->lang->line('recaptcha_incorrect_response'));
			
			return false;
	    }
	}
        
        // --------------------------------------------------------------------------

	/**
	 * Recaptcha
	 *
	 */
        
        public function recaptcha($val)
        {            
            $resp = new stdClass();
            $resp = recaptcha_check_answer(Settings::get('recaptcha_private_key'),
                                           $this->CI->input->ip_address(),
                                                $this->CI->input->post("recaptcha_challenge_field"),
                                                    $val);

            if ( !$resp->is_valid ) 
            {
               $this->set_message('recaptcha', $this->CI->lang->line('recaptcha_incorrect_response'));
                return false; 
            }
            else
            {
                return true; 
            }
            
        }  
        
	// --------------------------------------------------------------------------

	/**
	 * Valid postcode
	 *
	 */
        function valid_postcode($str) 
        {
            // remove blank spaces
            $postcode = trim($str);
            
            if( eregi("^[0-9]{8}$", $postcode) ) // check if the format is 00000000
            {            
                return true; 
            }
            else if( eregi("^[0-9]{5}-[0-9]{3}$", $postcode) ) // else check if the format is 00000-000
            {
                return true;
            }
            else
            {
                $this->set_message('valid_postcode', $this->CI->lang->line('valid_postcode'));
                return false; 
            }
        }
        
        // --------------------------------------------------------------------------

	/**
	 * Valid phone number
	 *
	 */
        function valid_phone_number($str) 
        {            
            if( eregi("^\+[0-9]{2}[0-9]{9}$", $str) || eregi("^\+[0-9]{2}[0-9]{10}$", $str) || eregi("^\+[0-9]{2}[0-9]{11}$", $str) ) // check if the format is +55159999999 +551599999999 or +5515999999999
            {            
                return true; 
            }
            else if( eregi("^[0-9]{3}-[0-9]{4}$", $str) || eregi("^[0-9]{4}-[0-9]{4}$", $str) || eregi("^[0-9]{5}-[0-9]{4}$", $str) ) // else check if the format is 000-0000 or 0000-0000 or 00000-0000
            {
                return true;
            }
            else if( eregi("^\+[0-9]{2} \([0-9]{2}\) [0-9]{3}-[0-9]{4}$", $str) || eregi("^\+[0-9]{2} \([0-9]{2}\) [0-9]{4}-[0-9]{4}$", $str) || eregi("^\+[0-9]{2} \([0-9]{2}\) [0-9]{5}-[0-9]{4}$", $str) ) // else check if the format is +55 (17) 000-0000 or +55 (17) 0000-0000 or +55 (17) 00000-0000
            {
                return true;
            }
            else if( eregi("^\([0-9]{2}\) [0-9]{3}-[0-9]{4}$", $str) || eregi("^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$", $str) || eregi("^\([0-9]{2}\) [0-9]{5}-[0-9]{4}$", $str) ) // else check if the format is (17) 000-0000 or (17) 0000-0000 or (17) 00000-0000
            {
                return true;
            }
            else if( eregi("^[0-9]{2} [0-9]{3}-[0-9]{4}$", $str) || eregi("^[0-9]{2} [0-9]{4}-[0-9]{4}$", $str) || eregi("^[0-9]{2} [0-9]{5}-[0-9]{4}$", $str) ) // else check if the format is 17 000-0000 or 17 0000-0000 or 17 00000-0000
            {
                return true;
            }
            else if( eregi("^[0-9]{2} [0-9]{3} [0-9]{4}$", $str) || eregi("^[0-9]{2} [0-9]{4} [0-9]{4}$", $str) || eregi("^[0-9]{2} [0-9]{5} [0-9]{4}$", $str) ) // else check if the format is 17 000 0000 or 17 0000 0000 or 17 00000 0000
            {
                return true;
            }
            else if( eregi("^[0-9]{9}$", $str) || eregi("^[0-9]{10}$", $str) || eregi("^[0-9]{11}$", $str) ) // else check if the format is 170000000 or 1700000000 or 17000000000
            {
                return true;
            }
            else if( eregi("^[0-9]{2} [0-9]{7}$", $str) || eregi("^[0-9]{2} [0-9]{8}$", $str) || eregi("^[0-9]{2} [0-9]{9}$", $str) ) // else check if the format is 17 000-0000 or 17 0000-0000 or 17 00000-0000
            {
                return true;
            }
            else if( eregi("^(\[0-9]{2}\) [0-9]{7}$", $str) || eregi("^(\[0-9]{2}\) [0-9]{8}$", $str) || eregi("^(\[0-9]{2}\) [0-9]{9}$", $str) ) // else check if the format is (17) 0000000 or (17) 00000000 or (17) 000000000
            {
                return true;
            }
            else if( eregi("^(\[0-9]{2}\) [0-9]{3}-[0-9]{4}$", $str) || eregi("^(\[0-9]{2}\) [0-9]{4} [0-9]{4}$", $str) || eregi("^(\[0-9]{2}\) [0-9]{5} [0-9]{4}$", $str) ) // else check if the format is (17) 000 0000 or (17) 0000 0000 or (17) 00000 0000
            {
                return true;
            }
            else
            {
                $this->set_message('valid_phone_number', $this->CI->lang->line('valid_phone_number'));
                return false; 
            }
        }
        
	// --------------------------------------------------------------------------

	/**
	 * Is unique
	 *
	 * Used by streams_core.
	 *
	 * @param	string
	 * @param	string
	 * @param	obj
	 * @return	bool
	 */
	public function streams_unique($string, $data)
	{
		// Split the data
		$items = explode(":", $data);
		
		$column 	= trim($items[0]);

		if ( ! isset($items[0]) or ! isset($items[1]))
		{
			return true;
		}

		$mode 		= $items[1];
		$stream_id	= $items[2];

		if ($mode == 'edit' and $this->CI->input->post('row_edit_id'))
		{
			$row_id = $this->CI->input->post('row_edit_id');
		}
		elseif ($mode == 'edit' and isset($items[3]) and is_numeric($items[3]))
		{
			$row_id = $items[3];
		}
		else
		{
			$row_id = null;
		}

		// Get the stream
		$stream = $this->CI->streams_m->get_stream($stream_id);
			
		$obj = $this->CI->db
			->select('id')
			->where(trim($column), trim($string))
			->get($stream->stream_prefix.$stream->stream_slug);
		
		// If this is new, we just need to make sure the
		// value doesn't exist already.
		if ($mode == 'new')
		{
			if ($obj->num_rows() == 0)
			{
				return true;
			}
			else
			{
				$this->set_message('streams_unique', lang('streams:field_unique'));
				return false;
			}
		}
		else
		{
			if ( ! $row_id) return true;

			// Is this new value the same as what we had before?
			// If it is, then we're cool
			$existing = $this->CI->db
				->select($column)
				->limit(1)
				->where('id', $row_id)
				->get($stream->stream_prefix.$stream->stream_slug)
				->row();

			// Is this the same value? If so, we are
			// all in the clear. They did not change the value
			// so we don't need to worry.
			if (strtolower($existing->$column) == strtolower($string))
			{
				return true;
			}

			// Now we know there was a change. We treat it as new now.
			// and do the regular old routine.
			if ($obj->num_rows() == 0)
			{
				return true;
			}
			else
			{
				// Looks like the end of the road.
				$this->set_message('streams_unique', lang('streams:field_unique'));
				return false;
			}
		}

		return true;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Streams Field Type Validation Callback
	 *
	 * Used by streams as conduit to call custom
	 * callback functions.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function streams_field_validation($value, $data)
	{
		// Data is in the form of field_id|mode
		// Mode is edit or new.
		$pieces = explode(':', $data);

		if (count($pieces) != 2) return false;

		$field_id 	= $pieces[0];
		$mode 		= $pieces[1];

		// Lets get the field
		$field = $this->CI->fields_m->get_field($field_id);

		// Check for the type
		if ( ! isset($this->CI->type->types->{$field->field_type}) or 
			 ! method_exists($this->CI->type->types->{$field->field_type}, 'validate'))
		{
			return false;
		}

		// Call the type. It will either return a string or true
		if (($result = $this->CI->type->types->{$field->field_type}->validate($value, $mode, $field)) === true)
		{
			return true;
		}
		else
		{
			$this->set_message('streams_field_validation', $result);
			return false;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * File is Required
	 *
	 * Checks various inputs needed for files
	 * to see if one is indeed added.
	 *
	 * Used by Streams.
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function streams_file_required($string, $field)
	{
		// Do we already have something? If we are editing the row,
		// the file may already be there. We know that if the ID is there,
		// it is hooked up with the MetroCMS file system.
		if ($this->CI->input->post($field) and $this->CI->input->post($field) != 'dummy')
		{
			return true;
		}
		
		// OK. Now we really need to make sure there is a file here.
		// The method of choice here is checking for a file name		
		if (isset($_FILES[$field.'_file']['name']) and $_FILES[$field.'_file']['name'] != '')
		{
			// Don't do anything.
		}			
		else
		{
			$this->set_message('streams_file_required', lang('streams:field_is_required'));
			return false;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Unique field slug
	 *
	 * Checks to see if the slug is unique based on the 
	 * circumstances
	 *
	 * Used by Streams.
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function streams_unique_field_slug($field_slug, $data)
	{
		// Get our mode and namespace
		$items = explode(':', $data);

		if (count($items) != 2)
		{
			// @todo: Do we need an error message here?
			return false;
		}

		// If the mode is not 'new', it is the current
		// field slug so that we can check to see if a field
		// Slug has changed - pretty tricky, eh?
		$mode 		= $items[0];

		// We check by namespace, because you can have 
		// fields with the same slug in multiple namespaces.
		$namespace 	= $items[1];

		$existing = $this->CI->db
						->where('field_namespace', $namespace)
						->where('field_slug', trim($field_slug))
						->from(FIELDS_TABLE)
						->count_all_results();
		
		if ($mode == 'new')
		{
			if ($existing > 0)
			{
				$this->set_message('streams_unique_field_slug', lang('streams:field_slug_not_unique'));
				return false;
			}	
		}
		else
		{
			// Mode should be the existing slug
			if ($field_slug != $mode)
			{
				// We're changing the slug?
				// Better make sure it doesn't exist.
				if ($existing != 0)
				{
					$this->set_message('streams_unique_field_slug', lang('streams:field_slug_not_unique'));
					return false;
				}			
			}
		}

		return true;		
	}

	// --------------------------------------------------------------------------

	/**
	 * Unique Stream Slug
	 *
	 * Checks to see if the stream is unique based on the 
	 * stream_slug
	 *
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function stream_unique($stream_slug, $mode)
	{
		$this->CI->db->select('id')->where('stream_slug', trim($stream_slug));
		$db_obj = $this->CI->db->get(STREAMS_TABLE);
		
		if ($mode == 'new')
		{
			if ($db_obj->num_rows() > 0)
			{
				$this->set_message('stream_unique', lang('streams:stream_slug_not_unique'));
				return false;	
			}
		}	
		else
		{
			// Mode should be the existing slug
			// We check the two to see if the slug is changing.
			// If it is changing we of course need to make sure
			// it is unique.
			if ($stream_slug != $mode)
			{
				if ($db_obj->num_rows() != 0)
				{
					$this->set_message('stream_unique', lang('streams:stream_slug_not_unique'));
					return false;
				}
			}
		}

		return true;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Streams Slug Safe
	 *
	 * 1. Sees if a word is safe for the DB. Used for
	 * stream_fields, etc. Basically, we are checking to see if
	 * a word is going to conflict with MySQL
	 *
	 * 2. Sees if a word is safe the Lex parser to
	 * be used as a variable. The same variable rules for
	 * PHP variables apply to Lex.
	 *
	 * @param 	string
	 * @return 	bool
	 */
	public function streams_slug_safe($string)
	{
		// See if word is MySQL Reserved Word
		if (in_array(strtoupper($string), $this->CI->config->item('streams:reserved')))
		{
			$this->set_message('streams_slug_safe', lang('streams:not_mysql_safe_word'));
			return false;
		}

		// See if there are no-no characters. We are basically validating
		// the string to make sure it can be used as a PHP/Lex variable.
		if ( ! preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $string))
		{
			$this->set_message('streams_slug_safe', lang('streams:not_mysql_safe_characters'));
			return false;
		}
		
		return true;
	}


	// --------------------------------------------------------------------------
	
	/**
	 * Streams Column Safe
	 *
	 * Determines if the slug is okay to be used as a column.
	 *
	 * @param 	string
	 * @param 	string
	 * @return 	bool
	 */
	public function streams_col_safe($string, $params)
	{
		// Find mode - new or edit
		$pieces = explode(':', $params);

		$mode 			= (isset($pieces[0])) ? $pieces[0] : null;
		$stream_table 	= (isset($pieces[1])) ? $pieces[1] : null;
		$existing 		= (isset($pieces[2])) ? $pieces[2] : null;

		if ( ! $stream_table) return null;

		if ($mode == 'new')
		{
			if ($this->CI->db->field_exists($string, $stream_table))
			{
				$this->set_message('streams_col_safe', lang('streams:field_slug_not_unique'));
				return false;
			}
		}
		elseif ($mode != 'new' and $existing)
		{
			// Edit mode.
			if ($existing != $string and 
					$this->CI->db->field_exists($string, $stream_table))
			{
				$this->set_message('streams_col_safe', lang('streams:field_slug_not_unique'));
				return false;
			}
		}
		
		return true;
	}
	// --------------------------------------------------------------------------

	/**
	 * Make sure a type is valid
	 *
	 * @param	string
	 * @return	bool
	 */	
	public function streams_type_valid($string)
	{
		if ($string == '-')
		{
			$this->set_message('streams_type_valid', lang('streams:type_not_valid'));
			return false;
		}	
		
		return true;
	}
	// --------------------------------------------------------------------------

	/**
	 * CPF Validation
	 *
	 */	
	public function valid_cpf($str)
	{
            $cpf         = preg_replace("/[^0-9]/", "", $str);
            $digitoUm     = 0;
            $digitoDois = 0;

            for($i = 0, $x = 10; $i <= 8; $i++, $x--)
            {
                $digitoUm += $cpf[$i] * $x;
            }
            
            for($i = 0, $x = 11; $i <= 9; $i++, $x--)
            {
                if(str_repeat($i, 11) == $cpf)
                {
                    $this->set_message('valid_cpf', lang('streams:brazilian_cpf.invalid'));
                    return false;
                }
                $digitoDois += $cpf[$i] * $x;
            }

            $calculoUm  = (($digitoUm%11) < 2) ? 0 : 11-($digitoUm%11);
            $calculoDois = (($digitoDois%11) < 2) ? 0 : 11-($digitoDois%11);
            if($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10])
            {
                $this->set_message('valid_cpf', lang('streams:brazilian_cpf.invalid'));
                return false;
            }
            
            return true;
	}
	// --------------------------------------------------------------------

	/**
	 * Valid CNPJ
	 *
	 * @param	string
	 * @return	void
	 */
	public function valid_cnpj($str)
	{
                $cnpj     = $str;
                //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
                $j=0;
                for($i=0; $i<(strlen($cnpj)); $i++)
                {
                        if(is_numeric($cnpj[$i]))
                                {
                                        $num[$j]=$cnpj[$i];
                                        $j++;
                                }
                }
        //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
        if(count($num)!=14)
                {
                        $this->set_message('valid_cnpj', lang('streams:brazilian_cnpj.invalid'));
                        $isCnpjValid=false;
                }
        //Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
        if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
                {
                        $this->set_message('valid_cnpj', lang('streams:brazilian_cnpj.invalid'));
                        $isCnpjValid=false;
                }
                //Etapa 4: Calcula e compara o primeiro dígito verificador.
                else
                {
                        $j=5;
                        for($i=0; $i<4; $i++)
                                {
                                        $multiplica[$i]=$num[$i]*$j;
                                        $j--;
                                }
                        $soma = array_sum($multiplica);
                        $j=9;
                        for($i=4; $i<12; $i++)
                                {
                                        $multiplica[$i]=$num[$i]*$j;
                                        $j--;
                                }
                        $soma = array_sum($multiplica);	
                        $resto = $soma%11;			
                        if($resto<2)
                                {
                                        $dg=0;
                                }
                        else
                                {
                                        $dg=11-$resto;
                                }
                        if($dg!=$num[12])
                                {
                                        $this->set_message('valid_cnpj', lang('streams:brazilian_cnpj.invalid'));
                                        $isCnpjValid=false;
                                } 
                }
                //Etapa 5: Calcula e compara o segundo dígito verificador.
                if(!isset($isCnpjValid))
                {
                        $j=6;
                        for($i=0; $i<5; $i++)
                                {
                                        $multiplica[$i]=$num[$i]*$j;
                                        $j--;
                                }
                        $soma = array_sum($multiplica);
                        $j=9;
                        for($i=5; $i<13; $i++)
                                {
                                        $multiplica[$i]=$num[$i]*$j;
                                        $j--;
                                }
                        $soma = array_sum($multiplica);	
                        $resto = $soma%11;			
                        if($resto<2)
                                {
                                        $dg=0;
                                }
                        else
                                {
                                        $dg=11-$resto;
                                }
                        if($dg!=$num[13])
                                {
                                        $this->set_message('valid_cnpj', lang('streams:brazilian_cnpj.invalid'));
                                        $isCnpjValid=false;
                                }
                        else
                                {
                                        $isCnpjValid=true;
                                }
                }

                return $isCnpjValid;	
                  
	}
}

/* End of file MY_Form_validation.php */
