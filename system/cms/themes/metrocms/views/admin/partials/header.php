                <noscript>
                        <span>MetroCMS requires that JavaScript be turned on for many of the functions to work correctly. Please turn JavaScript on and reload the page.</span>
                </noscript>

                <!-- Navbar
            ================================================== -->
                <div class="navbar navbar-inverse navbar-static-top navbar-static top-nav">
                        <div class="navbar-inner">
                                <div class="container-fluid">
                                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                                      <span class="icon-bar"></span>
                                      <span class="icon-bar"></span>
                                      <span class="icon-bar"></span>
                                    </button>
                                    <?php echo anchor('admin', Asset::img('metrocms_logo_large.png', 'MetroCMS'), ' class="brand"') ?>    
                                    <?php file_partial('navigation') ?>                                   
                                </div>
                        </div>
                </div>
                <div class="leftbar leftbar-close clearfix">
                    <div class="admin-info clearfix">
                            <div class="admin-thumb">
                                    <?php echo file_path($this->current_user->avatar) ? img('files/thumb/' . $this->current_user->avatar . '/50/50/fit') : '<i class="icon-user"></i>'; ?>
                            </div>
                            <div class="admin-meta">
                                    <ul>
                                            <li class="admin-username"><?php echo $this->current_user->display_name; ?></li>
                                            <li>
                                                <a href="<?php echo site_url('admin/profile/edit'); ?>"><?php echo lang('edit_profile_label'); ?></a>
                                            </li>                                        
                                            <li>
                                                <a href="<?php echo site_url('admin/profile'); ?>"><?php echo lang('global:my_profile'); ?> </a>  
                                            <a href="<?php echo site_url('admin/logout'); ?>"><i class="icon-lock"></i> <?php echo lang('logout_label'); ?></a>
                                            </li>
                                    </ul>
                            </div>
                    </div>
                    <div class="left-nav clearfix">
                            <div class="left-primary-nav">
                                    <ul id="myTab">
                                            <li class="<?php if(!$module_details['slug'] || empty($module_details['sections'])): ?>active<?php endif;?>"><a href="#main" class="icon-desktop" title="<?php echo lang('global:dashboard'); ?>"></a></li>					    
                                            <?php if ( ! empty($module_details['sections'])): ?>
					    <?php 
						if($module_details['extra'])
						{
						    $module_details['extra'] = unserialize($module_details['extra']);
												
						    if(is_array($module_details['extra']))
						    {	
							if(array_key_exists('sections_icon', $module_details['extra']))
							{
							    $icons = get_falgun_icons(); 
							    if(array_key_exists($module_details['extra']['sections_icon'], $icons)){
								$module_details['sections_icon'] = $module_details['extra']['sections_icon'];
							    }
							}
						    }
						}
					    ?>
                                            <li class="<?php if($module_details['slug'] && !empty($module_details['sections'])): ?>active<?php endif;?>"><a href="#sections-<?php echo $module_details['slug']; ?>" class="<?php if(isset($module_details['sections_icon'])): echo $module_details['sections_icon']; else: echo 'icon-th-large'; endif;?>" title="<?php echo $module_details['name']; ?>"></a></li>
                                            <?php endif; ?>
                                    </ul>
                            </div>
                            <div class="responsive-leftbar">
                                    <i class="icon-list"></i>
                            </div>

                            <div class="left-secondary-nav tab-content">
                                    <div class="tab-pane <?php if(!$module_details['slug'] || empty($module_details['sections'])): ?>active<?php endif;?>" id="main">
                                            <h4 class="side-head"><?php echo lang('global:dashboard'); ?></h4>
                                            <div class="search-box">
                                                <form class="topbar-search">
                                                    <div class="input-append input-icon ui-widget">                                    
                                                                <input type="text" class="search-query search-input" id="nav-search" placeholder="<?php echo lang("cp:search"); ?>">
                                                                <i class="icon-search"></i>
                                                    </div>
                                                </form>
                                            </div>                                              
                                            <!-- Quick Links -->
<?php file_partial('dashboard') ?>  
                                            <!-- /Quick Links -->
                                            <?php if($cpanel_stats): ?>
                                            <div class="side-widget">
                                                    <div class="board-widgets light-blue">
                                                            <div class="board-widgets-head clearfix">
                                                                    <h4 class="pull-left"><?php echo lang('cp:cpanel.bandwidth_usage'); ?></h4>
                                                                    <a href="#" class="widget-settings"><i class="icon-cloud"></i></a>
                                                            </div>
                                                            <div class="board-widgets-content">
                                                                    <div class="progress progress-striped active min progress-info">
                                                                            <div class="bar" style="width: <?php echo $cpanel_stats->bandwidthusage->percent; ?>%;">
                                                                            </div>
                                                                    </div>
                                                                    <div class="stat-text progress-stat">
                                                                            <i class="progres-percent"><?php echo $cpanel_stats->bandwidthusage->percent; ?>%</i> <?php echo $cpanel_stats->bandwidthusage->count . ' ' . $cpanel_stats->bandwidthusage->units; ?> / <?php echo $cpanel_stats->bandwidthusage->max == 'unlimited' ? lang('cp:cpanel.unlimited') : $cpanel_stats->bandwidthusage->max; ?>
                                                                    </div>
                                                            </div>
                                                    </div>
                                                    <div class="board-widgets light-blue ">
                                                            <div class="board-widgets-head clearfix">
                                                                    <h4 class="pull-left"><?php echo lang('cp:cpanel.disk_usage'); ?></h4>
                                                                    <a href="#" class="widget-settings"><i class="icon-hdd"></i></a>
                                                            </div>
                                                            <div class="board-widgets-content">
                                                                    <div class="progress progress-striped active min progress-success">
                                                                            <div class="bar" style="width: <?php echo $cpanel_stats->diskusage->percent; ?>%;">
                                                                            </div>
                                                                    </div>
                                                                    <div class="stat-text progress-stat">
                                                                            <i class="progres-percent"><?php echo $cpanel_stats->diskusage->percent; ?>%</i> <?php echo $cpanel_stats->diskusage->count . ' ' . $cpanel_stats->diskusage->units; ?> / <?php echo $cpanel_stats->diskusage->max == 'unlimited' ? lang('cp:cpanel.unlimited') : $cpanel_stats->diskusage->max; ?>
                                                                    </div>
                                                            </div>
                                                    </div>                                                    
                                            </div>
                                            <?php endif; ?>
                                    </div>
                                    <?php if ( ! empty($module_details['sections'])): ?>
                                    <div class="tab-pane <?php if($module_details['slug'] && !empty($module_details['sections'])): ?>active<?php endif;?>" id="sections-<?php echo $module_details['slug']; ?>">
                                            <h4 class="side-head"><?php echo $module_details['name']; ?></h4>
                                            <ul id="nav" class="accordion-nav">

                                                    <?php file_partial('sections'); ?>

                                            </ul>
                                    </div>
                                    <?php endif; ?>
                            </div>
                    </div>
                </div>