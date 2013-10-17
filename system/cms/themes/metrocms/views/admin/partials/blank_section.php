<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
                    <div class="widget-head blue">
	<?php if(isset($template['page_title'])) { echo '<h3>'.lang_label($template['page_title']).'</h3>'; } ?>
                    </div>

                    <div class="widget-container">
                            <div class="content">
		<?php echo $content; ?>
                            </div>
                    </div>
        </div>
    </div>
</div>