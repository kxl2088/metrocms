<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Search module
 *
 * @author  MetroCMS Dev Team
 * @package MetroCMS\Core\Modules\Search
 */
class Module_Search extends Module
{
	public $version = '1.0.0';

	public $_tables = array('search_index');

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Internal Search',
				'br' => 'Pesquisa Interna',
			),
			'description' => array(
				'en' => 'Search through various types of content with this modular search system.',
                                'br' => 'Pesquisa através de vários tipos de conteúdo com este sistema de busca modular.'
			),
			'frontend' => false,
			'backend' => false,
			'menu' => false,
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('search_index');

		$this->db->query("
		CREATE TABLE ".$this->db->dbprefix('search_index')." (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `title` char(255) COLLATE utf8_unicode_ci NOT NULL,
		  `description` text COLLATE utf8_unicode_ci,
		  `keywords` text COLLATE utf8_unicode_ci,
		  `keyword_hash` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `module` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `entry_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `entry_plural` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `entry_id` varchar(255) DEFAULT NULL,
		  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `cp_edit_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `cp_delete_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE KEY `unique` (`module`,`entry_key`,`entry_id`(190)),
		  FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		");

		$this->load->model('search/search_index_m');
		$this->load->library('keywords/keywords');

		foreach ($this->db->get('pages')->result() as $page)
		{
			// Only index live articles
	    	if ($page->status === 'live')
	    	{
	    		$hash = $this->keywords->process($page->meta_keywords);

	    		$this->db
	    			->set('meta_keywords', $hash)
	    			->where('id', $page->id)
	    			->update('pages');

	    		$this->search_index_m->index(
	    			'pages',
	    			'pages:page', 
	    			'pages:pages', 
	    			$page->id,
	    			$page->uri,
	    			$page->title,
	    			$page->meta_description ? $page->meta_description : null, 
	    			array(
	    				'cp_edit_uri' 	=> 'admin/pages/edit/'.$page->id,
	    				'cp_delete_uri' => 'admin/pages/delete/'.$page->id,
	    				'keywords' 		=> $hash,
	    			)
	    		);
	    	}
		}

		return true;
	}

	public function admin_menu()
	{
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
