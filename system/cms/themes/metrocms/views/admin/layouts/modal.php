<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->
<head>
	<meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>

	<base href="<?php echo base_url(); ?>" />
        <meta name="robots" content="noindex, nofollow"/>
        
	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <!-- styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('bootstrap.min.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('bootstrap-responsive.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('font-awesome.css', TRUE); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('tablecloth.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('styles.css', TRUE); ?>">
        <!--[if IE 7]>
                    <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('ie/ie7.css', TRUE); ?>" />
                <![endif]-->
        <!--[if IE 8]>
                    <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('ie/ie8.css', TRUE); ?>" />
                <![endif]-->
        <!--[if IE 9]>
                    <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('ie/ie9.css', TRUE); ?>" />
                <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('aristo-ui.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('dosis-font.css', TRUE); ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('animate/animate.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('custom.css', TRUE); ?>">
	<!-- End CSS-->

	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
        
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/jquery-ui-1.10.1.custom.min.js', TRUE); ?>"></script>        
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/bootstrap.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/bootstrap-fileupload.min.js', TRUE); ?>"></script>  
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/bootstrap-colorpicker.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/bootstrap-datetimepicker.min.js', TRUE); ?>"></script>       
        <script type="text/javascript" src="<? echo Asset::get_filepath_js('jquery/bootstrap-tab-ajax.js', TRUE); ?>"></script>  
	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>
        
</head>
<body>
	<?php $this->load->view('admin/partials/notices') ?>
	<?php echo $template['body']; ?>
</body>
</html>
