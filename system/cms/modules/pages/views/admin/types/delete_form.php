<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('global:delete'); ?> <?php echo lang('page_types:list_title_sing'); ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                            <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

                                    <p><?php echo sprintf(lang('page_types:delete_message'), $num_of_pages); ?></p>

                                    <?php if ($delete_stream): ?>
                                            <p><?php echo sprintf(lang('page_types:delete_streams_message'), $stream_name); ?></p>
                                    <?php endif; ?>

                                    <input type="hidden" name="do_delete" value="y" />

                                    <p>
                                            <button type="submit" class="btn btn-danger"><?php echo lang('global:delete'); ?></button>
                                            <a href="<?php echo site_url('admin/pages/types'); ?>" class="btn btn-warning"><?php echo lang('cancel_label'); ?></a>
                                    </p>

                            <?php echo form_close(); ?>

                    </div>
            </div>
        </div>
    </div>
</div>