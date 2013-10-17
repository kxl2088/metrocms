<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * metroStreams Multiple Relationships Field Type
 *
 * @package		metroStreams
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2013, Adam Fairholm
 * @link		https://github.com/adamfairholm/metroStreams-Multiple-Relationships
 */
class Field_multiple
{
	
	/**
	 * Field Type Slug
	 *
	 * @var 	string
	 */
	public $field_type_slug			= 'multiple';
	
	/**
	 * Alt Process
	 *
	 * Is this field type alternatively processed?
	 *
	 * @var 	bool
	 */
	public $alt_process				= true;
	
	/**
	 * Database Column Type
	 *
	 * Instead of a database colunn, we have a
	 * binding table, so we'll set this to false.
	 *
	 * @var 	string|bool
	 */
	public $db_col_type				= false;

	/**
	 * Custom Parameters
	 *
	 * Our only parameter is 'choose_stream', which
	 * selects to stream to bind entries to.
	 *
	 * @var 	array
	 */
	public $custom_parameters		= array('choose_stream', 'choose_ui', 'additional_fields');

	/**
	 * Version Number
	 *
	 * @var 	string
	 */
	public $version					= '2.0.1';

	/**
	 * Author
	 *
	 * @var 	string
	 */
	public $author					= array('name' => 'Adam Fairholm', 'url' => 'http://adamfairholm.com');

	/**
	 * Pre Save
	 *
	 * @param	string 	$input Column input from the database
	 * @param	obj $field The field object
	 * @param	obj $stream The stream object
	 * @param	int $id The id of the row we are saving to
	 * @return	void
	 */
	public function pre_save($input, $field, $stream, $id, $form_data)
	{
		// Get the other stream & table name
		$linked_stream = $this->CI->streams_m->get_stream($field->field_data['choose_stream']);
		$table_name = $stream->stream_prefix.$stream->stream_slug.'_'.$linked_stream->stream_slug;

		// Are we editing this row?
		// If so, clear the data. We are just going to
		// replace it so now sense in trying to update it
		if (isset($form_data['row_edit_id']) && is_numeric($row_id = $form_data['row_edit_id'])) {
			$this->CI->db->where('row_id', $form_data['row_edit_id'])->delete($table_name);
		}
		else {
			$row_id = $id;
		}
		
		// Go through and add the values
		if ( ! is_array($input)) {
			$items = explode(',', $input);
		}
		else {
			$items = $input;
		}
                
		// We'll glue / return these
		$ids = array();
		
		foreach ($items as $item) {			
                        
			if (trim($item) == '' && !is_array($item)) {
				continue;
			}
                        
                        $extra_fields = array();
                        
                        if(is_array($item)){
                            foreach ($item as $key => $value) {
                                if ( $this->CI->db->field_exists($key, $table_name) and $key != 'id'){
                                    $extra_fields[$key] = $value;
                                }
                            }
                        }
                        
			// We get numeric items from the 
			// multiselect, and it is more complex
			// from the drag/drop interface.
			if (is_numeric($item) && !is_array($item)) {
				$item_id = $item;
                        } else if(is_array($item) && $item['id']) {
                                $item_id = $item['id'];
			} else {
				$item_id = str_replace($field->field_slug.'_', '', $item);
			}
                        
			$insert_data = array(
				'row_id'				=> $row_id,
				$stream->stream_slug.'_id'		=> $stream->id,
				$linked_stream->stream_slug.'_id'	=> (int)$item_id
             		);
                        
             		$ids[] = $item_id;
			
			$this->CI->db->insert($table_name, ($insert_data+$extra_fields));
		}
	}

