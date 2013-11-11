<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Metrocms extends Theme {

    public $name			= 'Falgun - Metro Style Bootstrap Admin Dashboard';
    public $author			= 'westilian';
    public $author_website	= 'http://themeforest.net/user/westilian';
    public $website			= 'http://themeforest.net/item/falgun-metro-style-bootstrap-admin-dashboard/4257951';
    public $description		= 'Falgun admin theme. A Metro style Bootstrap admin theme, using HTML5 and CSS3.';
    public $version			= '1.1.0';
    public $type			= 'admin';
    public $options 		= array(
	'default_theme' => array(
				    'title'	    => 'Default Dashboard Theme',
                                    'description'   => 'Select the default dashboard theme do you like display',
                                    'default'       => 'theme-default.css',
                                    'type'          => 'select',
                                    'options'       => 'theme-default.css=Default|theme-blue.css=Blue|theme-dark-orange.css=Dark Orange|theme-fabrics.css=Fabrics|theme-wooden.css=Wooden',
                                    'is_required'   => false),
        'metrocms_recent_comments' => array('title' 		=> 'Recent Comments',
                                    'description'   => 'Would you like to display recent comments on the dashboard?',
                                    'default'       => 'yes',
                                    'type'          => 'radio',
                                    'options'       => 'yes=Yes|no=No',
                                    'is_required'   => true),

        'metrocms_news_feed' => 			array('title' => 'News Feed',
                                    'description'   => 'Would you like to display the news feed on the dashboard?',
                                    'default'       => 'yes',
                                    'type'          => 'radio',
                                    'options'       => 'yes=Yes|no=No',
                                    'is_required'   => true),

        'metrocms_site_stats' => array('title' => 'Site Stats',
                                    'description'   => 'Would you like to display site stats on the dashboard?',
                                    'default'       => 'yes',
                                    'type'          => 'radio',
                                    'options'       => 'yes=Yes|no=No',
                                    'is_required'   => true),

        'metrocms_analytics_graph' => 	array('title' => 'Analytics Graph',
                                    'description'   => 'Would you like to display the graph on the dashboard?',
                                    'default'       => 'yes',
                                    'type'          => 'radio',
                                    'options'       => 'yes=Yes|no=No',
                                    'is_required'   => true),
								   );
	
	/**
	 * Run() is triggered when the theme is loaded for use
	 *
	 * This should contain the main logic for the theme.
	 *
	 * @access	public
	 * @return	void
	 */
	public function run()
	{
		// only load these items on the dashboard
		if ($this->module == '' && $this->method != 'login' && $this->method != 'help')
		{
			// don't bother fetching the data if it's turned off in the theme
			if ($this->theme_options->metrocms_analytics_graph == 'yes')		self::get_analytics();
			if ($this->theme_options->metrocms_news_feed == 'yes')			self::get_rss_feed();
			if ($this->theme_options->metrocms_recent_comments == 'yes')		self::get_recent_comments();
		}
	}
	
	public function get_analytics()
	{
		if ($this->settings->ga_email and $this->settings->ga_password and $this->settings->ga_profile)
		{
			// Not false? Return it
			if ($cached_response = $this->metrocache->get('analytics'))
			{
				$data['analytic_visits'] = $cached_response['analytic_visits'];
				$data['analytic_views'] = $cached_response['analytic_views'];
				$data['analytic_avgtimeonsite'] = $cached_response['analytic_avgtimeonsite'];
				$data['analytic_browsers'] = $cached_response['analytic_browsers'];
				$data['analytic_systems'] = $cached_response['analytic_systems'];
			}
			else
			{
				try
				{
					$this->load->library('analytics', array(
						'username' => $this->settings->ga_email,
						'password' => $this->settings->ga_password
					));

					// Set by GA Profile ID if provided, else try and use the current domain
					$this->analytics->setProfileById('ga:'.$this->settings->ga_profile);

					$end_date = date('Y-m-d');
					$start_date = date('Y-m-d', strtotime('-1 month'));

					$this->analytics->setDateRange($start_date, $end_date);

					$visits = $this->analytics->getVisitors();
					$views = $this->analytics->getPageviews();
					$avgtimeonsite = $this->analytics->getAvgTimeOnSite();
					$browsers = $this->analytics->getBrowsers();
					$os = $this->analytics->getOperatingSystem();					
					
					/* build visits and page views */
					if (count($visits))
					{
						foreach ($visits as $date => $visit)
						{
							$year = substr($date, 0, 4);
							$month = substr($date, 4, 2);
							$day = substr($date, 6, 2);

							$utc = mktime(date('h') + 1, null, null, $month, $day, $year) * 1000;

							$flot_datas_visits[] = '[' . $utc . ',' . $visit . ']';
							$flot_datas_views[] = '[' . $utc . ',' . $views[$date] . ']';
						}

						$flot_data_visits = '[' . implode(',', $flot_datas_visits) . ']';
						$flot_data_views = '[' . implode(',', $flot_datas_views) . ']';
					}
					
					/* build visits per hour */
					if(count($avgtimeonsite))
					{
						foreach($avgtimeonsite as $date => $value)
						{
						    $year = substr($date, 0, 4);
						    $month = substr($date, 4, 2);
						    $day = substr($date, 6, 2);
						    
						    $utc = mktime(date('h') + 1, null, null, $month, $day, $year) * 1000;
						    
						    $value = round($value) * 1000;
						    						    
						    $flot_data_avgtimeonsite[] = '[' . $utc . ',' . $value . ']';
						}
						
						$flot_data_avgtimeonsite = '[' . implode(',', $flot_data_avgtimeonsite) . ']';
					}
					
					/* build browsers */
					if( count($browsers))
					{
					    
						$sum = array();
						foreach($browsers as $item => $value) {
							preg_match('/(.+) Version/', $item, $results);
							$browser = $results[1];
							$sum[$browser] = isset($sum[$browser]) ? $sum[$browser] + $value : $value;
						}

						$flot_data_browsers = "[ ";
						foreach($sum as $browser => $value)
						{
						    $flot_data_browsers .= '{ label: "' . $browser . '", data: ' . (int)$value . '},';
						}
						$flot_data_browsers = substr($flot_data_browsers, 0, (strlen($flot_data_browsers)-1));
						$flot_data_browsers = $flot_data_browsers . "]";
					}
					
					/* build operating systems */
					if(count($os))
					{
						$flot_data_os = "[ ";
						foreach($os as $system => $value)
						{
						    $flot_data_os .= '{ label: "' . $system . '", data: ' . (int)$value . '},';
						}
						$flot_data_os = substr($flot_data_os, 0, (strlen($flot_data_os)-1));
						$flot_data_os = $flot_data_os . "]";
					}
											
					$data['analytic_visits'] = $flot_data_visits;
					$data['analytic_views'] = $flot_data_views;
					$data['analytic_avgtimeonsite'] = $flot_data_avgtimeonsite;
					$data['analytic_browsers'] = $flot_data_browsers;
					$data['analytic_systems'] = $flot_data_os;

					// Call the model or library with the method provided and the same arguments
					$this->metrocache->write(array(
						'analytic_visits' => $flot_data_visits, 
						'analytic_views' => $flot_data_views,
						'analytic_avgtimeonsite' => $flot_data_avgtimeonsite,
						'analytic_browsers' => $flot_data_browsers,
						'analytic_systems' => $flot_data_os,
					), 'analytics', 60 * 60 * 6); // 6 hours
				}

				catch (Exception $e)
				{
					$data['messages']['notice'] = sprintf(lang('cp:google_analytics_no_connect'), anchor('admin/settings', lang('cp:nav_settings')));
				}
			}

			// make it available in the theme
			$this->template->set($data);
		}
	}
	
	public function get_rss_feed()
	{
		// Dashboard RSS feed (using SimplePie)
		$this->load->library('simplepie');
		$this->simplepie->set_cache_location($this->config->item('simplepie_cache_dir'));
		$this->simplepie->set_feed_url($this->settings->dashboard_rss);
		$this->simplepie->init();
		$this->simplepie->handle_content_type();

		// Store the feed items
		$data['rss_items'] = $this->simplepie->get_items(0, $this->settings->dashboard_rss_count);
		
		// you know
		$this->template->set($data);
	}
	
	public function get_recent_comments()
	{
		$this->load->library('comments/comments');
		$this->load->model('comments/comment_m');

		$this->load->model('users/user_m');

		$this->lang->load('comments/comments');

		$recent_comments = $this->comment_m->get_recent(5);
		$data['recent_comments'] = $this->comments->process($recent_comments);
		
		$this->template->set($data);
	}
}

/* End of file theme.php */