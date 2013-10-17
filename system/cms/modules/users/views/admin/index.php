<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('user:list_title') ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                            <?php template_partial('filters') ?>

                            <?php echo form_open('admin/users/action') ?>

                                    <div id="filter-stage">
                                            <?php template_partial('tables/users') ?>
                                    </div>

                                    <div class="table_action_buttons">
                                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('activate', 'delete') )) ?>
                                    </div>

                            <?php echo form_close() ?>
                    </div>
            </div>
        </div>
    </div>
</div>