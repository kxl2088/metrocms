<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('redirects:list_title') ?></h3>
            </div>

<?php if ($redirects): ?>

            <div class="widget-container">
                    <div class="content">

                <?php echo form_open('admin/redirects/delete') ?>
                    <table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                        <thead>
                                    <tr>
                                            <th width="15"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                                            <th width="25"><?php echo lang('redirects:type');?></th>
                                            <th width="25%"><?php echo lang('redirects:from');?></th>
                                            <th><?php echo lang('redirects:to');?></th>
                                            <th width="180"><?php echo lang('global:actions'); ?></th>
                                    </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($redirects as $redirect): ?>
                                <tr>
                                    <td><?php echo form_checkbox('action_to[]', $redirect->id) ?></td>
                                    <td><?php echo $redirect->type;?></td>
                                    <td><?php echo str_replace('%', '*', $redirect->from);?></td>
                                    <td><?php echo $redirect->to;?></td>
                                    <td class="align-center">
                                    <div class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects:edit'), 'class="edit"');?></li>
      <li><?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects:delete'), array('class'=>'confirm delete'));?></li>
  </ul>
</div>
                                        
                                    </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                    <?php $this->load->view('admin/partials/pagination') ?>
                        
                    <div class="table_action_buttons">
                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
                    </div>
                <?php echo form_close() ?>

                    </div>
            </div>

<?php else: ?>
            <div class="widget-container">
                    <div class="content">
                            <div class="no_data"><?php echo lang('redirects:no_redirects');?></div>
                    </div>
            </div>
<?php endif ?>
        </div>
    </div>
</div>