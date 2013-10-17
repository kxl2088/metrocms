<?php if ( $theme_options->metrocms_site_stats == 'yes' ) : ?>
        <div class="row-fluid ">            
                <div class="span12">
                    <input type="hidden" name="shortcut[]" value="metrocms_site_stats">
                        <div class="board-widgets">
                                <div class="board-widgets-head clearfix">
                                        <h4 class="pull-left"><?php echo lang('cp:site_stats'); ?></h4>
                                        <a class="widget-settings toggle tooltip-l" title="<?php echo lang('global:togle-this-element'); ?>"><i class="icon-move"></i></a>
                                </div>
                                <div class="board-widgets-content">
                                        <div class="row-fluid">
                                                <?php if((array_key_exists('comments', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('comments')): ?>
                                                <div class="span3">
                                                        <div class="board-widgets orange small-widget">
                                                                <a href="<?php echo site_url('admin/comments'); ?>"><span class="widget-stat"><?php echo $total_comments ? $total_comments : 0; ?></span><span class="widget-icon icon-comments"></span><span class="widget-label"><?php echo lang('cp:comments'); ?></span></a>
                                                        </div>
                                                </div>
                                                <?php endif; ?>
                                                <?php if(array_key_exists('users', $this->permissions) OR $this->current_user->group == 'admin'): ?>
                                                <div class="span3">
                                                        <div class="board-widgets bondi-blue small-widget">
                                                                <a href="<?php echo site_url('admin/users'); ?>"><span class="widget-stat"><?php echo $total_users ? $total_users : 0; ?></span><span class="widget-icon icon-user"></span><span class="widget-label"><?php echo lang('cp:users'); ?></span></a>
                                                        </div>
                                                </div>
                                                <?php endif; ?>
                                                <?php if((array_key_exists('files', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('files')): ?>
                                                <div class="span3">
                                                        <div class="board-widgets green small-widget">
                                                                <a href="<?php echo site_url('admin/files'); ?>"><span class="widget-stat"><?php echo $total_files ? $total_files : 0; ?></span><span class="widget-icon icon-folder-open"></span><span class="widget-label"><?php echo lang('cp:files'); ?></span></a>
                                                        </div>
                                                </div>
                                                <?php endif; ?>
                                                <?php if((array_key_exists('pages', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('pages')): ?>
                                                <div class="span3">
                                                        <div class="board-widgets brown small-widget">
                                                                <a href="<?php echo site_url('admin/pages'); ?>"><span class="widget-stat"><?php echo $total_pages ? $total_pages : 0; ?></span><span class="widget-icon icon-file"></span><span class="widget-label"><?php echo lang('cp:pages'); ?></span></a>
                                                        </div>
                                                </div>
                                                <?php endif; ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
<?php endif; ?>
