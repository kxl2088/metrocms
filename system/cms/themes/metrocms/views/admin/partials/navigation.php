<div class="nav-collapse">
        <ul class="nav">
		<?php 

		// Display the menu items.
		// We have already vetted them for permissions
		// in the Admin_Controller, so we can just
		// display them now.
		foreach ($menu_items as $key => $menu_item)
		{
			if (is_array($menu_item))
			{
				echo '<li class="dropdown"><a href="'.current_url().'#" data-toggle="dropdown" class="dropdown-toggle">'.lang_label($key).'<b class="icon-angle-down"></b></a><div class="dropdown-menu"><ul>';

				foreach ($menu_item as $lang_key => $uri)
				{
                                    if( eregi('phpinfo', $uri) )
                                    {
                                        echo '<li><a href="'.site_url($uri).'" class="modal-ajax">'.lang_label($lang_key).'</a></li>';
                                    }
                                    else if( eregi('info', $uri) )
                                    {
                                        echo '<li><a href="'.site_url($uri).'" class="modal-ajax">'.lang_label($lang_key).'</a></li>';
                                    }
                                    else if( eregi('site-url', $uri) )
                                    {
                                        echo '<li><a href="'.site_url().'" class="open-popup" target="_blank">'.lang_label($lang_key).'</a></li>';
                                    }
                                    else
                                    {
					echo '<li><a href="'.site_url($uri).'">'.lang_label($lang_key).'</a></li>';
                                    }

				}

				echo '</ul></div></li>';

			}
			elseif (is_array($menu_item) and count($menu_item) == 1)
			{
				foreach ($menu_item as $lang_key => $uri)
				{
					echo '<li><a href="'.site_url($menu_item).'">'.lang_label($lang_key).'</a></li>';
				}
			}
			elseif (is_string($menu_item))
			{
				echo '<li><a href="'.site_url($menu_item).'">'.lang_label($key).'</a></li>';
			}

		}
	
		?>
        </ul>
</div>