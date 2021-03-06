<!doctype html>
<head lang="en">
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>

	<base href="<?php echo base_url(); ?>" />
        <meta name="robots" content="noindex, nofollow"/>
        
	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <!-- styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('bootstrap.min.css', TRUE); ?>">        
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('bootstrap-responsive.min.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('jquery.gritter.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('font-awesome.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('tablecloth.css', TRUE); ?>">        
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('aristo-ui.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('dosis-font.css', TRUE); ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('animate.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('chosen.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('fancybox/jquery.fancybox.css', TRUE); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('styles.css', TRUE); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css($theme_options->default_theme, TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('custom.css', TRUE); ?>">
	<!-- End CSS-->

	<!-- Load up some favicons -->        
        <link rel="shortcut png" href="<?php echo Asset::get_filepath_img('favicon/favicon.png', true); ?>">
	<link rel="shortcut icon" href="<?php echo Asset::get_filepath_img('favicon/favicon.ico', true); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-144-precomposed.png', true); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="114x114"  href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-114-precomposed.png', true); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-72-precomposed.png', true); ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-57-precomposed.png', true); ?>">
        
        <!-- Esscencial jQuery -->
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.js', TRUE); ?>"></script>        
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery-ui-1.10.1.custom.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.easing.1.3.js', TRUE); ?>"></script>    
	<?php if ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->metrocms_analytics_graph == 'yes'): ?>
	<!-- Google Chart -->
	<script src="https://www.google.com/jsapi"></script>
	<?php endif; ?>
	<?php file_partial('metadata'); ?>
        
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
</head>

<body>
    <div id="loading"><div id="loading_anim"></div></div>
    <div class="layout">
	<div id="container">
			<?php file_partial('header'); ?>
                    
                        <div class="main-wrapper">
                            <div class="container-fluid">
                                <div class="row-fluid ">
                                        <div class="span12">
                                                <div class="primary-head">
                                                        <h3 class="page-header"><?php echo $module_details['name'] ? anchor('admin/'.$module_details['slug'], $module_details['name']) : lang('global:dashboard') ?><small>
				<?php if ( $this->uri->segment(2) ) { echo '<span class="divider">&nbsp; | &nbsp;</span>'; } ?>
				<?php echo $module_details['description'] ? $module_details['description'] : '' ?>
				<?php if ( $this->uri->segment(2) ) { echo '<span class="divider">&nbsp; | &nbsp;</span>'; } ?>
				<?php if($module_details['slug']): ?>
				<?php echo anchor('admin/help/'.$module_details['slug'], lang('help_label'), array('title' => $module_details['name'].' | '.lang('help_label'), 'class' => 'modal-ajax')); ?>
				<?php endif; ?></small></h3>  
			           
                                                <?php file_partial('shortcuts') ?>
                                                </div>  
                                        </div>
                                </div>
                                <div id="content-body">
                                        <?php file_partial('notices'); ?>
                                        <?php echo $template['body']; ?>
                                </div>
                            </div>
                        </div>                        
        </div>
        <div class="scroll-top">
		<a href="#" class="tip-top" title="<?php echo lang('cp:scroll_to_top'); ?>"><i class="icon-double-angle-up"></i></a>
	</div> 
        <div class="copyright">
            <p class="credits"><?php echo sprintf_lang('global:dashboard_copyright', array(date('Y'), CMS_VERSION, CMS_EDITION, "{elapsed_time}", "{memory_usage}")); ?></p>
		<div id="lang">
		    <form action="<?php echo current_url(); ?>" id="change_language" method="get">		    
			<select class="skip" name="lang" onchange="this.form.submit();">
				<?php foreach(languages() as $key): ?>
					<option value="<?php echo $key['code']; ?>" <?php echo CURRENT_LANGUAGE == $key['code'] ? ' selected="selected" ' : ''; ?>><?php echo $key['name']; ?></option>
				<?php endforeach; ?>
			</select>		    
		    </form>
		</div>
	</div>	
        
</div>
</body>
</html>