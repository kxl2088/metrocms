<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter HTML5 HTML Helper
 *
 * Extended from the CodeIgniter native HTML helper
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @link		http://codeigniter.com
 *
 * Description:
 *
 * This extends the html helper to do all the cool new HTML5 stuff.
 *
 * @copyright 	Copyright (c) Adam Fairholm 2010
 * @version 	1.0
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
 * Video
 *
 * Generates <video> element
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	array
 * @return	string
 */
if ( ! function_exists('video'))
{
	function video($attr = array(), $sources = array(), $no_support_message = 'Your browser does not support the HTML5 video tag')
	{
		$html = "<video "._parse_attributes($attr).">";

		if( !empty($sources) )
			$html .= _parse_sources($sources);

		$html .= $no_support_message;

		return $html .= "</video>";
	}
}

// ------------------------------------------------------------------------

/**
 * Canvas
 *
 * Generates <canvas> element
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @return	string
 */
if ( ! function_exists('canvas'))
{
	function canvas($attr = array(), $no_support_message = 'Your browser does not support the HTML5 canvas tag')
	{
		return "<canvas "._parse_attributes($attr).">$no_support_message</canvas>";
	}
}

// ------------------------------------------------------------------------

/**
 * Audio
 *
 * Generates <audio> element
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	array
 * @return	string
 */
if ( ! function_exists('audio'))
{
	function audio($attr = array(), $sources = array(), $no_support_message = 'Your browser does not support the HTML5 audio tag')
	{
		$html = "<audio "._parse_attributes($attr).">";

		if( !empty($sources) )
			$html .= _parse_sources($sources);

		$html .= $no_support_message;

		return $html .= "</audio>";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('script_tag'))
{
	/**
	 * Script
	 *
	 * Generates JS to link a JS file
	 *
	 * @param	mixed	stylesheet hrefs or an array
         * @param	string	charset
	 * @param	string	type	 
         * @param	bool	should index_page be added to the css path
	 * @return	string
	 */
	function script_tag($src = '', $charset = 'utf-8', $type = 'text/javascript', $index_page = FALSE)
	{
		$CI =& get_instance();
		$script = '<script ';

		if (is_array($src))
		{
			foreach ($src as $k => $v)
			{
				if ($k === 'src' && strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$script .= 'src="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$script .= 'src="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$script .= $k.'="'.$v.'" ';
				}
			}
		}
		else
		{
			if (strpos($src, '://') !== FALSE)
			{
				$script .= 'src="'.$src.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$script .= 'src="'.$CI->config->site_url($src).'" ';
			}
			else
			{
				$script .= 'src="'.$CI->config->slash_item('base_url').$src.'" ';
			}

			$script .= 'charset="'.$charset.'" type="'.$type.'" ';

		}

		return $script."></script>\r";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('tree_builder'))
{
	/**
	 * Build the html for a tree view
	 *
	 * @param array $items 	An array of items that may or may not have children (under a key named `children` for each appropriate array entry).
	 * @param array $html 	The html string to parse. Example: <li id="{{ id }}"><a href="#">{{ title }}</a>{{ children }}</li>
	 *
	 */
	function tree_builder($items, $html)
	{
		$output = '';

		if( is_array($items) )
		{
			foreach ($items as $item)
			{
				if (isset($item['children']) and ! empty($item['children']))
				{
					// if there are children we build their html and set it up to be parsed as {{ children }}
					$item['children'] = '<ul>'.tree_builder($item['children'], $html).'</ul>';
				}
				else
				{
					$item['children'] = null;
				}

				// now that the children html is sorted we parse the html that they passed
				$output .= ci()->parser->parse_string($html, $item, true);
			}

			return $output;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Parse attributes
 *
 * Parse attributes for HTML elements
 *
 * @access	private
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('_parse_attributes'))
{
	function _parse_attributes($attr = array())
	{
		$html = null;

		if( is_array($attr) )
		{
			foreach( $attr as $key => $val )
			{
				$html .= $key . '="' . $val . '" ';
			}		

			$html = trim($html);
		}

		return $html;
	}
}

// ------------------------------------------------------------------------

/**
 * Parse Sources
 *
 * Generates sources for the <audio> and <video> elements
 *
 * @access	private
 * @param	mixed
 * @param	string
 * @return	string
 */
if ( ! function_exists('_parse_sources'))
{
	function _parse_sources($sources = array())
	{
		if( empty($sources) )
			return null;

		$html = null;

		foreach( $sources as $source )
		{
			$html .= '<source src="' . $source['src'] . '"';

			if( isset($source['type']) )
				$html .= ' type="' . $source['type'] . '"';

			if( isset($source['media']) )
				$html .= ' media="' . $source['media'] . '"';

			if( isset($source['attr']) && !empty($source['attr']) )
				$html .= ' ' . _parse_attributes( $source['attr'] );

			$html .= ' />';
		}

		return $html;
	}
}