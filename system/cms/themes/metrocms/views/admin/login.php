<!DOCTYPE HTML>
<html lang="en">
<head>
        <meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
        
        <base href="<?php echo base_url(); ?>"/>
        
        <!-- styles -->
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('bootstrap.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('bootstrap-responsive.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('font-awesome.css', TRUE); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('styles.css', TRUE); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('animate/animate.css', TRUE); ?>">
        <!--[if IE 7]>
                    <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('ie/ie7.css', TRUE); ?>" />
                <![endif]-->
        <!--[if IE 8]>
                    <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('ie/ie8.css', TRUE); ?>" />
                <![endif]-->
        <!--[if IE 9]>
                    <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('ie/ie9.css', TRUE); ?>" />
                <![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('dosis-font.css', TRUE); ?>"> 
        <link rel="stylesheet" type="text/css" href="<?php echo Asset::get_filepath_css('login.css', TRUE); ?>"> 
        
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
        
	<!-- Load up some favicons -->        
        <link rel="shortcut png" href="<?php echo Asset::get_filepath_img('favicon/favicon.png', true); ?>">
	<link rel="shortcut icon" href="<?php echo Asset::get_filepath_img('favicon/favicon.ico', true); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-144-precomposed.png', true); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="114x114"  href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-114-precomposed.png', true); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-72-precomposed.png', true); ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo Asset::get_filepath_img('favicon/apple-touch-icon-57-precomposed.png', true); ?>">
        <!--============javascript===========-->
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/jquery-ui-1.10.1.custom.min.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('jquery/bootstrap.js', TRUE); ?>"></script>
        <script type="text/javascript" src="<?php echo Asset::get_filepath_js('login.js', TRUE); ?>"></script>
   
</head>
<body>
    <div class="layout">
            <!-- Navbar================================================== -->
            <div class="navbar navbar-inverse top-nav">
                    <div class="navbar-inner">
                            <div class="container">
                                <a class="brand" href="<?php echo base_url('admin'); ?>"><img src="<?php echo Asset::get_filepath_img('metrocms_logo_large.png'); ?>" width="103" height="50" alt="MetroCMS" style="width:90px; height: 50px"></a><span class="home-link"><a href="<?php echo base_url(); ?>" class="icon-home"></a></span>
                            </div>
                    </div>
            </div> 
            <div class="container">
                    <?php echo form_open('admin/login', 'class="form-signin"'); ?>

                            <?php $this->load->view('admin/partials/notices') ?>

                            <h3 class="form-signin-heading"><?php echo lang('please_login_title'); ?></h3>
                            <div class="controls input-icon">
                                    <i class=" icon-user-md"></i>
                                    <input type="text" name="email" class="input-block-level" placeholder="<?php echo lang('global:email'); ?>">
                            </div>
                            <div class="controls input-icon">
                                    <i class=" icon-key"></i>
                                    <input type="password" name="password" class="input-block-level" placeholder="<?php echo lang('global:password'); ?>">
                            </div>
                            <label class="checkbox">
                            <input type="checkbox" name="remember" checked> <?php echo lang('user:remember'); ?> </label>
                            <button class="btn btn-inverse btn-block" type="submit"><?php echo lang('login_label'); ?></button>

                    <?php echo form_close(); ?>
                            <div class="copyright">
                                MetroCMS&nbsp;&nbsp;<?php echo CMS_VERSION . '&nbsp;&nbsp;' . CMS_EDITION; ?>
                            </div>
            </div>

    </div>

</body>
</html>