<ul class="metro-sidenav clearfix">
        <?php if((array_key_exists('comments', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('comments')): ?>
        <li>
            <a class="blue-violate tooltip-t" title="<?php echo lang('cp:manage_comments') ?>" href="<?php echo site_url('admin/comments') ?>"><i class="icon-comments"></i><span><?php echo lang('cp:comments'); ?></span></a>
        </li>
        <?php endif; ?>    
        <?php if((array_key_exists('pages', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('pages')): ?>
        <li>
                <a class="dark-yellow  tooltip-t" title="<?php echo lang('cp:manage_pages') ?>" href="<?php echo site_url('admin/pages') ?>"><i class="icon-file-alt"></i><span><?php echo lang('cp:pages'); ?></span></a>
        </li>
        <?php endif ?>
        <?php if((array_key_exists('files', $this->permissions) OR $this->current_user->group == 'admin') AND module_enabled('files')): ?>
        <li>
                <a class="blue tooltip-t" title="<?php echo lang('cp:manage_files') ?>" href="<?php echo site_url('admin/files') ?>"><i class="icon-folder-open"></i><span><?php echo lang('cp:files'); ?></span></a>
        </li>
        <?php endif ?>
        <?php if(array_key_exists('blog', $this->permissions) OR $this->current_user->group == 'admin'): ?>
        <li>
                <a class="magenta tooltip-t" title="<?php echo lang('cp:manage_blog') ?>" href="<?php echo site_url('admin/blog') ?>"><i class="icon-file"></i><span><?php echo lang('cp:blog'); ?></span></a>
        </li>
        <?php endif ?>
        <?php if(array_key_exists('users', $this->permissions) OR $this->current_user->group == 'admin'): ?>
        <li>
                <a class="brown  tooltip-t" title="<?php echo lang('cp:manage_users') ?>" href="<?php echo site_url('admin/users') ?>"><i class="icon-user"></i><span><?php echo lang('cp:users'); ?></span></a>
        </li>
        <?php endif ?>                                                    
        <?php if(array_key_exists('navigation', $this->permissions) OR $this->current_user->group == 'admin'): ?>
        <li>
                <a class="green tooltip-t" title="<?php echo lang('cp:manage_navigation') ?>" href="<?php echo site_url('admin/navigation') ?>"><i class="icon-globe"></i><span><?php echo lang('cp:navigation'); ?></span></a>
        </li>
        <?php endif ?>
        <?php
        if( $this->modules_extra ):
            foreach ($this->modules_extra as $module):
                if(array_key_exists($module['slug'], $this->permissions) OR $this->current_user->group == 'admin'):
                    if( (isset($module['dashboard']) AND is_array($module['dashboard'])) AND array_key_exists(CURRENT_LANGUAGE, $module['dashboard']) ):
                        echo "\n\t<li>\n";
                        if(isset($module['name']) AND isset($module['dashboard'][CURRENT_LANGUAGE]['class']) AND isset($module['dashboard'][CURRENT_LANGUAGE]['icon'])):
                            echo "\t\t<a class=\"". $module['dashboard'][CURRENT_LANGUAGE]['class'] . ($module['dashboard'][CURRENT_LANGUAGE]['title'] ? ' tooltip-t' : '') ."\" title=\"". $module['dashboard'][CURRENT_LANGUAGE]['title'] ."\" href=\"". site_url('admin/' . $module['slug']) ."\"><i class=\"". $module['dashboard'][CURRENT_LANGUAGE]['icon'] ."\"></i><span>". $module['name'] ."</span></a>";
                        endif;
                        echo "\n\t</li>";
                    endif;            
                endif;
            endforeach;    
        endif;
        ?>
</ul>