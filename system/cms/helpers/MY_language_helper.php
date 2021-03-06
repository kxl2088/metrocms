<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter HTML5 Language Helper Extension
 *
 * Extended from the CodeIgniter native Language helper
 * @copyright        Copyright (c) 2006, EllisLab, Inc.
 * @link                http://codeigniter.com
 *
 * Description:
 *
 * This extends the language helper to do some of the language-focused HTML5 things like ruby.
 *
 * @copyright         Copyright (c) Adam Fairholm 2010
 * @version         1.0
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/

// ------------------------------------------------------------------------

/**
 * Ruby
 *
 * Generates ruby sequence
 *
 * @access        public
 * @param        array
 * @param        string
 * @return        string
 */
if ( ! function_exists('ruby'))
{
        function ruby($data = array(), $nested = '')
        {
                if( empty($data) || !is_array($data) )
                        return null;
                
                $html = '<ruby>';
                
                if( $nested )
                        $html .= '<ruby>';

                foreach( $data as $orig => $sec )
                {
                        $html .= $orig . ' <rp>(</rp> <rt>' . $sec . '</rt><rp>)</rp>';
                }                
                
                $html .= '</ruby>';
                
                if( $nested )
                        $html .= '<rp>（</rp><rt>' . $nested . '</rt><rp>）</rp></ruby>';
                        
                return $html;
        }
}

// ------------------------------------------------------------------------

function get_supported_lang()
{
	$supported_lang = config_item('supported_languages');

	$arr = array();
	foreach ($supported_lang as $key => $lang)
	{
		$arr[] = $key . '=' . $lang['name'];
	}

	return $arr;
}

// ------------------------------------------------------------------------

/**
 * Language Label
 *
 * Takes a string and checks for lang: at the beginning. If the
 * string does not have lang:, it outputs it. If it does, then
 * it will remove lang: and use the rest as the language line key.
 *
 * @param 	string
 * @return 	string
 */
if ( ! function_exists('lang_label'))
{
	function lang_label($key)
	{
		if (substr($key, 0, 5) == 'lang:')
		{
			return lang(substr($key, 5));
		}
		else
		{
			return $key;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('sprintf_lang'))
{
    function sprintf_lang($line, $variables = array())
    {
        array_unshift($variables, lang($line));
        return call_user_func_array('sprintf', $variables);
    }
}