	/**
	 * Alt Pre Output
	 *
	 * Process before outputting to the backend
	 *
	 * @param	array
	 * @return	string
	 */
	public function alt_pre_output($row_id, $extra, $type, $stream)
	{
		if ( ! $join_stream = $this->CI->streams_m->get_stream($extra['choose_stream'])) {
			return null;
		}

		$title_column = $join_stream->title_column;
		
		// Default to ID for title column if not present
		if ( ! trim($title_column) or ! $this->CI->db->field_exists($title_column, $stream->stream_prefix.$stream->stream_slug.'_'.$join_stream->stream_slug))
		{
			$title_column = 'id';
		}

		$form_data = array();

		// -------------------------------------
		// Figure out Join Table
		// -------------------------------------

		$join_table = $this->CI->db->dbprefix($stream->stream_prefix.$stream->stream_slug.'_'.$join_stream->stream_slug);

		// -------------------------------------
		// Get current data
		// -------------------------------------

		$html = '<ul>';

		$this->CI->db->from($join_table.' AS jt');
		$this->CI->db->join($stream->stream_prefix.$stream->stream_slug.'_'.$join_stream->stream_slug, 'jt.'.$join_stream->stream_slug.'_id = '.$stream->stream_prefix.$stream->stream_slug.'_'.$join_stream->stream_slug.'.id');
		$this->CI->db->where('jt.row_id', $row_id, false);
		$query = $this->CI->db->get();
		
		foreach ($query->result() as $node) {
			$html .= '<li><a href="'.site_url('admin/streams/entries/view/'.$join_stream->id.'/'.$node->id).'">'.$node->$title_column.'</a></li>';
		}

		$html .= '</ul>';
		
		return $html;
	}
	
	/**
	 * Plugin Override
	 *
	 * @param	obj
	 * @param 	array
	 * @return	string
	 */
	public function plugin_override($field, $attributes)
	{
		// Get the stream
		$join_stream = $this->CI->streams_m->get_stream($field->field_data['choose_stream']);

		// Our binding table.
		if ($field->field_namespace == 'pages') {
			$join_table = $field->field_namespace.'_'.$join_stream->stream_prefix.$attributes['stream_slug'].'_'.$join_stream->stream_slug;
		} else {
			$join_table = $join_stream->stream_prefix.$attributes['stream_slug'].'_'.$join_stream->stream_slug;
		}

		$params = array(
			'stream'        => $join_stream->stream_slug,
			'namespace'     => $join_stream->stream_namespace
		);

		// Add in any more params.
		$params = array_merge($params, $attributes);

		unset($params['row_id']);
		unset($params['parse_params']);
		unset($params['stream_slug']);

		$this->CI->row_m->sql['from'][] = $this->CI->db->protect_identifiers($join_table, true);
		
		// Filter by our row ID
		$this->CI->row_m->sql['where'][] = $this->CI->db->protect_identifiers($join_table.'.row_id', true)."='".$attributes['row_id']."'";

		$this->CI->row_m->sql['where'][] = $this->CI->db->protect_identifiers($join_table.'.'.$join_stream->stream_slug.'_id', true).'='.$this->CI->db->protect_identifiers($join_stream->stream_prefix.$join_stream->stream_slug.'.id', true);

		$entries = $this->CI->streams->entries->get_entries($params);
		
		// -------------------------------------
		// Rename
		// -------------------------------------
		// Allows us to rename variables in our
		// parameters. So, rename:old_name="new_name"
		// -------------------------------------
		
		$renames = array();

		foreach ($attributes as $key => $to)
		{
			if (substr($key, 0, 7) == 'rename:' and strlen($key) > 7)
			{
				$pieces = explode(':', $key);
			
				$renames[$pieces[1]] = $to;
			}
		}

		if ($renames)
		{
			foreach ($entries['entries'] as $k => $arr)
			{
				foreach ($renames as $from => $to)
				{
					if (isset($entries['entries'][$k][$from]))
					{
						$entries['entries'][$k][$to] = $entries['entries'][$k][$from];
						unset($entries['entries'][$k][$from]);
					}
				}
			}
		}
		
		// -------------------------------------

		return $entries['entries'];
	}	

	/**
	 * Join multiple hook
	 */
	public function join_multiple($data)
	{
		$this->CI->db->join(	
			$data['join_table'],
			$data['join_table'].'.'.$data['join_stream']->stream_slug.'_id = '.$stream->stream_prefix.$data['join_stream']->stream_slug.".id",
			'LEFT' );
		$this->CI->db->where($data['join_table'].'.row_id', $data['row_id']);
	}

