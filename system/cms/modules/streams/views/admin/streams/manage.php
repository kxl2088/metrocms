<div class="row-fluid">
    <div class="span6">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('streams:stream_admin');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                            <table border="0" class="table-list table-lg-left table-expand-link responsive table table-hover table-striped table-bordered" cellspacing="0">
                                    <tbody>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/entries/add/'.$this->uri->segment(4), lang('streams:new_entry'), 'class="add"');?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/entries/index/'.$this->uri->segment(4), lang('streams:stream_entries'), 'class="data"');?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/assignments/'.$this->uri->segment(4), lang('streams:field_assignments'), 'class="list"');?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/permissions/'.$this->uri->segment(4), $perm_lang, 'class="list"');?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/edit/'.$this->uri->segment(4), lang('streams:edit_stream')); ?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/view_options/'.$this->uri->segment(4), lang('streams:stream_view_options')); ?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/backup/'.$this->uri->segment(4), lang('streams:backup_table')); ?></td>
                                    </tr>
                                    <tr>
                                            <td><?php echo anchor('admin/streams/delete/'.$this->uri->segment(4), lang('streams:delete_stream')); ?></td>
                                    </tr>
                                    </tbody>
                            </table>
                    </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('streams:about_stream'); ?></h3>
            </div>   
            
            <div class="widget-container">
                    <div class="content">
                        
                            <table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                        <tbody>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:stream_name'); ?></strong></td>
                                                        <td><?php echo $stream->stream_name; ?></td>
                                                </tr>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:about'); ?></strong></td>
                                                        <td><?php echo $stream->about; ?></td>
                                                </tr>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:database_table'); ?></strong></td>
                                                        <td><?php echo SITE_REF; ?>_<?php echo $meta['db_table']; ?></td>
                                                </tr>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:size'); ?></strong></td>
                                                        <td><?php echo $meta['size']; ?></td>
                                                </tr>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:num_of_entries'); ?></strong></td>
                                                        <td><?php echo $meta['entries_count']; ?></td>
                                                </tr>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:num_of_fields'); ?></strong></td>
                                                        <td><?php echo $meta['fields_count']; ?></td>
                                                </tr>
                                                <tr>
                                                        <td><strong><?php echo lang('streams:last_updated'); ?></strong></td>
                                                        <td><?php echo date('Y-m-d g:i a', $meta['last_updated']); ?></td>
                                                </tr>
                                        </tbody>
                            </table>
                    </div>
            </div>
        </div>
    </div>
</div>