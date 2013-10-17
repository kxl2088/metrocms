<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('blacklist:item_list'); ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                        <?php echo form_open('admin/blacklist/delete');?>
                        <?php if (!empty($items)): ?>
                                <table class="responsive table table-hover table-striped table-bordered">
                                        <thead>
                                                <tr>
                                                        <th width="10"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                                                        <th width="200"><?php echo lang('blacklist:ip'); ?></th>
                                                        <th><?php echo lang('blacklist:reason'); ?></th>
                                                        <th width="180"><?php echo lang('global:actions'); ?></th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <?php foreach( $items as $item ): ?>
                                                <tr>
                                                        <td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
                                                        <td><?php echo $item->ip; ?></td>
                                                        <td><?php echo $item->reason; ?></td>
                                                        <td class="actions">
                                                                <?php echo
                                                                anchor('admin/blacklist/edit/'.$item->id, lang('global:edit'), 'class="btn btn-primary"').' '.
                                                                anchor('admin/blacklist/delete/'.$item->id, lang('global:delete'), array('class'=>'btn btn-danger confirm')); ?>
                                                        </td>
                                                </tr>
                                                <?php endforeach; ?>
                                        </tbody>
                                </table>
                        
                                <?php $this->load->view('admin/partials/pagination'); ?>
                        
                                <div class="table_action_buttons">
                                        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
                                </div>

                        <?php else: ?>
                                <div class="no_data"><?php echo lang('blacklist:no_items'); ?></div>
                        <?php endif;?>
                        <?php echo form_close(); ?>
                                
                    </div>
            </div>
        </div>
    </div>
</div>