<!doctype html>

<head lang="en">
	<meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
	<title>MetroCMS Instalador</title>

        <!-- styles -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/jquery.gritter.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css">

        <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet">
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ie/ie7.css" />
        <![endif]-->
        <!--[if IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ie/ie8.css" />
        <![endif]-->
        <!--[if IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/ie/ie9.css" />
        <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'> 
        <!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->
                
        <!--fav and touch icons -->
        <link rel="shortcut png" href="<?php echo base_url(); ?>assets/images/favicon/favicon.png">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/favicon/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/favicon/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/favicon/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/favicon/apple-touch-icon-57-precomposed.png">

	<script type="text/javascript">
		var base_url = '<?php echo base_url(); ?>',
				pass_match = ['<?php echo lang('installer.passwords_match'); ?>','<?php echo lang('installer.passwords_dont_match'); ?>'];
	</script>
        <!--============ javascript ===========-->
        <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.1.custom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.gritter.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ios-orientationchange-fix.js"></script>      
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.complexify.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/installer.js"></script>
        
</head>

<body>
<div class="layout">
	<!-- Navbar================================================== -->
	<div class="navbar navbar-inverse top-nav">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/metrocms_logo_large.png" style="width: 103px; height: 50px" alt="MetroCMS"></a>
				
				<div class="btn-toolbar pull-right notification-nav">
					<div class="btn-group language_nav">
						<ul id="lang">
                                                    <?php foreach($language_nav as $lang => $info):?>
                                                    <li>
                                                            <a href="<?php echo $info['action_url']; ?>" title="<?php echo $info['name']; ?>">
                                                                    <img src="<?php echo $info['image_url']; ?>" alt="<?php echo $info['name']; ?>"/>
                                                            </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="main-wrapper">
		<div class="container">
			<div class="row-fluid ">
				<div class="span12">
					<div class="primary-head">
						<h3 class="page-header">Instalação MetroCMS</h3>						
					</div>
				</div>                                
			</div>

                        <!-- Message type 1 (flashdata) -->
			<?php if($this->session->flashdata('message')): ?>
                                <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <i class="icon-minus-sign"></i> 
                                        <?php if($this->session->flashdata('message')) { echo $this->session->flashdata('message'); }; ?>
                                </div>
			<?php endif; ?>

			<!-- Message type 2 (validation errors) -->
			<?php if ( validation_errors() ): ?>
                                <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <i class="icon-minus-sign"></i>
                                        <?php echo validation_errors('<p>', '</p>'); ?>
                                </div>
			<?php endif; ?>

			<!-- Message type 3 (data for the same page load) -->
			<?php if($this->messages): ?>
				<?php foreach (array_keys($this->messages) as $type): ?>
                                        <div class="alert alert-<?php echo ($type) ? $type : 'success'; ?>">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <i class="icon-<?php echo ($type == 'error') ? 'minus' : 'ok'; ?>-sign"></i>       
						<?php foreach ($this->messages as $key => $message): ?>
							<?php if ($key === $type): ?>
								<p><?php echo $message; ?></p>
							<?php endif; ?>
						<?php endforeach; ?>
                                        </div>
				<?php endforeach; ?>
			<?php endif; ?>
<div class="row-fluid">
        <div class="span12">
                <div class="stepy-widget">
                        <div class="widget-head clearfix blue">
                                <div id="top_tabby" class="pull-right">
                                    <ul id="stepy_form-titles" class="stepy-titles">
                                        <li id="stepy_form-title-0" class="<?php echo $this->uri->segment(2, '') == '' ? 'current-step' : 'no-current' ?>">
                                            <div><?php echo anchor('', lang('intro')); ?></div></li>
                                        <li id="stepy_form-title-1" class="<?php echo $this->uri->segment(2, '') == 'step_1' ? 'current-step' : '' ?>">
                                            <div><?php echo lang('step1'); ?></div>
                                        </li>
                                        <li id="stepy_form-title-2" class="<?php echo $this->uri->segment(2, '') == 'step_2' ? 'current-step' : '' ?>">
                                            <div><?php echo lang('step2'); ?></div></li>
                                        <li id="stepy_form-title-3" class="<?php echo $this->uri->segment(2, '') == 'step_3' ? 'current-step' : '' ?>">
                                            <div><?php echo lang('step3'); ?></div>
                                        </li>
                                        <li id="stepy_form-title-4" class="<?php echo $this->uri->segment(2, '') == 'step_4' ? 'current-step' : '' ?>">
                                            <div><?php echo lang('step4'); ?></div>
                                        </li>
                                        <li id="stepy_form-title-5" class="<?php echo $this->uri->segment(2, '') == 'complete' ? 'current-step' : '' ?>">
                                            <div><?php echo lang('final'); ?></div>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                                        <?php echo $page_output . PHP_EOL; ?>    
                </div>
        </div>
</div>
			
		</div>
	</div>
	<div class="scroll-top">
		<a href="#" class="tip-top" title="Go Top"><i class="icon-double-angle-up"></i></a>
	</div>
        <div class="copyright">
            <p class="credits">Copyright &copy; <?php echo date('Y'); ?> | MetroCMS &nbsp; <span>Versão <?php echo CMS_VERSION . '&nbsp;&nbsp;' . CMS_EDITION; ?> &nbsp; | Renderizado em {elapsed_time} secs. usando {memory_usage}</span></p>
                
	</div>
</div>
</body>
</html>