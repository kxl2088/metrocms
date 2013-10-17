<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
<?php if ($this->method == 'edit'): ?>
            <div class="widget-head blue">
                <h3><?php echo sprintf(lang('groups:edit_title'), $group->name) ?></h3>
            </div>
<?php else: ?>
            <div class="widget-head blue">
                <h3><?php echo lang('groups:add_title') ?></h3>
            </div>
<?php endif ?>

            <div class="widget-container">
                    <div class="content">
                            <?php echo form_open(uri_string(), 'class="crud form-horizontal"') ?>

                            <div class="form_inputs">

                                            <div class="control-group">
                                                    <label class="control-label" for="description"><?php echo lang('groups:name');?> <span>*</span></label>
                                                    <div class="input controls"><?php echo form_input('description', $group->description);?></div>
                                            </div>

                                            <div class="control-group">
                                                    <label class="control-label" for="name"><?php echo lang('groups:short_name');?> <span>*</span></label>

                                                    <div class="input controls">

                                                    <?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
                                                    <?php echo form_input('name', $group->name);?>

                                                    <?php else: ?>
                                                    <p><?php echo $group->name ?></p>
                                                    <?php endif ?>

                                                    </div>
                                            </div>
                            </div>

                            <div class="buttons float-right padding-top">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                            </div>

                            <?php echo form_close();?>
                    </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="description"]').keyup($.debounce(300, function(){

			var slug = $('input[name="name"]');

			$.post(SITE_URL + 'ajax/url_title', { title : $(this).val() }, function(new_slug){
				slug.val( new_slug );
			});
		}));
	});
</script>