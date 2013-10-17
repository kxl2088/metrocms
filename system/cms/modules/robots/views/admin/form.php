<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('robots:title:overview'); ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                    <?php echo form_open_multipart($this->uri->uri_string(), 'class="crud form-horizontal"'); ?>

                            <div class="form_inputs">

                                    <div class="control-group">
                                            <label class="control-label" for="txt"><?php echo lang('robots:label:txt'); ?> <span>*</span></label>
                                            <div class="input controls"><?php echo form_textarea('txt', set_value('txt', $txt), 'class="width-full"'); ?></div>
                                    </div>

                            </div>

                            <div class="buttons">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
                            </div>

                    <?php echo form_close(); ?>
                    </div>
            </div>
        </div>
    </div>
</div>