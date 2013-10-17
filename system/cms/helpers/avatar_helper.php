<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Avatar helper for CodeIgniter.
 *
 * @author      MetroCMS Dev Team
 * @copyright   Copyright (c) 2013
 * @package 	MetroCMS\Core\Helpers
 */
if (!function_exists('avatar'))
{

	/**
	 * Avatar helper for CodeIgniter.
	 *
	 * @param string $email The Email address used to generate the avatar
	 * @param int $size The size of the avatar in pixels. A size of 50 would return a avatar with a width and height of 50px.
	 * @param string $rating The rating of the avatar. Possible values are g, pg, r or x
	 * @param boolean $url_only Set this to true if you want the plugin to only return the avatar URL instead of the HTML.
	 * @param boolean $default Url to image used instead af Gravatars default when email has no avatar
	 * @return string The avatar's URL or the img HTML tag ready to be used.
	 */
	function avatar($email = '', $size = 50, $mode = 'fit', $url_only = false, $attributes = '')
	{
		$base_url = base_url();
		$size = '/'.$size.'/'.$size.'/'.$mode;

                if(!$email) return FALSE;
                
                ci()->db->select('profiles.avatar, users.email, files.path');

                if(is_numeric($email)){
                    ci()->db->where('profiles.user_id', $email);
                }
                else
                {
                    ci()->db->where('users.email', $email);
                }
                ci()->db->join('users', 'users.id = profiles.user_id', 'left');
                ci()->db->join('files', 'profiles.avatar = files.id', 'left');

                $result = ci()->db->get('profiles')->row();

                if(!$result) return FALSE;

                if(!$result->path) return FALSE;
                
                $parse_url = ci()->parser->parse_string($result->path, array(), true);
                
		$avatar_url = $parse_url.$size;
                
		// URL only or the entire block of HTML ?
		if ($url_only == true)
		{
			return $avatar_url;
		}
                
                if(is_array($attributes) && !empty($attributes))
                {
                    $parse_attr = "";
                    foreach ($attributes as $key => $value)
                    {
                        $parse_attr .= $key.'="'.$value.'" ';
                    }
                    $parse_attr = substr($parse_attr, 0, (strlen($parse_attr)-1));
                    $attributes = $parse_attr;
                }

		return '<img src="'.$avatar_url.'" '.$attributes.' />';
	}

}