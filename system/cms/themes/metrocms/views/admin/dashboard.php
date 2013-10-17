<!-- Add an extra div to allow the elements within it to be sortable! -->
<div id="sortable">

	<!-- Dashboard Widgets -->
	{{ widgets:area slug="dashboard" }}
        
        <?php if ($session_shortcuts): ?>
            <?php foreach ($session_shortcuts as $shortcut_view): ?>    
                <?php if ($shortcut_view): ?>
                    <?php echo $this->load->view('admin/partials/shortcuts/'.$shortcut_view) ?>  
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
</div>
<!-- End sortable div -->
<script type="text/javascript">
        (function ($) {                
                $('#remove_installer_directory').on('click', function (e) {
                        e.preventDefault();
                        var $parent = $(this).parent();
                        $.get(SITE_URL + 'admin/remove_installer_directory', function (data) {
                                $parent.removeClass('warning').addClass('alert-' + data.status).html('<button type="button" class="close" data-dismiss="alert">×</button><i class="icon-exclamation-sign"></i>'+ data.message);
                        });
                });
        })(jQuery);
</script>