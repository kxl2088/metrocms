<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Module
 *
 * @author MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Pages
 */
class Module_Pages extends Module
{
	public $version = '2.2.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Pages',
				'br' => 'Páginas',
			),
			'description' => array(
				'en' => 'Add custom pages to the site with any content you want.',
				'br' => 'Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.',
			),
                        'extra' => array(
			    'sections_icon' => 'icon-file-alt',
                            'dashboard' => array(
                                'class' => 'dark-yellow',
                                'title' => 'lang:cp:manage_pages',
                                'icon' => 'icon-file-alt'
                            )
                        ),
			'frontend' => true,
			'backend'  => true,
			'skip_xss' => true,
			'menu'	  => 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live',
                'create_types', 'edit_types', 'delete_types'
			),

			'sections' => array(
			    'pages' => array(
				    'name' => 'pages:list_title',
				    'uri' => 'admin/pages',
				),
				'types' => array(
				    'name' => 'page_types:list_title',
				    'uri' => 'admin/pages/types'
			    ),
			),
		);

		// We check that the table exists (only when in the admin controller)
		// to avoid any pre 109 migration module class spawning issues.
		if (class_exists('Admin_controller') and $this->db->table_exists('page_types'))
		{
			// Shortcuts for New page

			// Do we have more than one page type? If we don't, no need to have a modal
			// ask them to choose a page type.
			if ($this->db->count_all('page_types') > 1)
			{

				$info['sections']['pages']['shortcuts'] = array(
					array(
					    'name' => 'pages:create_title',
					    'uri' => 'admin/pages/choose_type?modal=true',
					    'class' => 'add modal-ajax'
					)
				);
			}
			else
			{
				// Get the one page type. 
				$page_type = $this->db->limit(1)->select('id')->get('page_types')->row();

				$info['sections']['pages']['shortcuts'] = array(
					array(
					    'name' => 'pages:create_title',
					    'uri' => 'admin/pages/create?page_type='.$page_type->id,
					    'class' => 'add'
					)
				);			
			}

			// Show the correct +Add button based on the page
			if ($this->uri->segment(4) == 'fields' and $this->uri->segment(5))
			{
				$info['sections']['types']['shortcuts'] = array(
								array(
								    'name' => 'streams:new_field',
								    'uri' => 'admin/pages/types/fields/'.$this->uri->segment(5).'/new_field',
								    'class' => 'add'
								)
						    );
			}
			else
			{
				$info['sections']['types']['shortcuts'] = array(
								array(
								    'name' => 'pages:types_create_title',
								    'uri' => 'admin/pages/types/create',
								    'class' => 'add'
								)
							);			
			}
		}

		return $info;
	}

	public function install()
	{
		$this->dbforge->drop_table('page_types');
		$this->dbforge->drop_table('pages');

		// Just in case. If this is a new install, we 
		// definiitely should not have a page_chunks table.
		$this->dbforge->drop_table('page_chunks');

		// We only need to do this if the def_page_fields table
		// has already been added.
		if ($this->db->table_exists('def_page_fields'))
		{
			$this->load->driver('Streams');
			$this->streams->utilities->remove_namespace('pages');
			$this->dbforge->drop_table('def_page_fields');
		}

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'pages')->delete('data_streams');
		}

		$this->load->helper('date');
		$this->load->config('pages/pages');

		$tables = array(
			'page_types' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'title' => array('type' => 'VARCHAR', 'constraint' => 60),
				'description' => array('type' => 'TEXT', 'null' => true),
				'stream_id' => array('type' => 'INT', 'constraint' => 11),
				'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
				'meta_description' => array('type' => 'TEXT', 'null' => true),
				'body' => array('type' => 'TEXT'),
				'css' => array('type' => 'TEXT', 'null' => true),
				'js' => array('type' => 'TEXT', 'null' => true),
				'theme_layout' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => 'default'),
				'updated_on' => array('type' => 'INT', 'constraint' => 11),
                                'save_as_files'     => array('type' => 'CHAR', 'constraint' => 1, 'default' => 'n'),
                                'content_label'     => array('type' => 'VARCHAR', 'constraint' => 60, 'null' => true),
                                'title_label'     => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true)
			),
			'pages' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => '', 'key' => 'slug'),
				'class' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'title' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
				'uri' => array('type' => 'TEXT', 'null' => true),
				'parent_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0, 'key' => 'parent_id'),
				'type_id' => array('type' => 'VARCHAR', 'constraint' => 255),
				'entry_id' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'css' => array('type' => 'TEXT', 'null' => true),
				'js' => array('type' => 'TEXT', 'null' => true),
				'meta_title' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'meta_keywords' => array('type' => 'CHAR', 'constraint' => 32, 'null' => true),
				'meta_robots_no_index' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
				'meta_robots_no_follow' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
				'meta_description' => array('type' => 'TEXT', 'null' => true),
				'rss_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'comments_enabled' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
				'created_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'restricted_to' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
				'is_home' => array('type' => 'INT', 'constraint' => 1, 'default' => 0),
				'strict_uri' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
				'order' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			),
		);

		if ( ! $this->install_tables($tables))
		{
			return false;
		}

		$this->load->driver('streams');

		$stream_id = $this->streams->streams->add_stream(
			'Layout de Página Padrão',
			'def_page_fields',
			'pages',
			null,
			'Um tipo de página simples com um editor WYSIWYG, para você iniciar a adição de conteúdo.'
		);
	
		// add the fields to the streams
		$this->streams->fields->add_fields(config_item('pages:default_fields'));

		// Insert the page type structures
		$page_type = 	array(
			'id' => 1,
			'title' => 'Padrão',
			'slug' => 'default',
			'description' => 'Um tipo de página simples com um editor WYSIWYG, para você iniciar a adição de conteúdo.',
			'stream_id' => $stream_id,
			'body' => "{{ if page:is_home == false }}\n<div class=\"container\">\n<div class=\"row\">\n\n\t<div class=\"col-lg-12\">\n\t\t<h1 class=\"page-header\">{{ template:title }}</h1>\n\t\t{{ theme:partial name=\"breadcrumbs\" }}\n\t</div>\n\n</div>\n</div>\n{{ endif }}\n\n{{ body }}",
			'css' => '',
			'js' => '',
			'updated_on' => now()
		);

		if ( ! $this->db->insert('page_types', $page_type))
		{
			return false;
		}

		$def_page_type_id = $this->db->insert_id();

		$page_content = config_item('pages:default_page_content');
		$page_entries = array(
			'home' => array(
				'slug' => 'home',
				'title' => 'Home',
				'uri' => 'home',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => true,
                                'meta_robots_no_index' => 0,
                                'meta_robots_no_follow' => 0,
				'order' => now()
			),
			'contact' => array(
				'slug' => 'contato',
				'title' => 'Contato',
				'uri' => 'contato',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
                                'meta_robots_no_index' => 0,
                                'meta_robots_no_follow' => 0,
				'order' => now()
			),
			'search' => array(
				'slug' => 'search',
				'title' => 'Pesquisa',
				'uri' => 'search',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
                                'meta_robots_no_index' => 0,
                                'meta_robots_no_follow' => 0,
				'order' => now()
			),
			'search-results' => array(
				'slug' => 'results',
				'title' => 'Resultados',
				'uri' => 'search/results',
				'parent_id' => 3,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
				'strict_uri' => false,
                                'meta_robots_no_index' => 0,
                                'meta_robots_no_follow' => 0,
				'order' => now()
			),
			'fourohfour' => array(
				'slug' => '404',
				'title' => 'Página não encontrada',
				'uri' => '404',
				'parent_id' => 0,
				'type_id' => $def_page_type_id,
				'status' => 'live',
				'restricted_to' => '',
				'created_on' => now(),
				'is_home' => false,
                                'meta_robots_no_index' => 1,
                                'meta_robots_no_follow' => 1,
				'order' => now()
			)
		);

		foreach ($page_entries as $key => $d)
		{
			// Contact Page
			$this->db->insert('pages', $d);
			$page_id = $this->db->insert_id();

			$this->db->insert('def_page_fields', $page_content[$key]);
			$entry_id = $this->db->insert_id();

			$this->db->where('id', $page_id);
			$this->db->update('pages', array('entry_id' => $entry_id));

			unset($page_id);
			unset($entry_id);
		}

		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return false;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}