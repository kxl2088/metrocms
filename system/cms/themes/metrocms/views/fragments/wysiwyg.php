<script type="text/javascript" src="<?php echo BASE_URL?>system/cms/themes/metrocms/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL?>system/cms/themes/metrocms/js/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			metro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, TRUE); ?>
				metro.init_ckeditor_maximize();
			};
			metro.init_ckeditor();

		});
	})(jQuery);
</script>