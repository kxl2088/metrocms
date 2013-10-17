<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang(sprintf('widgets:%s_area', ($this->method === 'create' ? 'add' : 'edit'))) ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                    <?php echo form_open(uri_string(), 'class="form-horizontal"') ?>

                    <div class="form_inputs">
                            <div class="control-group">
                                    <label class="control-label" for="title"><?php echo lang('widgets:widget_area_title') ?></label>
                                    <div class="input controls">
                                        <?php echo form_input('title', $area->title, 'class="new-area-title"') ?>
                                        <span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
                                    </div>
                            </div>

                            <div class="control-group">
                                    <label class="control-label" for="slug"><?php echo lang('widgets:widget_area_slug') ?></label>
                                    <div class="input controls">
                                        <?php echo form_input('slug', $area->slug, 'class="new-area-slug"') ?>
                                        <span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
                                    </div>
                            </div>

                    </div>

                    <div class="buttons align-right padding-top">
                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))) ?>
                    </div>

                    <?php echo form_close() ?>

                    </div>
            </div>
        </div>
    </div>
</div>