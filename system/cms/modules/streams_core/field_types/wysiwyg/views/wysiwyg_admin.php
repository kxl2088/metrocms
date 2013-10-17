<script src="<?php echo Asset::get_filepath_js('ckeditor/ckeditor.js', true) ?>"></script>
<script src="<?php echo Asset::get_filepath_js('ckeditor/adapters/jquery.js', true) ?>"></script>

<script type="text/javascript">

	var instance;
        var SITE_URL	= "<?php echo site_url() ?>";
        
	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			metro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, true) ?>
				metro.init_ckeditor_maximize();
			};
			metro.init_ckeditor();
			
		});
	})(jQuery);
</script>