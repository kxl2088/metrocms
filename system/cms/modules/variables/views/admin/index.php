<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $module_details['name'] ?></h3>
            </div>

            <div class="widget-container">
                <div class="content">
                <?php if ($variables): ?>

                        <?php echo form_open('admin/variables/delete') ?>
                                <table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                        <thead>
                                        <tr>
                                                <th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                                                <th width="20%"><?php echo lang('name_label');?></th>
                                                <th class="collapse"><?php echo lang('variables:data_label');?></th>
                                                <th class="collapse" width="20%"><?php echo lang('variables:syntax_label');?></th>
                                                <th width="180"><?php echo lang('global:actions'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                <?php foreach ($variables as $variable): ?>
                                                <tr>
                                                        <td><?php echo form_checkbox('action_to[]', $variable->id) ?></td>
                                                        <td><?php echo $variable->name;?></td>
                                                        <td class="collapse"><?php echo $variable->data;?></td>
                                                        <td class="collapse"><?php form_input('', printf('{{&nbsp;variables:%s&nbsp;}}', $variable->name));?></td>
                                                        <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/variables/edit/' . $variable->id, lang('buttons:edit'), 'class="edit"') ?></li>
      <li><?php echo anchor('admin/variables/delete/' . $variable->id, lang('buttons:delete'), array('class'=>'confirm delete')) ?></li>
  </ul>
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

                <?php else: ?>
                                <div class="no_data"><?php echo lang('variables:no_variables');?></div>
                <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>