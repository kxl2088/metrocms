
        <script type="text/javascript">
                metro = { 'lang' : {} };
                var APPPATH_URI					= "<?php echo APPPATH_URI;?>";
                var SITE_URL					= "<?php echo rtrim(site_url(), '/').'/';?>";
                var BASE_URL					= "<?php echo BASE_URL;?>";
                var BASE_URI					= "<?php echo BASE_URI;?>";
                var ACCESS_LEVEL 				= "<?php echo (($this->uri->segment(1) == 'admin' || $this->current_user->group_id = 1) ? 1 : 0);?>";
                var UPLOAD_PATH					= "<?php echo UPLOAD_PATH;?>";
                var DEFAULT_TITLE				= "<?php echo addslashes($this->settings->site_name); ?>";
                var CURRENT_LANGUAGE				= "<?php echo CURRENT_LANGUAGE;?>";
                var CURRENT_LOGGED_IN				= "<?php echo $this->current_user->id;?>";
                metro.admin_theme_url                            = "<?php echo BASE_URL . $this->admin_theme->path; ?>";
                metro.current_app_path				= "<?php echo $this->module_details['path']; ?>";	
                metro.app_path                                   = "<?php echo APPPATH; ?>";
                metro.addons_path				= "<?php echo ADDONPATH; ?>";
                metro.shared_addons_path				= "<?php echo SHARED_ADDONPATH; ?>";
                metro.apppath_uri				= "<?php echo APPPATH_URI; ?>";
                metro.base_uri					= "<?php echo BASE_URI; ?>";
                metro.lang.remove				= "<?php echo lang('global:remove'); ?>";
                metro.lang.dialog_message                        = "<?php echo lang('global:dialog:delete_message'); ?>";
                metro.csrf_cookie_name                           = "<?php echo config_item('cookie_prefix').config_item('csrf_cookie_name'); ?>";
        </script>
        
        <!--============ stylesheets ============-->
        <link rel="stylesheet" type="text/css" href="<? echo Asset::get_filepath_css('chosen.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<? echo Asset::get_filepath_css('jquery/codemirror.css', TRUE); ?>">
        <!-- =========== FancyBox =============== -->
        <link rel="stylesheet" type="text/css" href="<? echo Asset::get_filepath_css('fancybox/jquery.fancybox.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<? echo Asset::get_filepath_css('fancybox/jquery.fancybox-thumbs.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<? echo Asset::get_filepath_css('fancybox/jquery.fancybox-buttons.css', TRUE); ?>">
        
        <!--============ javascript ===========-->
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery.mousewheel.min.js', TRUE); ?>"></script>           
        <!-- =========== FancyBox =============-->
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('fancybox/jquery.fancybox.pack.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('fancybox/jquery.fancybox-buttons.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('fancybox/jquery.fancybox-media.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('fancybox/jquery.fancybox-thumbs.js', TRUE); ?>"></script>  
        <!-- =========== Misc =============-->
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery.tablecloth.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery.slugify.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery.collapsible.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery.cookie.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('codemirror/codemirror.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('codemirror/mode/css/css.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('codemirror/mode/htmlmixed/htmlmixed.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('codemirror/mode/javascript/javascript.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('codemirror/mode/markdown/markdown.js', TRUE); ?>"></script>      
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/chosen.jquery.js', TRUE); ?>"></script>    
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/accordion.nav.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/bootbox.js', TRUE); ?>"></script> 
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/respond.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/ios-orientationchange-fix.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('plugins.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('scripts.js', TRUE); ?>"></script>
  
        <!--[if lt IE 9]>
        <script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

<?php echo $template['metadata']; ?>