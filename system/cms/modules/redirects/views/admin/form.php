<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
            <?php if($this->method == 'add'): ?>
                    <h3><?php echo lang('redirects:add_title');?></h3>
            <?php else: ?>
                    <h3><?php echo lang('redirects:edit_title');?></h3>
            <?php endif ?>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <?php echo form_open(uri_string(), 'class="crud form-horizontal"') ?>
                                    <div class="form_inputs">
                                        <div class="control-group">
                                                <label class="control-label" for="type"><?php echo lang('redirects:type');?></label>
                                                <div class="inputs controls">
                                                    <?php echo form_dropdown('type', array('301' => lang('redirects:301'), '302' => lang('redirects:302')), !empty($redirect['type']) ? $redirect['type'] : '302');?>
                                                </div>
                                        </div>

                                        <div class="control-group">
                                                <label class="control-label" for="from"><?php echo lang('redirects:from');?></label>
                                                <div class="inputs controls">
                                                    <?php echo form_input('from', str_replace('%', '*', $redirect['from']));?>
                                                </div>
                                        </div>


                                        <div class="control-group">
                                                <label class="control-label" for="to"><?php echo lang('redirects:to');?></label>
                                                <div class="inputs controls">
                                                    <?php echo form_input('to', $redirect['to']);?>
                                                </div>
                                        </div>
                                    </div>


                                    <div class="buttons">
                                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                                    </div>
                            <?php echo form_close() ?>
                    </div>
            </div>
        </div>
    </div>
</div>