<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>

	<base href="<?php echo base_url(); ?>" />
        <meta name="robots" content="noindex, nofollow"/>
        
	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <!-- Styles -->
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

        <!-- Esscencial jQuery -->
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery-ui-1.10.1.custom.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.easing.1.3.js', TRUE); ?>"></script>  

	<?php file_partial('metadata'); ?>
        
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
        
</head>
<body>
	<?php $this->load->view('admin/partials/notices') ?>
	<?php echo $template['body']; ?>
</body>
</html>