	/**
	 * Event
	 *
	 * @return	void
	 */
	public function event()
	{
		$this->CI->type->add_css('multiple', 'multiple.css');
	}
	
	/**
	 * Process for when adding field assignment
	 */
	public function field_assignment_construct($field, $stream)
	{
		$this->CI->load->dbforge();

		// Get the stream we are attaching to.
		$linked_stream = $this->CI->streams_m->get_stream($field->field_data['choose_stream']);
		
		// Make a table
		$table_name = $stream->stream_prefix.$stream->stream_slug.'_'.$linked_stream->stream_slug;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11, 
				'unsigned' => true,
				'auto_increment' => true
				),
			'row_id' => array(
				'type' => 'INT',
				'constraint' => 11
				),
			$stream->stream_slug.'_id' => array(
				'type' => 'INT',
				'constraint' => 11
				),
			$linked_stream->stream_slug.'_id' => array(
				'type' => 'INT',
				'constraint' => 11
				)
		);  
                
                if($field->field_data['additional_fields']){
                    $additional_fields = $field->field_data['additional_fields'];
                    $break_array = explode("\n", $additional_fields);
                    
                    foreach ($break_array as $break){
                        $params = explode(" : ", $break);
                        
                        if(array_key_exists(0, $params)){
                            $value = explode('=', $params[0]);
                            $fields[$value[0]] = array(
                                'type' => 'VARCHAR',
                                'constraint' => 255,
                                'null' => TRUE
                            );
                        }
                        
                        
                    }
                }
		$this->CI->dbforge->add_field($fields);
		$this->CI->dbforge->add_key('id', true);
		
		$this->CI->dbforge->create_table($table_name);
		
		// Add a column so we can filter by values
		/*$this->CI->dbforge->add_column(
			$stream->stream_prefix.$stream->stream_slug,
			array(
				$field->field_slug => array(
					'type' => 'TEXT',
					'null' => true
					)
				)
			);*/
	}

	/**
	 * Process for when removing field assignment
	 *
	 * @param	obj
	 * @param	obj
	 * @return	void
	 */
	public function field_assignment_destruct($field, $stream)
	{
		// Get the stream we are attaching to.
		$linked_stream = $this->CI->streams_m->get_stream($field->field_data['choose_stream']);
		
		// @todo:
		// If the linked stream was already deleted, we have a bit
		// of a problem since we can't get the stream slug.
		// Until we figure that out, here's this:
		if ( ! $linked_stream) {
			return null;
		}

		// Get the table name
		$table_name = $stream->stream_prefix.$stream->stream_slug.'_'.$linked_stream->stream_slug;
		
		// Remove the table		
		$this->CI->dbforge->drop_table($table_name);
	}

	/**
	 * Entry delete
	 *
	 * @param	obj
	 * @param	obj
	 * @return	void
	 */
	public function entry_destruct($entry, $field, $stream)
	{
		// Delete the entries in our binding table
		$linked_stream = $this->CI->streams_m->get_stream($field->field_data['choose_stream']);

		// Get the table name
		$table_name = $stream->stream_prefix.$stream->stream_slug.'_'.$linked_stream->stream_slug;
		
		$this->CI->db->where('row_id', $entry->id)->delete($table_name);
	}

	/**
	 * Process renaming column
	 *
	 * @param	obj
	 * @param	obj
	 * @return	void
	 */
	public function alt_rename_column($field, $stream)
	{
		return null;
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @return	string
	 */
	public function form_output($data, $entry_id, $field)
	{
		if ( ! $stream = $this->CI->streams_m->get_stream($data['custom']['choose_stream'])) {
			return null;
		}

		// Our UI.
		// It's either multi or drag/drop. We defaul to dragdrop.
		$ui = (isset($data['custom']['choose_ui']) and $data['custom']['choose_ui']) ? 
					$data['custom']['choose_ui'] : 'dragdrop';

		$title_column = $stream->title_column;
		
		// Default to ID for title column
		if ( ! trim($title_column) or ! $this->CI->db->field_exists($title_column, $stream->stream_prefix.$stream->stream_slug)) {
			$title_column = 'id';
		}

		$form_data = array(
                    'slug' => $data['form_slug'],
                    'field_data' => $data,
                    'entry_id' => $entry_id,
                    'field_output' => (array)$field,
                    'stream' => (array)$stream
                );

		// -------------------------------------
		// Figure out Join Table
		// -------------------------------------

		$join_table = $field->stream_prefix.$field->stream_slug.'_'.$stream->stream_slug;
		
		// -------------------------------------
		// Get current data
		// -------------------------------------

		$skips = array();
		$form_data['current'] = array();

		$current = array();

                if ($data['custom']['additional_fields']){
                    $extract_fields = explode("\n", $data['custom']['additional_fields']);
                    $fields = array();
                    
                    $fields['id'] = array(
                        'label' => 'ID',
                        'input' => 'type="hidden" class="id_field" value="%s"'
                    );
                    $fields['label'] = array(
                        'label' => 'Etiqueta',
                        'input' => 'type="text" class="label_field" value="%s"'
                    );
                    if($extract_fields){
                        foreach ($extract_fields as $extracted) {
                            $attrs = explode(" : ", $extracted);            
                            $first = explode("=", $attrs[0]);
                            $fields[$first[0]] = array();
                            unset($attrs[0]);
                            
                            $form = '';
                            foreach ($attrs as $attr){
                                $items = explode("=", $attr);
                                $form .= $items[0] . '="' . $items[1] . '" ';                                
                            }
                            $form .= 'value="%s"';
                            
                            $fields[$first[0]]['label'] = $first[1];
                            $fields[$first[0]]['input'] = $form;
                            
                        }
                    }
                }
                
		if (is_numeric($entry_id)) {

			$query = $this->CI->db->from($join_table.' AS jt')
								  ->join($stream->stream_prefix.$stream->stream_slug, 'jt.'.$stream->stream_slug.'_id = '.$stream->stream_prefix.$stream->stream_slug.'.id')
								  ->where('jt.row_id', $entry_id, false)
								  ->get();

			foreach ($query->result() as $node) {
				$skips[]							= $node->id;
				$form_data['current'][$node->id] 	= $node->$title_column;
				$current[] 							= $form_data['slug'].'_'.$node->id;
			}
                        
                        $query_table = $this->CI->db->select('jt.*,' . $stream->stream_prefix.$stream->stream_slug . '.id as item_id,' . $stream->stream_prefix.$stream->stream_slug . '.' . $title_column . ' as label')
                                                    ->from($join_table.' AS jt')
                                                    ->join($stream->stream_prefix.$stream->stream_slug, 'jt.'.$stream->stream_slug.'_id = '.$stream->stream_prefix.$stream->stream_slug.'.id')
								  ->where('jt.row_id', $entry_id, false)
								  ->get();
                        
                        $form_data['fields'] = array();
                        
                        $index = 0;
                        
                        foreach ($query_table->result() as $node) {
                                $form_data['items'][$node->item_id] 	= (array)$node;
                                
                                $form_data['fields'][$node->item_id]['id'] = array(
                                    'label' => 'ID',
                                    'input' => '<input name="' . $form_data['slug'] . '[' . $index . '][id]" type="hidden" class="id_field" value="' . ($this->CI->input->post($form_data['slug'] . "[" . $index . "][id]") ? $this->CI->input->post($form_data['slug'] . "[" . $index . "][id]") : $node->item_id) . '"><strong class="id_text_field">' . ($this->CI->input->post($form_data['slug'] . "[" . $index . "][id]") ? $this->CI->input->post($form_data['slug'] . "[" . $index . "][id]") : $node->item_id)  . '</strong>'
                                );
                                
                                $form_data['fields'][$node->item_id]['label'] = array(
                                    'label' => 'Etiqueta',
                                    'input' => '<input name="' . $form_data['slug'] . '[' . $index . '][label]" type="text" class="label_field" value="' . ($this->CI->input->post($form_data['slug'] . "[" . $index . "][label]") ? $this->CI->input->post($form_data['slug'] . "[" . $index . "][label]") : $node->label) . '">'
                                );
                                
                                $items = (array)$node;
                                foreach ($items as $key => $value){
                                    if(array_key_exists($key, $fields)){
                                        foreach ($fields as $field){
                                            if(array_key_exists($key, $fields) && ($key != 'id' && $key != 'label')){
                                                $form_data['fields'][$node->item_id][$key] = $fields[$key];
                                                $form_data['fields'][$node->item_id][$key]['input'] = preg_replace("/(<input)/", "$1 name=\"" . $form_data['slug'] . "[" . $index . "][" . $key . "]\"", '<input ' . sprintf($fields[$key]['input'], ($this->CI->input->post($form_data['slug'] . "[" . $index . "][" . $key . "]") ? $this->CI->input->post($form_data['slug'] . "[" . $index . "][" . $key . "]") : $node->$key)) . '>');
                                            } 
                                        }
                                    }                                    
                                }
                                
                        $index++;
			}
		}

                foreach ($fields as $key => $value){         
                    $fields[$key]['input'] = preg_replace("/(<input)/", "$1 name=\"" . $form_data['slug'] . "[" . $index . "][" . $key . "]\"", sprintf('<input ' . $value['input'] . '>', ""));
                    if($key == 'id'){
                        $fields[$key]['input'] = preg_replace("/(<input)/", "$1 name=\"" . $form_data['slug'] . "[" . $index . "][" . $key . "]\"", sprintf('<input ' . $value['input'] . '>', "")) . '<strong class="id_text_field"></strong>';
                    }
                    
                }
                
                $form_data['labels'] = $fields;
		// Populate the values
		// Did we submit the form and need to get it from the post val?
        if ($this->CI->input->post($form_data['slug'])) {

        	// Is this post an array or a string?
        	if (is_array($this->CI->input->post($form_data['slug']))) {
        		$items = $this->CI->input->post($form_data['slug']);
        	} else {
				$items = explode(', ', $this->CI->input->post($form_data['slug']));
        	}
			
			foreach ($items as $item) {
				$item = trim($item);
				$id = str_replace($stream->stream_slug.'_', '', $item);

				if (is_numeric($id)) {
					$this->CI->db->or_where('id', $id);
        		}
        	}

	        $obj = $this->CI->db->get($stream->stream_prefix.$stream->stream_slug);

	        foreach ($obj->result() as $node) {
	            $form_data['current'][$node->id] 	= $node->$title_column;
	        }

			// We need the imploded current string as well
	       	$form_data['current_string'] = $this->CI->input->post($form_data['slug']);
	    }
	    else {		
		
			// Nope, we just need to take it from the db
			$form_data['current_string'] = implode(',', $current);
		}

		// -------------------------------------
		// Get the entries		
		// -------------------------------------

		foreach ($skips as $skip) {
			$this->CI->db->where('id != ', $skip);
		}

		$obj = $this->CI->db->get($stream->stream_prefix.$stream->stream_slug);

		$form_data['choices'] = array();

		foreach ($obj->result() as $row) {
			// Need to replace with title column
			$form_data['choices'][$row->id] = $row->$title_column;
		}

		if ($ui == 'dragdrop') {
			return $this->CI->type->load_view('multiple', 'sort_table', $form_data, true);
                } else if($ui == 'table') {
                        $this->CI->type->add_css('multiple', 'multiple_table.css');
                        $this->CI->type->add_js('multiple', 'multiple_table.js');
                        return $this->CI->type->load_view('multiple', 'table', $form_data, true);
		} else {
			return form_multiselect($data['form_slug'].'[]', 
						(array)$form_data['choices']+ (array) $form_data['current'], 
						array_keys($form_data['current']));
		}
	}

	/**
	 * Choose the UI
	 *
	 * Which UI would you like to use? Users have
	 * the choice of a drag/drop or a multiple select.
	 *
	 * @param 	string [$choice]
	 * @return 	string the input form
	 */
	public function param_choose_ui($choice = null)
	{
		$choices = array(
			'dragdrop' 	=> lang('streams:multiple.drag_drop'),
			'multi' 	=> lang('streams:multiple.multiselect'),
                        'table' 	=> lang('streams:multiple.expancive_table')
		);

		return form_dropdown('choose_ui', $choices, $choice);
	}
        
        /**
	 * Additional fields
	 *
	 * @return 	string the input form
	 */
	public function param_additional_fields($fields = null)
	{
		return array(
				'input' 	=> form_textarea('additional_fields', $fields),
				'instructions'	=> $this->CI->lang->line('streams:multiple.additional_fields.desc')
			);
	}

	/**
	 * Get a list of streams to choose from
	 *
	 * @param	int [$stream_id]
	 * @return	string
	 */
	public function param_choose_stream($stream_id = null)
	{
		$this->CI = get_instance();
		
		$this->CI->db->select('id, stream_name, stream_namespace');
		$db_obj = $this->CI->db->get('data_streams');
		
		$streams = $db_obj->result();
		
		foreach ($streams as $stream) {
			if ($stream->stream_namespace) {
				$choices[$stream->stream_namespace][$stream->id] = $stream->stream_name;
			}
		}

		// Is this an edit? and this has a field assignment
		// already? Then unfortunately you can't change the stream.
		// It would be pointless because we'd just have to wipe
		// the data anyways
		$extra = '';

		if ($this->CI->uri->segment(4) == 'edit') {

			// Get the stream.
			$currentStream = $this->CI
								->streams_m->get_stream($stream_id);

			if ( ! $stream) {
				$html = '<strong>No stream found</strong>';
			} else {		
				$html  = '<strong>'.$currentStream->stream_name.'</strong><br>';
				$html .= '<input type="hidden" name="choose_stream" value="'.$stream_id.'" />';
				return $html .= '<em>'.lang('streams:multiple.no_change').'</em>';
			}

			$extra = 'readonly';
		}
		
		return form_dropdown('choose_stream', $choices, $stream_id, $extra);
	}
        
        public function ajax_autocomplete(){
            
            header('Content-type: application/json; charset=utf-8');
            
            $query = $this->CI->input->post('term') ? $this->CI->input->post('term') : $this->CI->input->get('term');
            $stream_id = $this->CI->input->post('stream_id') ? $this->CI->input->post('stream_id') : $this->CI->input->get('stream_id'); 
                        
            if ( ! $stream = $this->CI->streams_m->get_stream($stream_id)) {
			exit(json_encode(array()));
            }
            
            $title_column = $stream->title_column;
		
            // Default to ID for title column
            if ( ! trim($title_column) or ! $this->CI->db->field_exists($title_column, $stream->stream_prefix.$stream->stream_slug)) {
                    $title_column = 'id';
            }
            
            $items = $this->CI->db->like($stream->stream_prefix.$stream->stream_slug . '.' . $title_column, strtoupper($query), 'both')
                                  ->or_like($stream->stream_prefix.$stream->stream_slug . '.id', strtoupper($query), 'both')
                                  ->order_by($stream->stream_prefix.$stream->stream_slug . '.' . $title_column, 'asc')
                                  ->from($stream->stream_prefix.$stream->stream_slug)
                                  ->get();

            $results = $items->result();

            $output = array();

            // Loop through found results to find extra information
            foreach ($results as $row)
            {
                    $output[] = array(
                            'label' => 'ID: ' . $row->id . ' | ' . $row->$title_column,	
                            'value' => $row->id,
                            'name' => $row->$title_column,	
                    );
            }
            
            if( !$results ){
                exit(json_encode(array()));
            }
            
            exit(json_encode($output));
        }
}
