<table class="responsive table table-hover table-striped table-bordered">
    <thead>
    <tr>
        <th width="20"><?php echo form_checkbox(array(
                'name'  => 'action_to_all',
                'class' => 'check-all'
            )
        ); ?></th>
        <th><?php echo lang('name_label'); ?></th>
        <th><?php echo lang('log.size_label'); ?></th>
        <th><?php echo lang('log.date_label'); ?></th>
        <th><?php echo lang('log.date_synced_label'); ?></th>
        <th width="320"><?php echo lang('global:actions'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $log): ?>
    <tr>
        <td><?php echo form_checkbox('action_to[]', $log->id); ?></td>
        <td><?php echo $log->name; ?></td>
        <td><?php echo byte_size($log->size); ?></td>
        <td><?php echo format_date($log->date); ?></td>
        <td><?php echo format_date($log->created_on); ?></td>
        <td style="text-align: right;">
            <?php echo anchor('admin/' . $this->module . '/preview/' . $log->id, lang('global:view'), 'class="btn btn-success"'); ?>
            <?php echo anchor('admin/' . $this->module . '/delete/' . $log->id, lang('global:delete'), array('class' => 'confirm btn btn-danger delete')); ?>
            <?php echo (isset($physical_files[$log->name]) && $log->size != $physical_files[$log->name]['size']) ? (anchor('admin/' . $this->module . '/resync/' . $log->id, lang('log.resync_label'), 'class="btn btn-success"')) : (null); ?>
        </td>
    </tr><?php
    endforeach; ?>
    </tbody>
</table>
<?php $this->load->view('admin/partials/pagination'); ?>

<div class="table_action_buttons">
    <button type="submit" name="btnAction" value="resync" class="btn btn-success" disabled="">
        <span><?php echo lang('log.resync_label'); ?></span>
    </button>
    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
</div>