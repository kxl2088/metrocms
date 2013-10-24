<ul class="metro-sidenav clearfix">
        <?php
        if( $this->modules_extra ){
            foreach ($this->modules_extra as $module){
                echo "\n\t<li>\n";
                if(array_key_exists($module['slug'], $this->permissions) OR $this->current_user->group == 'admin'){
                    if( (isset($module['dashboard']) AND is_array($module['dashboard'])) AND array_key_exists(CURRENT_LANGUAGE, $module['dashboard']) ){                        
                        if(isset($module['name']) AND isset($module['dashboard'][CURRENT_LANGUAGE]['class']) AND isset($module['dashboard'][CURRENT_LANGUAGE]['icon'])){
                            $title = $module['dashboard'][CURRENT_LANGUAGE]['title'];
                            if(substr($title, 0, 4) == 'lang')
                            {
                                $title = lang(substr($title, 5));
                            }                            
                            echo "\t\t<a class=\"". $module['dashboard'][CURRENT_LANGUAGE]['class'] . ($module['dashboard'][CURRENT_LANGUAGE]['title'] ? ' tooltip-t' : '') ."\" title=\"". $title ."\" href=\"". site_url('admin/' . $module['slug']) ."\"><i class=\"". $module['dashboard'][CURRENT_LANGUAGE]['icon'] ."\"></i><span>". $module['name'] ."</span></a>";                       
                        }
                        else
                        {
                            if(isset($module['name']) AND isset($module['dashboard']['br']['class']) AND isset($module['dashboard']['br']['icon'])){
                                $title = $module['dashboard']['br']['title'];
                                if(substr($title, 0, 4) == 'lang')
                                {
                                    $title = lang(substr($title, 5));
                                }                            
                                echo "\t\t<a class=\"". $module['dashboard']['br']['class'] . ($module['dashboard']['br']['title'] ? ' tooltip-t' : '') ."\" title=\"". $title ."\" href=\"". site_url('admin/' . $module['slug']) ."\"><i class=\"". $module['dashboard']['br']['icon'] ."\"></i><span>". $module['name'] ."</span></a>";                       
                            }
                        }
                    }
                }
            }
        }
        ?>
</ul>