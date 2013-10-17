<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <?php if ($this->method == 'create'): ?>
                    <h3><?php echo lang('variables:create_title');?></h3>
                    <?php else: ?>
                    <h3><?php echo sprintf(lang('variables:edit_title'), $variable->name);?></h3>
                    <?php endif ?>
            </div>

            <div class="widget-container">
                    <div class="content">

                            <?php echo form_open($this->uri->uri_string(), 'class="crud form-horizontal" id="variables"') ?>
                            <?php if ($this->method == 'edit') echo form_hidden('variable_id', $variable->id) ?>

                            <div class="form_inputs">

                                            <div class="control-group">
                                                    <label class="control-label" for="name"><?php echo lang('name_label');?> <span>*</span></label>
                                                    <div class="input controls"><?php echo  form_input('name', $variable->name) ?></div>
                                            </div>

                                            <div class="control-group">
                                                    <label class="control-label" for="data"><?php echo lang('variables:data_label');?> <span>*</span></label>
                                                    <div class="input controls"><?php echo  form_input('data', $variable->data) ?></div>
                                            </div>

                                    <div>
                                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                                    </div>

                            </div>

                            <?php echo form_close() ?>

                    </div>
            </div>
        </div>
    </div>
</div>