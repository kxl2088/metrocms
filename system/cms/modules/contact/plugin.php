<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Contact Plugin
 *
 * Build and send contact forms
 * 
 * @author		MetroCMS Dev Team
 * @package		MetroCMS\Core\Modules\Contact\Plugins
 */
class Plugin_Contact extends Plugin 
{

	public $version = '1.0.2';
	public $name = array(
		'en' => 'Contact',
	);
	public $description = array(
		'en' => 'Displays a contact form for site visitors.',
	);

	/**
	 * Returns a PluginDoc array that MetroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'form' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays a contact form for your modules or pages. If you want to use additional html\'s attributes in your form fields, use tow dots "::" as delimiter. Ex: name="text|required|class::input|placeholder::Your name here|id::name"'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'your_field|button',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
                                        'action' => array(
						'type' => 'text',
						'flags' => 'A different url of default. This can be used to place a contact form in the footer (for example) and have it send via the regular contact page. Errors will then be displayed on the regular contact page.',
						'default' => "current_url()",
						'required' => false,
					),
					'reply-to' => array(// this is the order-dir="asc" attribute
						'type' => 'email',// Can be: slug, number, flag, text, array, any.
						'flags' => 'If you have a field named "email" it will be used as a default. You should have one or the other if you plan to reply',// flags are predefined values like this.
						'default' => false,// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
                                        'auto-reply' => array(
						'type' => 'text',
						'flags' => 'When specified autoreply, it\'s enabled and the end user will receive a confirmation email to their specified email address. Put here the slug of the Email Template that you wish to use as auto-reply.',
						'default' => false,
						'required' => false,
					),
                                        'attachment-file' => array(
						'type' => 'text',
						'flags' => 'file|jpg|png|zip',
						'default' => '',
						'required' => false,
					),
                                        'attributes' => array(
						'type' => 'text',
						'flags' => 'A additional html attributes for form tag. Ex: attributes="id=form|class=form-contact"',
						'default' => false,
						'required' => false,
					),
                                        'captcha' => array(
						'type' => 'bolean',
						'flags' => 'Require a reCAPTCHA code for bots verification. Set the value to 1 to what  the reCAPATCHA code be showed. The attribute {{ captcha }} need be setted in the page\'s code to show the reCAPTCHA image in your form.',
						'default' => 0,
						'required' => false,
					),
					'button' => array(
						'type' => 'text',
						'flags' => 'The name of the submit button. Ex: button="submit|Submit form"',
						'default' => 'submit|Send|class:button',
						'required' => true,
					),
                                        'template' => array(
						'type' => 'text',
						'flags' => 'The slug of the Email Template that you wish to use',
						'default' => 'contact',
						'required' => false,
					),
                                        'lang' => array(
						'type' => 'flag',
						'flags' => 'The language version of the Email template. Ex: en, br, ch',
						'default' => Settings::get('site_lang'),
						'required' => false,
					),
                                        'to' => array(
						'type' => 'email',
						'flags' => 'Email address to send to',
						'default' => Settings::get('contact_email'),
						'required' => false,
					),
                                        'from' => array(
						'type' => 'email',
						'flags' => 'Server email that emails will show as the sender',
						'default' => Settings::get('server_email'),
						'required' => false,
					),
                                        'sent' => array(
						'type' => 'text',
						'flags' => 'Allows you to set a different message for each contact form. Ex: Your message has been sent. Thank you for contacting us.',
						'default' => false,
						'required' => false,
					),
                                        'error' => array(
						'type' => 'text',
						'flags' => 'Set a unique error message for each form. Ex: Sorry. Your message could not be sent. Please call us at 123-456-7890.',
						'default' => false,
						'required' => false,
					),                                        
                                        'success-redirect' => array(
						'type' => 'uri',
						'flags' => 'Redirect the user to a different page if the message was sent successfully. ',
						'default' => "current_url()",
						'required' => false,
					),                                        
				),
			),// end first method
		);
	
		return $info;
	}

	public function __construct()
	{
		$this->lang->load('contact');                
                $this->load->library('form_validation');
                $this->load->helper('form');
                $this->load->helper('recaptcha');
	}

	public function form()
	{
			
		$field_list = $this->attributes();
		
		// If they try using the old form tag plugin give them an idea why it's failing.
		if ( ! $this->content() or count($field_list) == 0)
		{
			return 'The new contact plugin requires field parameters and it must be used as a double tag.';
		}

		$button             = $this->attribute('button', 'submit|Send|class:button');
		$template           = $this->attribute('template', 'contact');
                $form_attr          = $this->attribute('attributes');
                $captcha            = $this->attribute('captcha', false);
		$autoreply_template = $this->attribute('auto-reply', false);
		$lang               = $this->attribute('lang', Settings::get('site_lang'));
		$to                 = $this->attribute('to', Settings::get('contact_email'));
                $from_name          = $this->attribute('from-name', Settings::get('site_name'));
		$from               = $this->attribute('from', Settings::get('server_email'));
		$reply_to           = $this->attribute('reply-to', Settings::get('server_email'));
		$max_size           = $this->attribute('max-size', 10000);
		$redirect           = $this->attribute('success-redirect', false);
		$action             = $this->attribute('action', current_url());
                $class              = $this->attribute('class', '');
                $form_id            = $this->attribute('id', '');
		$form_meta          = array();
		$validation         = array();
		$output             = array();
		$dropdown           = array();

                $form_attributes = '';
                $items = explode('|', $form_attr);
                // Build the array to pass to the form_dropdown() helper
                foreach ($items as $item)
                {          
                        $item = explode('=', $item);
                        // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                        $form_attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';                                             
                }       
                if($class)
                {
                    $form_attributes .= ' class="' . $class . '" ';
                }
                if($form_id)
                {
                    $form_attributes .= ' id="' . $form_id . '" ';
                }
		// unset all attributes that are not field names
		unset(
                        $field_list['class'],
                        $field_list['captcha'],
			$field_list['template'],
                        $field_list['attributes'],
			$field_list['auto-reply'],
			$field_list['lang'],
			$field_list['to'],
			$field_list['from'],
                        $field_list['from-name'],
			$field_list['reply-to'],
			$field_list['max-size'],
			$field_list['redirect'],
			$field_list['action']
		);
                
		foreach ($field_list as $field => $rules)
		{
			$rule_array = explode('|', $rules);
			
			// Take the simplified form names and turn them into the real deal
			switch ($rule_array[0]) {
                                case '':
					$form_meta[$field]['type'] = 'input';
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;
				break;
                                
				case 'submit':
                                    
					$form_meta[$field]['type'] = 'submit';
                                        $form_meta[$field]['value'] = $rule_array[1];
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type      
                                        
					unset($values[0]);
					unset($values[1]);
                                        
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;                                       
                                        
				break;
                                
                                case 'button':
                                    
					$form_meta[$field]['type'] = 'button';
                                        $form_meta[$field]['value'] = $rule_array[1];
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type      
                                        
					unset($values[0]);
					unset($values[1]);
                                        
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;                                       
                                        
				break;
                                
				case 'text':
					$form_meta[$field]['type'] = 'input';
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;
                                       
				break;
				
				case 'textarea':
					$form_meta[$field]['type'] = 'textarea';
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;
				break;
                            			
				case 'dropdown':
					$form_meta[$field]['type'] = 'dropdown';
					
					// In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
					// Is a value required?
					if ($required_key = array_search('required', $values))
					{
						$other_rules = 'required';
						unset($values[$required_key]);
					}
					else
					{
						// Just set something
						$other_rules = 'trim';
					}

					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{
                                                if(stripos($item, '::') == false)
                                                {
                                                    $item = $item;
                                                }
                                                else
                                                {
                                                    $item = NULL;
                                                }
                                                
						$item = explode('=', $item);
						// If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
						$dropdown[$item[0]] = (count($item) > 1) ? $item[1] : $item[0];
					}
					
                                        foreach ($dropdown as $key => $value)
                                        {
                                            if(is_null($key) OR empty($key) AND is_null($value) OR empty($value))
                                            {
                                                unset($dropdown[$key]);
                                            }
                                        }
                                        
					$form_meta[$field]['dropdown'] = $dropdown;
                                        
					// we need to empty the array else we'll end up with all values appended
					$dropdown = array();
                                        
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;
				break;
				
				case 'file':
					$form_meta[$field]['type'] = 'upload';
					
					$config = $rule_array;
					// get rid of the field type
					unset($config[0]);
					
					// If this attachment is required add that to the rules and unset it from upload config
					if ($required_key = array_search('required', $config))
					{
						if ( ! self::_require_upload($field))
						{
							// We'll set this so validation will fail and our message will be shown
							$other_rules = 'required';
						}
						unset($config[$required_key]);
					}
					else
					{
						$other_rules = 'trim';
					}
					
					// set configs for file uploading
					$form_meta[$field]['config']['allowed_types'] = implode('|', $config);
					$form_meta[$field]['config']['max_size'] = $max_size;
					$form_meta[$field]['config']['upload_path'] = UPLOAD_PATH.'contact_attachments';
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;
				break;	
				
				case 'hidden':
					$form_meta[$field]['type'] = 'hidden';
					$value = preg_split('/=/',$rule_array[1]);
					$value = $value[1];
					$form_meta[$field]['value'] = $value;
                                        
                                        // In this case $rule_array holds the dropdown key=>values and possibly the "required" rule.
					$values = $rule_array;
					// get rid of the field type
					unset($values[0]);
					
                                        $attributes = '';
					// Build the array to pass to the form_dropdown() helper
					foreach ($values as $item)
					{                                                
                                                if(self::_check_attribute($item)){                                                    
                                                    
                                                    $item = explode('::', $item);
                                                    // If they didn't specify a key=>value (example: name=Your Name) then we'll use the value for the key also
                                                    $attributes .= (count($item) > 1) ? $item[0] . '="' . $item[1] . '" ' : '';
                                                }                                                
					}
                                        
					$form_meta[$field]['attr'] = $attributes;
					
				break;					
			}

			$validation[$field]['field'] = $field;
			$validation[$field]['label'] = humanize($field);
			$validation[$field]['rules'] = ($rule_array[0] == 'file' or $rule_array[0] == 'dropdown') ? $other_rules : implode('|', $rule_array);
		}
                
                // reCAPTCHA
                if ( $captcha == TRUE AND Settings::get('recaptcha_public_key') AND Settings::get('recaptcha_private_key'))
                {
                    $validation['recaptcha_response_field']['field'] = 'recaptcha_response_field';
                    $validation['recaptcha_response_field']['label'] = lang('contact_security_key');
                    $validation['recaptcha_response_field']['rules'] = 'required|recaptcha';
                }
                
                $this->form_validation->set_rules($validation);                    

		if ($this->form_validation->run())
		{
			// maybe it's a bot?
			if ($this->input->post('d0ntf1llth1s1n') !== ' ')
			{
				$this->session->set_flashdata('error', lang('contact_submit_error'));
				redirect(current_url());
			}

			$data = $this->input->post();

			// Add in some extra details about the visitor
			$data['sender_agent'] = $this->agent->browser() . ' ' . $this->agent->version();
			$data['sender_ip']    = $this->input->ip_address();
			$data['sender_os']    = $this->agent->platform();
			$data['slug']         = $template;
			// they may have an email field in the form. If they do we'll use that for reply-to.
			$data['reply-to'] = (empty($reply_to) and isset($data['email'])) ? $data['email'] : $reply_to;
			$data['to']       = $to;
			$data['from']     = $from_name.' <'.$from.'>';

			// Yay they want to send attachments along
			if ($_FILES > '')
			{
				$this->load->library('upload');
				is_dir(UPLOAD_PATH.'contact_attachments') OR @mkdir(UPLOAD_PATH.'contact_attachments', 0777);
				
				foreach ($_FILES as $form => $file)
				{
					if ($file['name'] > '')
					{
						// Make sure the upload matches a field
						if ( ! array_key_exists($form, $form_meta)) break;
	
						$this->upload->initialize($form_meta[$form]['config']);
						$this->upload->do_upload($form);
						
						if ($this->upload->display_errors() > '')
						{
							$this->session->set_flashdata('error', $this->upload->display_errors());
							redirect(current_url());
						}
						else
						{
							$result_data = $this->upload->data();
							// pass the attachment info to the email event
							$data['attach'][$result_data['file_name']] = $result_data['full_path'];
						}
					}
				}
			}

			// Try to send the email
			$results = Events::trigger('email', $data, 'array');

			// If autoreply has been enabled then send the end user an autoreply response
			if ($autoreply_template)
			{
				$data_autoreply            = $data;
				$data_autoreply['to']      = $data['email'];
				$data_autoreply['from']    = $data['from'];
				$data_autoreply['slug']    = $autoreply_template;
				$data_autoreply['name']    = $data['name'];
				$data_autoreply['subject'] = $data['subject'];
			}

			// fetch the template so we can parse it to insert into the database log
			$this->load->model('templates/email_templates_m');
			$templates = $this->email_templates_m->get_templates($template);
			
                        $subject = array_key_exists($lang, $templates) ? $templates[$lang]->subject : $templates['en']->subject ;
                        $data['subject'] = $this->parser->parse_string($subject, $data, true);

                        $body = array_key_exists($lang, $templates) ? $templates[$lang]->body : $templates['en']->body ;
                        $data['body'] = $this->parser->parse_string($body, $data, true);
			
			$this->load->model('contact/contact_m');

			// Grab userdata - we'll need this later
			$userdata = $this->session->all_userdata();
			
			// Finally, we insert the same thing into the log as what we sent
			$this->contact_m->insert_log($data);
		
			foreach ($results as $result)
			{
				if ( ! $result)
				{
					if (isset($userdata['flash:new:error']))
					{
						$message = (array) $userdata['flash:new:error'];

						$message[] = $message = $this->attribute('error', lang('contact_error_message'));
					}
					else
					{
						$message = $this->attribute('error', lang('contact_error_message'));
					}
					
					$this->session->set_flashdata('error', $message);
					redirect(current_url());
				}
			}

			if($autoreply_template) {
				Events::trigger('email', $data_autoreply, 'array');
			}


			if (isset($userdata['flash:new:success']))
			{
				$message = (array) $userdata['flash:new:success'];

				$message[] = $this->attribute('sent', lang('contact_sent_text'));
			}
			else
			{
				$message = $this->attribute('sent', lang('contact_sent_text'));
			}

			$this->session->set_flashdata('success', $message);
			redirect( ($redirect ? $redirect : current_url()) );
		}

		// From here on out is form production
		$parse_data = array();
		foreach ($form_meta as $form => $value)
		{
                    
			$parse_data[$form]  = form_error($form, '<div class="'.$form.'-error error">', '</div>');
			
			if ($value['type'] == 'dropdown')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														$form_meta[$form]['dropdown'],
														set_value($form),
														$form_meta[$form]['attr']
													 );
			}
			elseif($value['type'] == 'hidden')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														$value['value'],
														$form_meta[$form]['attr']
													 );
			}
                        elseif($value['type'] == 'submit')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
                                                                                                                 $form,
                                                                                                                 $value['value'],
                                                                                                                 $form_meta[$form]['attr']
                                                                                                          );
			}
                        elseif($value['type'] == 'button')
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
                                                                                                                 $form,
                                                                                                                 $value['value'],
                                                                                                                 $form_meta[$form]['attr']
                                                                                                          );
			}
			else
			{
				$parse_data[$form] .= call_user_func('form_'.$value['type'],
														$form,
														set_value($form),
														$form_meta[$form]['attr']
													 );
			}
                        
		}
                
                if ( $captcha == TRUE AND Settings::get('recaptcha_public_key') AND Settings::get('recaptcha_private_key') ){

                    $parse_data['captcha'] = form_error('recaptcha_response_field', '<div class="recaptcha_response_field-error error">', '</div>') . recaptcha_get_html(Settings::get('recaptcha_public_key'));                    
                    
                }             
		$output	 = form_open_multipart($action, $form_attributes).PHP_EOL;
		$output	.= form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"');
		$output	.= $this->parser->parse_string($this->content(), str_replace('{{', '{ {', $parse_data), true).PHP_EOL;
		$output .= form_close();

		return $output;
	}
	
	public function _require_upload($field)
	{
		if ( isset($_FILES[$field]) and $_FILES[$field]['name'] > '')
		{
			return true;
		}
		return false;
	}
        
        public function _check_attribute($item)
        {
                if($item != 'required' OR $item != 'valid_email' OR $item != 'trim'  OR $item != 'matches'  OR $item != 'is_unique'  OR $item != 'min_length'  OR $item != 'max_length'  OR $item != 'exact_length'  OR $item != 'greater_than'  OR $item != 'less_than'  OR $item != 'alpha'  OR $item != 'alpha_numeric'  OR $item != 'alpha_dash'  OR $item != 'numeric'  OR $item != 'integer'  OR $item != 'decimal'  OR $item != 'is_natural'  OR $item != 'is_natural_no_zero'  OR $item != 'valid_emails'  OR $item != 'valid_ip'  OR $item != 'valid_base64')
                {  
                    return TRUE;                    
                }                
                return FALSE;
        }
 
}

