<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo sprintf(lang('templates:clone_title'), $template_name) ?></h3>
            </div>
            <?php echo form_open(current_url(), 'class="crud form-horizontal"') ?>
            <div class="widget-container">
                    <div class="content">
                            <div class="form_inputs">
                                    <div class="control-group">
                                        <label class="control-label" for="lang"><?php echo lang('templates:choose_lang_label') ?></label>
                                        <div class="input controls">
                                            <?php echo form_dropdown('lang', $lang_options) ?>
                                        </div>
                                    </div>
                            </div>
                        
                            <div class="buttons alignright padding-top">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                            </div>
                            <?php echo form_close() ?>
                    </div>
            </div>
        </div>
    </div>
</div>