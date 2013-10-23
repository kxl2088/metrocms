
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
        <!-- Bootstrap -->
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/bootstrap.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/bootstrap-fileupload.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/bootstrap-datetimepicker.min.js', TRUE); ?>"></script>  
        <!-- Ace Builder -->
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('ace/ace.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('ace/config.js', TRUE); ?>"></script>
        <!-- Additional JS -->
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('fancybox/jquery.fancybox.pack.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.slugify.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.collapsible.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.tablesorter.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.tablecloth.js', TRUE); ?>"></script>   
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.gritter.js', TRUE); ?>"></script>   
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.cookie.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/chosen.jquery.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/bootbox.js', TRUE); ?>"></script> 
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/accordion.nav.js', TRUE); ?>"></script> 
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/respond.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/ios-orientationchange-fix.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/spin.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('spin.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('plugins.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('scripts.js', TRUE); ?>"></script>

<?php echo $template['metadata']; ?>