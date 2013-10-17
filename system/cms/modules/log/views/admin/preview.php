<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                <h3><?php echo sprintf(lang('log.edit_log_title'), format_date($log->date), $log->name); ?></h3>

                <div class="log-file-buttons">
                    <?php echo anchor('admin/' . $this->module . '/delete/' . $log->id, lang('global:delete'), 'class="btn btn-danger confirm"'); ?>
                    <?php echo (isset($physical_files[$log->name]) && $log->size != $physical_files[$log->name]['size']) ? (anchor('admin/' . $this->module . '/resync/' . $log->id, lang('log.resync_label'), 'class="btn btn-success"')) : (null); ?>
                </div>
            </div>

            <div class="widget-container">
                    <div class="content">
                        <?php
                        echo form_hidden('checkbox_disabled_at', $this->settings->checkbox_disabled_at);
                        echo form_hidden('total_errors', $total_errors);
                        echo anchor('#', lang('log.scroll_to_bottom'), 'class="scroll-to-bottom"');
                        echo $errors_overview ;
                        echo $log_errors;
                        echo anchor('#', lang('log.scroll_to_top'), 'class="scroll-to-top"'); ?>
                    </div>
            </div>
        </div>
    </div>
</div>