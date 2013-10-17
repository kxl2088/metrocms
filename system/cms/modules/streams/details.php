<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * MetroStreams Module
 *
 * @package		MetroStreams
 * @author		Adam Fairholm
 * @copyright	Copyright (c) 2011 - 2013, Adam Fairholm
 */
class Module_Streams extends Module {

	/**
	 * MetroStreams Version Number
	 *
	 * @var		string
	 */
	public $version = '2.3.3';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Streams',
				'br' => 'Streams',
			),
			'description' => array(
				'en' => 'Manage, structure, and display data.',
				'br' => 'Gerencie, estruture e exiba dados streams.',
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'is_core' => TRUE,
			'author' => 'Parse19',
			'menu' => 'data',
			'roles' => array('admin_streams', 'admin_fields', 'admin_api')
		);
		
		if( function_exists('group_has_role'))
		{
			if (group_has_role('streams', 'admin_streams'))
			{
				$info['sections']['streams'] = array(
					    'name' => 	'streams:streams',
					    'uri' => 	'admin/streams'
					);
			}
			
			if (group_has_role('streams', 'admin_fields'))
			{
				$info['sections']['fields'] = array(
					    'name' => 'streams:fields',
					    'uri' => 'admin/streams/fields',
					    'shortcuts' => array(
							array(
								'name' => 'streams:new_field',
								'uri' => 'admin/streams/fields/add',
								'class' => 'add'
							)
						),
					);
			}
                        
                        if (group_has_role('streams', 'admin_api'))
			{
				$info['sections']['api'] = array(
					    'name' => 	'API',
					    'uri' => 	'admin/streams/api',
                                            'shortcuts' => array(
							array(
								'name' => 'streams:create_api',
								'uri' => 'admin/streams/api/add',
								'class' => 'add'
							)
						),
					);
			}                        
	
			$assignment_uris = array('assignments', 'new_assignment', 'edit_assignment', 'edit', 'view_options');
			
			$shortcuts = array();
			
			// Streams Add 
			if(
				group_has_role('streams', 'admin_streams') and 
				! in_array($this->uri->segment(3), $assignment_uris) and
				($this->uri->segment(3) != 'entries' and $this->uri->segment(3) != 'manage')
			)
			{
				$shortcuts[] = array(
						'name' => 'streams:add_stream',
						'uri' => 'admin/streams/add/',
						'class' => 'add');
			}	

			// Entry Add 
			if(
				! in_array($this->uri->segment(3), $assignment_uris) and
				($this->uri->segment(3) != 'entries' and $this->uri->segment(3))
			)
			{
				$shortcuts[] = array(
						'name' => 'streams:add_entry',
						'uri' => 'admin/streams/entries/add/'.$this->uri->segment(4),
						'class' => 'add');
			}	
			
			// Assignment Add
			if(
				group_has_role('streams', 'admin_streams') and
				in_array($this->uri->segment(3), $assignment_uris) and
				$this->uri->segment(3) != 'entries' or 
				$this->uri->segment(3) == 'manage')
			{
			
				$shortcuts[] = array(
						'name' => 'streams:new_field_assign',
						'uri' => 'admin/streams/new_assignment/'.$this->uri->segment(4),
						'class' => 'add');
			}
						
			// Entries
			if(
				!in_array($this->uri->segment(3), $assignment_uris) and
				$this->uri->segment(3) == 'entries'
			):
	
				if(group_has_role('streams', 'admin_streams') ):
	
				$shortcuts[] = array(
						'name' => 'streams:manage',
						'uri' => 'admin/streams/manage/'.$this->uri->segment(5));
						
				endif;
			
				$shortcuts[] = array(
						'name' => 'streams:add_entry',
						'uri' => 'admin/streams/entries/add/'.$this->uri->segment(5),
						'class' => 'add');
	
			endif;
			
			// We only need to nest the shortcuts in sections
			// if we actually need sections.
			if (group_has_role('streams', 'admin_streams') OR group_has_role('streams', 'admin_fields'))
			{
				$info['sections']['streams']['shortcuts'] = $shortcuts;
			}
			else
			{
				$info['shortcuts'] = $shortcuts;
			}
		}
		
		return $info;
	}

	public function admin_menu(&$menu)
	{
		$this->load->helper('streams/streams');

		// Get our streams in the streams core namespace
		$streams = $this->db
						->where('stream_namespace', 'streams')
						->where('menu_path !=', "''")
						->get('data_streams')->result();

		foreach ($streams as $stream)
		{
			if (check_stream_permission($stream, false))
			{
				$pieces = explode('/', $stream->menu_path, 2);

				$pieces[0] = trim($pieces[0]);

				if (substr($pieces[0], 0, 4) == 'nav_')
				{
					$pieces[0] = 'lang:cp:'.$pieces[0];
				}

				if (count($pieces) == 1)
				{
					$menu[$pieces[0]] = 'admin/streams/entries/index/'.$stream->id;
				}
				elseif (count($pieces) == 2)
				{
					$menu[$pieces[0]][trim($pieces[1])] = 'admin/streams/entries/index/'.$stream->id;
				}
			}
		}
	}
	
	/**
	 * Install
	 *
	 * All core streams tables are taken care of by Streams
	 * Core now. We only need to add the searches table.
	 *
	 * @return	bool
	 */	
	public function install()
	{
		$this->load->config('streams/streams');
				
		// Our streams searches schema
		$schema = array(
			'fields' => array(
				'id' => array(
					'type' => 'INT',
					'constraint' => 11,
					'unsigned' => TRUE,
					'auto_increment' => TRUE
				),
				'stream_slug' => array(
					'type' => 'VARCHAR',
					'constraint' => 255
				),
				'stream_namespace' => array(
					'type' => 'VARCHAR',
					'constraint' => 100,
					'null' => TRUE
				),
				'search_id' => array(
					'type' => 'VARCHAR',
					'constraint' => 255,
				),
				'search_term' => array(
					'type' => 'TEXT',
					'null' => TRUE
				),
				'ip_address' => array(
					'type' => 'VARCHAR',
					'constraint' => 100,
					'null' => TRUE
				),
				'total_results' => array(
					'type' => 'INT',
					'constraint' => 11
				),
				'query_string' => array(
					'type' => 'LONGTEXT',
					'null' => TRUE
				)),
			'primary_key' => 'id'
		);
		
		// Case where table does not exist.
		// Add fields and keys.
		if( ! $this->db->table_exists($this->config->item('streams:searches_table')))
		{
			$this->dbforge->add_field($schema['fields']);

			// Add primary key
			if( isset($schema['primary_key']))
			{
				$this->dbforge->add_key($schema['primary_key'], TRUE);
			}

			$this->dbforge->create_table($this->config->item('streams:searches_table'));
		}
		else
		{
			foreach ($schema['fields'] as $field_name => $field_data)
			{
				// If a field does not exist, then create it.
				if ( ! $this->db->field_exists($field_name, $this->config->item('streams:searches_table')))
				{
					$this->dbforge->add_column($this->config->item('streams:searches_table'), array($field_name => $field_data));	
				}
				else
				{
					// Okay, it exists, we are just going to modify it.
					// If the schema is the same it won't hurt it.
					$this->dbforge->modify_column($this->config->item('streams:searches_table'), array($field_name => $field_data));
				}
			}
		}
                
                //API
                $this->dbforge->drop_table('data_stream_api');                
                $fields = array(
                        'id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 11, 
                                                 'auto_increment' => TRUE
                                          ),
                        'created' => array(
                                                 'type' => 'DATETIME',
                                                 'null' => FALSE
                                          ),
                        'updated' => array(
                                                 'type' => 'DATETIME',
                                                 'null' => TRUE
                                          ),
                        'created_by' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 11,
                                                 'null' => TRUE
                                          ),
                        'ordering_count' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 11,
                                                 'null' => FALSE
                                          ),                    
                        'application' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 100,
                                                 'null' => FALSE
                                          ),                    
                        'contact' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 100,
                                                 'null' => TRUE
                                          ),
                        'company' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 255,
                                                 'null' => TRUE
                                          ),
                        'nip' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 50,
                                                 'null' => TRUE
                                          ),
                        'phone' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 50,
                                                 'null' => TRUE
                                          ),
                        'email' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 50,
                                                 'null' => TRUE
                                          ),
                        'token' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 44,
                                                 'null' => TRUE
                                          ),
                        'permissions' => array(
                                                 'type' => 'LONGTEXT',
                                                 'null' => TRUE
                                          ),
                        'enabled' => array(
                                                 'type' => "SET('yes', 'no')",
                                                 'default' => 'no'
                                          ),           
                        'expires_on' => array(
                                                 'type' => "DATETIME",
                                                 'null' => TRUE
                                          ),   
                );                
                $this->dbforge->add_field($fields)
                              ->add_key('id', TRUE)
                              ->create_table('data_stream_api');
                
                //Sessions
                $this->dbforge->drop_table('data_stream_api_sessions');                
                $fields_activity = array(
                        'id' => array(
                                                 'type' => 'INT',
                                                 'constraint' => 11, 
                                                 'auto_increment' => TRUE
                                          ), 
                        'token' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 44,
                                                 'null' => FALSE
                                          ), 
                        'ip_address' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 45,
                                                 'null' => FALSE
                                          ),        
                        'system_op' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 45,
                                                 'null' => TRUE
                                          ),   
                        'user_agent' => array(
                                                 'type' => 'VARCHAR',
                                                 'constraint' => 120,
                                                 'null' => FALSE
                                          ),
                        'last_activity' => array(
                                                 'type' => 'DATETIME',
                                                 'null' => FALSE
                                          ),
                        'user_data' => array(
                                                 'type' => 'TEXT',
                                                 'null' => FALSE
                                          ),               
                );                
                $this->dbforge->add_field($fields_activity)
                              ->add_key('id', TRUE)
                              ->create_table('data_stream_api_sessions');
                
		return true;
	}
	
	/**
	 * Uninstall Streams
	 *
	 * Using API utilities function to remove
	 * all data associated with the 'streams' namespace
	 *
	 * We do not break down the core stream tables
	 * anymore since they are now part of streams_core.
	 * 
	 * @return 	bool
	 */
	public function uninstall()
	{
		$this->load->driver('Streams');
                
		$this->dbforge->drop_table('data_stream_api');
                $this->dbforge->drop_table('data_stream_api_sessions');     
		$this->streams->utilities->remove_namespace('streams');
		
		return TRUE;
	}
	
	public function upgrade($old_version)
	{
		return TRUE;
	}
	
}