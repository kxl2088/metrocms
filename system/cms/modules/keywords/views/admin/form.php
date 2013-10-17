<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <?php if ($this->method == 'edit'): ?>
                    <div class="widget-head blue">
                    <h3><?php echo sprintf(lang('keywords:edit_title'), $keyword->name) ?></h3>
                    </div>
            <?php else: ?>
                    <div class="widget-head blue">
                    <h3><?php echo lang('keywords:add_title') ?></h3>
                    </div>
            <?php endif ?>

            <div class="widget-container">
                <div class="content">

                <?php echo form_open(uri_string(), 'class="crud form-horizontal"') ?>

                <div class="form_inputs">

                                <div class="control-group">
                                        <label class="control-label" for="name"><?php echo lang('keywords:name');?> <span>*</span></label>
                                        <div class="input controls"><?php echo form_input('name', $keyword->name);?></div>
                                </div>

                </div>

                        <div class="buttons">
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
		$('form input[name="name"]').keyup($.debounce(100, function(){
			$(this).val( this.value.toLowerCase().replace(',', '') );
		}));
	});
</script>