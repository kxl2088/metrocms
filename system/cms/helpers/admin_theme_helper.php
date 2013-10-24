<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MetroCMS Admin Theme Helpers
 *
 * @author      MetroCMS Dev Team
 * @copyright   Copyright (c) 2013
 * @package		MetroCMS\Core\Modules\Theme\Helpers
 */

// ------------------------------------------------------------------------

/**
 * Partial Helper
 *
 * Loads the partial
 *
 * @param string $file The name of the file to load.
 * @param string $ext The file's extension.
 */
function file_partial($file = '', $ext = 'php')
{
	$CI = & get_instance();
	$data = & $CI->load->_ci_cached_vars;

	$path = $data['template_views'].'partials/'.$file;

	echo $CI->load->_ci_load(array(
		'_ci_path' => $data['template_views'].'partials/'.$file.'.'.$ext,
		'_ci_return' => true
	));
}

// ------------------------------------------------------------------------

/**
 * Template Partial
 *
 * Display a partial set by the template
 *
 * @param string $name The view partial to display.
 */
function template_partial($name = '')
{
	$CI = & get_instance();
	$data = & $CI->load->_ci_cached_vars;

	echo isset($data['template']['partials'][$name]) ? $data['template']['partials'][$name] : '';
}

// ------------------------------------------------------------------------

/**
 * Add an admin menu item to the order array
 * at a specific place.
 *
 * For instance, if you have a menu item with a keu 'lang:my_menu',
 * and you want to add it to the 2nd position, you can do this:
 *
 * add_admin_menu_place('lang:my_menu', 2);
 *
 * @param 	string
 * @param 	int
 * @return 	void
 */
function add_admin_menu_place($key, $place)
{
	if ( ! is_numeric($place) or $place < 1)
	{
		return null;
	}

	$place--;

	$CI = get_instance();

	$CI->template->menu_order = array_merge(array_slice($CI->template->menu_order, 0, $place, true), array($key), array_slice($CI->template->menu_order, $place, count($CI->template->menu_order)-1, true));
}

// ------------------------------------------------------------------------

/**
 * Accented Foreign Characters Output
 *
 * @return null|array The array of the accented characters and their replacements.
 */
