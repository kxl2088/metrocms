<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('blacklist:' . $this->method); ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
    <?php echo form_open_multipart($this->uri->uri_string(), 'class="crud form-horizontal"'); ?>
        <div class="form_inputs">

                 <div class="control-group">
                    <label for="name" class="control-label"><?php echo lang('blacklist:ip'); ?> <span>*</span></label>
                    <div class="input controls"><?php echo form_input('ip', set_value('ip', $ip), 'class="width-15"'); ?></div>
                 </div>
                 <div class="control-group">
                    <label for="name" class="control-label"><?php echo lang('blacklist:reason'); ?> <span>*</span></label>
                    <div class="input controls"><?php echo form_textarea('reason', set_value('reason', $reason), 'class="width-15"'); ?></div>
                 </div>

        </div>

        <div class="buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
        </div>
    <?php echo form_close(); ?>
                    </div>
            </div>
        </div>
    </div>
</div>