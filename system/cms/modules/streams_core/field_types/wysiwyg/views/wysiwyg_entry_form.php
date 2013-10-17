<script type="text/javascript">var SITE_URL	= "<?php echo site_url() ?>";</script>

<?php 
	$this->admin_theme = $this->theme_m->get_admin();
	Asset::add_path('admin', $this->admin_theme->web_path.'/');
?>

<script type="text/javascript">metro = {};</script>
<script src="<?php echo Asset::get_filepath_js('admin::ckeditor/ckeditor.js', true) ?>"></script>
<script src="<?php echo Asset::get_filepath_js('admin::ckeditor/adapters/jquery.js', true) ?>"></script>

<script type="text/javascript">

	var instance;

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