function accented_characters()
{
	if (defined('ENVIRONMENT') and is_file(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php'))
	{
		include(APPPATH.'config/'.ENVIRONMENT.'/foreign_chars.php');
	}
	elseif (is_file(APPPATH.'config/foreign_chars.php'))
	{
		include(APPPATH.'config/foreign_chars.php');
	}

	if (!isset($foreign_characters))
	{
		return;
	}

	$languages = array();
	foreach ($foreign_characters as $key => $value)
	{
		$languages[] = array(
			'search' => $key,
			'replace' => $value
		);
	}

	return $languages;
}

function admin_theme_options()
{
	$CI = & get_instance();
	$CI->load->model('addons/theme_m');

        $all_options = $CI->theme_m->get_options_by(array('theme' => 'metrocms'));
        $options = array();
        
        foreach ($all_options as $opt_value)
        {
            $options[$opt_value->slug] = (array)$opt_value;
        }
                
	return $options;
}

function total_comments()
{
	$CI = & get_instance();
                
	return $CI->db->where(array('is_active' => 1))->count_all_results('comments');
}

function total_pages()
{
	$CI = & get_instance();
                
	return $CI->db->where(array('status' => 'live'))->count_all_results('pages');
}

function total_users()
{
	$CI = & get_instance();
                
	return $CI->db->where_in('active', array(0,1))->count_all_results('users');
}

function total_files()
{
	$CI = & get_instance();
                
	return $CI->db->count_all_results('files');
}

function get_falgun_colors()
{
    $colors = array('orange', 'blue-violate', 'light-blue', 'white', 'blue-white', 'gray', 'light-gray', 'magenta', 'green', 'bondi-blue', 'dark-yellow', 'blue', 'brown');
    $return_colors = array();
    
    foreach ($colors as $key => $value) {
        $return_colors[$value] = $value;
    }
    unset($colors);
    
    return $return_colors;
}

function get_falgun_icons()
{
    $icons = array('icon-glass', 'icon-music', 'icon-search', 'icon-envelope', 'icon-heart', 'icon-star', 'icon-star-empty', 'icon-user', 'icon-film', 'icon-th-large', 'icon-th', 'icon-th-list', 'icon-ok', 'icon-remove', 'icon-zoom-in', 'icon-zoom-out', 'icon-off', 'icon-signal', 'icon-cog', 'icon-trash', 'icon-home', 'icon-file', 'icon-time', 'icon-road', 'icon-download-alt', 'icon-download', 'icon-upload', 'icon-inbox', 'icon-play-circle', 'icon-repeat', 'icon-refresh', 'icon-list-alt', 'icon-lock', 'icon-flag', 'icon-headphones', 'icon-volume-off', 'icon-volume-down', 'icon-volume-up', 'icon-qrcode', 'icon-barcode', 'icon-tag', 'icon-tags', 'icon-book', 'icon-bookmark', 'icon-print', 'icon-camera', 'icon-font', 'icon-bold', 'icon-italic', 'icon-text-height', 'icon-text-width', 'icon-align-left', 'icon-align-center', 'icon-align-right', 'icon-align-justify', 'icon-list', 'icon-indent-left', 'icon-indent-right', 'icon-facetime-video', 'icon-picture', 'icon-pencil', 'icon-map-marker', 'icon-adjust', 'icon-tint', 'icon-edit', 'icon-share', 'icon-check', 'icon-move', 'icon-step-backward', 'icon-fast-backward', 'icon-backward', 'icon-play', 'icon-pause', 'icon-stop', 'icon-forward', 'icon-fast-forward', 'icon-step-forward', 'icon-eject', 'icon-chevron-left', 'icon-chevron-right', 'icon-plus-sign', 'icon-minus-sign', 'icon-remove-sign', 'icon-ok-sign', 'icon-question-sign', 'icon-info-sign', 'icon-screenshot', 'icon-remove-circle', 'icon-ok-circle', 'icon-ban-circle', 'icon-arrow-left', 'icon-arrow-right', 'icon-arrow-up', 'icon-arrow-down', 'icon-share-alt', 'icon-resize-full', 'icon-resize-small', 'icon-plus', 'icon-minus', 'icon-asterisk', 'icon-exclamation-sign', 'icon-gift', 'icon-leaf', 'icon-fire', 'icon-eye-open', 'icon-eye-close', 'icon-warning-sign', 'icon-plane', 'icon-calendar', 'icon-random', 'icon-comment', 'icon-magnet', 'icon-chevron-up', 'icon-chevron-down', 'icon-retweet', 'icon-shopping-cart', 'icon-folder-close', 'icon-folder-open', 'icon-resize-vertical', 'icon-resize-horizontal', 'icon-bar-chart', 'icon-twitter-sign', 'icon-facebook-sign', 'icon-camera-retro', 'icon-key', 'icon-cogs', 'icon-comments', 'icon-thumbs-up', 'icon-thumbs-down', 'icon-star-half', 'icon-heart-empty', 'icon-signout', 'icon-linkedin-sign', 'icon-pushpin', 'icon-external-link', 'icon-signin', 'icon-trophy', 'icon-github-sign', 'icon-upload-alt', 'icon-lemon', 'icon-phone', 'icon-check-empty', 'icon-bookmark-empty', 'icon-phone-sign', 'icon-twitter', 'icon-facebook', 'icon-github', 'icon-unlock', 'icon-credit-card', 'icon-rss', 'icon-hdd', 'icon-bullhorn', 'icon-bell', 'icon-certificate', 'icon-hand-right', 'icon-hand-left', 'icon-hand-up', 'icon-hand-down', 'icon-circle-arrow-left', 'icon-circle-arrow-right', 'icon-circle-arrow-up', 'icon-circle-arrow-down', 'icon-globe', 'icon-wrench', 'icon-tasks', 'icon-filter', 'icon-briefcase', 'icon-fullscreen', 'icon-group', 'icon-link', 'icon-cloud', 'icon-beaker', 'icon-cut', 'icon-copy', 'icon-paper-clip', 'icon-save', 'icon-sign-blank', 'icon-reorder', 'icon-list-ul', 'icon-list-ol', 'icon-strikethrough', 'icon-underline', 'icon-table', 'icon-magic', 'icon-truck', 'icon-pinterest', 'icon-pinterest-sign', 'icon-google-plus-sign', 'icon-google-plus', 'icon-money', 'icon-caret-down', 'icon-caret-up', 'icon-caret-left', 'icon-caret-right', 'icon-columns', 'icon-sort', 'icon-sort-down', 'icon-sort-up', 'icon-envelope-alt', 'icon-linkedin', 'icon-undo', 'icon-legal', 'icon-dashboard', 'icon-comment-alt', 'icon-comments-alt', 'icon-bolt', 'icon-sitemap', 'icon-umbrella', 'icon-paste', 'icon-lightbulb', 'icon-exchange', 'icon-cloud-download', 'icon-cloud-upload', 'icon-user-md', 'icon-stethoscope', 'icon-suitcase', 'icon-bell-alt', 'icon-coffee', 'icon-food', 'icon-file-alt', 'icon-building', 'icon-hospital', 'icon-ambulance', 'icon-medkit', 'icon-fighter-jet', 'icon-beer', 'icon-h-sign', 'icon-plus-sign-alt', 'icon-double-angle-left', 'icon-double-angle-right', 'icon-double-angle-up', 'icon-double-angle-down', 'icon-angle-left', 'icon-angle-right', 'icon-angle-up', 'icon-angle-down', 'icon-desktop', 'icon-laptop', 'icon-tablet', 'icon-mobile-phone', 'icon-circle-blank', 'icon-quote-left', 'icon-quote-right', 'icon-spinner', 'icon-circle', 'icon-reply');
    $return_icons = array();
    
    foreach ($icons as $key => $value) {
        $return_icons[$value] = $value;
    }
    unset($icons);
    
    return $return_icons;
}

function dashboard_links()
{
    $CI = & get_instance();    
    if( $CI->modules_extra )
    {
        $enabled_colors = get_falgun_colors();
        $enabled_icons = get_falgun_icons();

        foreach ($CI->modules_extra as $module)
        {                
            if(array_key_exists($module['slug'], $CI->permissions) OR $CI->current_user->group == 'admin')
            {
                if( (isset($module['dashboard']) AND is_array($module['dashboard'])) AND array_key_exists(CURRENT_LANGUAGE, $module['dashboard']) )
                {
                    if( isset($module['name']) AND isset($module['dashboard'][CURRENT_LANGUAGE]['class']) AND isset($module['dashboard'][CURRENT_LANGUAGE]['icon']) )
                    {
                        $title = $module['dashboard'][CURRENT_LANGUAGE]['title'];                    
                        $url = site_url('admin/' . $module['slug']);
                        $class = array_key_exists($module['dashboard'][CURRENT_LANGUAGE]['class'], $enabled_colors) ? $module['dashboard'][CURRENT_LANGUAGE]['class'] : $enabled_colors[array_rand($enabled_colors)];
                        $icon = array_key_exists($module['dashboard'][CURRENT_LANGUAGE]['icon'], $enabled_icons) ? $module['dashboard'][CURRENT_LANGUAGE]['icon'] : $enabled_icons[array_rand($enabled_icons)];
                        $name = $module['name'];

                        echo "\n\t<li>\n";
                        echo "\t\t<a class=\"". $class . ($title ? ' tooltip-t' : '') ."\" title=\"". $title ."\" href=\"". $url ."\"><i class=\"". $icon ."\"></i><span>". $name ."</span></a>";                       
                        echo "\n\t</li>";
                    }
                }
                else
                {
                    if( isset($module['name']) AND isset($module['dashboard']['class']) AND isset($module['dashboard']['icon']) )
                    {
                        $title = substr($module['dashboard']['title'], 0, 4) == 'lang' ? lang(substr($module['dashboard']['title'], 5)) : $module['dashboard']['title'];
                        $url = site_url('admin/' . $module['slug']);
                        $class = array_key_exists($module['dashboard']['class'], $enabled_colors) ? $module['dashboard']['class'] : $enabled_colors[array_rand($enabled_colors)];
                        $icon = array_key_exists($module['dashboard']['icon'], $enabled_icons) ? $module['dashboard']['icon'] : $enabled_icons[array_rand($enabled_icons)];
                        $name = $module['name'];

                        echo "\n\t<li>\n";
                        echo "\t\t<a class=\"". $class . ($title ? ' tooltip-t' : '') ."\" title=\"". $title ."\" href=\"". $url ."\"><i class=\"". $icon ."\"></i><span>". $name ."</span></a>";    
                        echo "\n\t</li>";
                    }
                }
            }
        }
    }
}