<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                <h3><?php echo lang('nav:group_create_title');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                <?php echo form_open('admin/navigation/groups/create', 'class="crud form-horizontal"') ?>

                            <div class="form_inputs">

                                        <div class="control-group">
                                                <label class="control-label" for="title"><?php echo lang('global:title');?> <span>*</span></label>
                                                <div class="input controls"><?php echo form_input('title', $navigation_group['title'], 'class="text"') ?></div>
                                        </div>

                                        <div class="control-group">
                                                <label class="control-label" for="url"><?php echo lang('global:slug');?> <span>*</span></label>
                                                <div class="input controls"><?php echo form_input('abbrev', $navigation_group['abbrev'], 'class="text"') ?></div>
                                        </div>

                            </div>

                <div class="buttons padding-top">       
                        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                </div>

                <?php echo form_close() ?>

                    </div>
            </div>
        </div>
    </div>
</div>