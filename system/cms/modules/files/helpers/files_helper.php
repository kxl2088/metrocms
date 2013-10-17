<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * Files helper for CodeIgniter.
 *
 * @author		Fabricio Rabelo
 * @package 	MetroCMS\Core\Helpers
 */

if (!function_exists('file_path'))
{
    function file_path($id = '', $parse = false, $width = false, $height = false, $mode = false){
            
            if ($id != "")
            {                
                $file = ci()->db->where('id', $id)->get('files')->row();
                $path = $file ? ($parse ? ci()->parser->parse_string($file->path, false, true) : $file->path) : FALSE;
                //create thumb url
                $url_part = '';
                is_numeric($width) ? $url_part .= '/'.$width : '';
                is_numeric($height) ? $url_part .= '/'.$height : '';
                
                if( $mode == 'fit' or $mode == 'fill' )
                {
                    $url_part .= '/'.$mode;
                }   
                
                if ( $width )
                {
                    $path = str_replace('large/', 'thumb/', $path);
                    $path = $path . $url_part;
                }
                
                return $path;
                
            } else {
                return FALSE;
            }            
    }
}

if (!function_exists('file_real_path'))
{
    function file_real_path($id = ''){
            
            if ($id != "")
            {        
                
                $file = ci()->db->where('id', $id)->get('files')->row();
                $upload_path = UPLOAD_PATH . 'files/';
                
                if ( $file )
                {
                    $file_path = $upload_path . $file->filename;
                    if( file_exists($file_path) )
                    {
                        return $file_path;
                    }
                    else
                    {
                        return FALSE;
                    }
                }
                else
                {
                    $path = FALSE;
                }
                
                return $path;
                
            } else {
                return FALSE;
            }            
    }
}