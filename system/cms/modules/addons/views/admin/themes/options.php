<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('addons:themes:theme_label').' '.lang('addons:themes:options') ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <?php if ($options_array): ?>

                                    <div class="padding-top">
                                            <?php echo form_open('admin/addons/themes/options/'.$slug, 'class="form_inputs options-form form-horizontal"');?>
                                                    <?php echo form_hidden('slug', $slug) ?>

                                                    <?php foreach($options_array as $option): ?>
                                                            <div id="<?php echo $option->slug ?>" class="control-group">
                                                                    <label for="<?php echo $option->slug ?>" class="control-label">
                                                                            <?php echo $option->title ?>
                                                                            <br /><small><?php echo $option->description ?></small>
                                                                    </label>
                                                                    <div class="controls <?php echo 'type-'.$option->type ?>">
                                                                            <?php echo $controller->form_control($option) ?>
                                                                    </div>
                                                            </div>
                                                    <?php endforeach ?>
                                                           
                                                    <div class="buttons">
                                                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel', 're-index') )) ?>
                                                    </div>

                                            <?php echo form_close() ?>
                                    </div>

                            <?php endif ?>
                    </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	(function($) {
		$(function() {
			$('.colour-picker').miniColors({
				letterCase: 'uppercase',
			});
		});
	})(jQuery);
</script>