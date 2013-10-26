<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Blog module
 *
 * @author  MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Blog
 */
class Module_Blog extends Module
{
	public $version = '2.0.0';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Blog',
				'br' => 'Blog',
			),
			'description' => array(
				'en' => 'Post blog entries.',
				'br' => 'Escrever publicações de blog.',
			),
                        'extra' => array(
			    'sections_icon' => 'icon-file',
                            'dashboard' => array(
                                'class' => 'magenta',
                                'title' => 'lang:cp:manage_blog',
                                'icon' => 'icon-file'                                
                            )
                        ),
			'frontend' => true,
			'backend' => true,
			'skip_xss' => true,
			'menu' => 'content',

			'roles' => array(
				'put_live', 'edit_live', 'delete_live'
			),

			'sections' => array(
				'posts' => array(
					'name' => 'blog:posts_title',
					'uri' => 'admin/blog',
					'shortcuts' => array(
						array(
							'name' => 'blog:create_title',
							'uri' => 'admin/blog/create',
							'class' => 'add',
						),
					),
				),
				'categories' => array(
					'name' => 'cat:list_title',
					'uri' => 'admin/blog/categories',
					'shortcuts' => array(
						array(
							'name' => 'cat:create_title',
							'uri' => 'admin/blog/categories/create',
							'class' => 'add',
						),
					),
				),
			),
		);

		if (function_exists('group_has_role'))
		{
			if(group_has_role('blog', 'admin_blog_fields'))
			{
				$info['sections']['fields'] = array(
							'name' 	=> 'global:custom_fields',
							'uri' 	=> 'admin/blog/fields',
								'shortcuts' => array(
									'create' => array(
										'name' 	=> 'streams:add_field',
										'uri' 	=> 'admin/blog/fields/create',
										'class' => 'add'
										)
									)
							);
			}
		}

		return $info;
	}

	public function install()
	{
		$this->dbforge->drop_table('blog_categories');

		$this->load->driver('Streams');
		$this->streams->utilities->remove_namespace('blogs');

		// Just in case.
		$this->dbforge->drop_table('blog');

		if ($this->db->table_exists('data_streams'))
		{
			$this->db->where('stream_namespace', 'blogs')->delete('data_streams');
		}

		// Create the blog categories table.
		$this->install_tables(array(
			'blog_categories' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
                                'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),				
			),
                        'blog_galleries' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'blog_id' => array('type' => 'INT', 'constraint' => 11, 'null' => false),
				'file_id' => array('type' => 'VARCHAR', 'constraint' => 25, 'null' => false),
                                'sort' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			),
		));

		$this->streams->streams->add_stream(
			'lang:blog:blog_title',
			'blog',
			'blogs',
			null,
			'Campos personalizados para o módulo de blog.'
		);
                
                $fields = array(
                array(
                        'name'          => 'lang:blog:image_label',
                        'slug'          => 'image',
                        'namespace'     => 'blogs',
                        'type'          => 'image',
                        'extra'         => array(
                            'folder'        => 2,
                            'resize_width'  => '',
                            'resize_height' => '',
                            'keep_ratio'    => 'yes',
                            'allowed_types' => 'jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF'
                        ),     
                        'assign'        => 'blog',
                        'required'      => false, 
                        'locked'        => true,
                        'unique'        => false
                        ),
		array(
			'name'          => 'lang:blog:intro_label',
			'slug'          => 'intro',
			'namespace'     => 'blogs',
			'type'          => 'wysiwyg',			
			'extra'         => array(
                            'editor_type'   => 'simple', 
                            'allow_tags'    => 'y'
                        ),
                        'assign'        => 'blog',
			'required'      => false,
                        'locked'        => true,
                        'unique'        => false
                    )
                );
		$this->streams->fields->add_fields($fields);

		// Ad the rest of the blog fields the normal way.                
                
		$blog_fields = array(
				'title' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false, 'unique' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false),
				'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
				'body' => array('type' => 'TEXT'),
				'parsed' => array('type' => 'TEXT'),
				'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
				'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'created_on' => array('type' => 'INT', 'constraint' => 11),
				'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
				'comments_enabled' => array('type' => 'ENUM', 'constraint' => array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'), 'default' => '3 months'),
				'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
				'type' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple')),
				'preview_hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => ''),
		);
                                
		return $this->dbforge->add_column('blog', $blog_fields);
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
