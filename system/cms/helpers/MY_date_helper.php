<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * MetroCMS Date Helpers
 * 
 * This overrides Codeigniter's helpers/date_helper.php
 *
 * @author      MetroCMS Dev Team
 * @copyright   Copyright (c) 2013
 * @package		MetroCMS\Core\Helpers
 */


if (!function_exists('format_date'))
{

	/**
	 * Formats a timestamp into a human date format.
	 *
	 * @param int $unix The UNIX timestamp
	 * @param string $format The date format to use.
	 * @return string The formatted date.
	 */
	function format_date($unix, $format = '')
	{
		if ($unix == '' || !is_numeric($unix))
		{
			$unix = strtotime($unix);
		}

		if (!$format)
		{
			$format = Settings::get('date_format');
		}

		$date = strstr($format, '%') !== false ? ucfirst(utf8_encode(strftime($format, $unix))) : date($format, $unix);
                
                if(CURRENT_LANGUAGE != 'en')
                {
                    $find = array(                        
                        //Week full
                        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday',
                        //Week abbr
                        'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun',  
                        //Months full
                        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',   
                        //Months abbr
                        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec',        
                    );
                    $replace = array(
                        //Week full
                        lang('date:l_Monday'), lang('date:l_Tuesday'), lang('date:l_Wednesday'), lang('date:l_Thursday'), lang('date:l_Friday'), lang('date:l_Saturday'), lang('date:l_Sunday'), 
                        //Week abbr
                        lang('date:D_Mon'), lang('date:D_Tue'), lang('date:D_Wed'), lang('date:D_Thu'), lang('date:D_Fri'), lang('date:D_Sat'), lang('date:D_Sun'), 
                        //Months full
                        lang('date:F_January'), lang('date:F_February'), lang('date:F_March'), lang('date:F_April'), lang('date:F_May'), lang('date:F_June'), lang('date:F_July'), lang('date:F_August'), lang('date:F_September'), lang('date:F_October'), lang('date:F_November'), lang('date:F_December'), 
                        //Months abbr
                        lang('date:M_Jan'), lang('date:M_Feb'), lang('date:M_Mar'), lang('date:M_Apr'), lang('date:M_May'), lang('date:M_Jun'), lang('date:M_Jul'), lang('date:M_Aug'), lang('date:M_Sep'), lang('date:M_Oct'), lang('date:M_Nov'), lang('date:M_Dec'),                         
                    );
                    
                    $date = str_replace($find, $replace, $date);
                    
                    if( eregi('M', $format) )
                    {
                        $date = str_replace('Maio', lang('date:M_May'), $date);
                    }
                }
                
                return $date;
	}

}