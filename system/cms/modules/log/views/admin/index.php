<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                <h3><?php echo lang('log.posts_title'); ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                        <?php if ($logs) : ?>
                        <div id="filter-stage">
                            <?php echo form_open('admin/' . $this->module . '/action'); ?>
                            <?php echo $this->load->view('admin/tables/posts'); ?>
                            <?php echo form_close(); ?>
                        </div>
                        <?php else : ?>
                        <div class="no_data"><?php echo lang('log.currently_no_logs'); ?></div>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
</div>