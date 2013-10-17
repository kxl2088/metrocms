<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Sitemap Module
 *
 * @author		MetroCMS Dev Team
 * @package		MetroCMS\Core\Modules\Sitemap
 */
class Module_Sitemap extends Module {

	public $version = '1.3.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Sitemap',
				'br' => 'Mapa do Site',
			),
			'description' => array(
				'en' => 'The sitemap module creates an index of all pages and an XML sitemap for search engines.',
				'br' => 'O módulo de mapa do site cria um índice de todas as páginas e um sitemap XML para motores de busca.',
			),
			'frontend' => true,
			'backend' => false,
			'menu' => 'content'
		);
	}

	public function install()
	{
		return true;
	}

	public function uninstall()
	{
		// This is a core module, lets keep it around.
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}