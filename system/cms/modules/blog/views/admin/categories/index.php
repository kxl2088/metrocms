<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('cat:list_title') ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                    <?php if ($categories): ?>

                            <?php echo form_open('admin/blog/categories/delete') ?>

                            <table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                    <thead>
                                        <tr>
                                                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
                                                <th><?php echo lang('cat:category_label') ?></th>
                                                <th><?php echo lang('global:slug') ?></th>
                                                <th width="180"><?php echo lang('global:actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($categories as $category): ?>
                                            <tr>
                                                    <td><?php echo form_checkbox('action_to[]', $category->id) ?></td>
                                                    <td><?php echo $category->title ?></td>
                                                    <td><?php echo $category->slug ?></td>
                                                    <td class="align-center buttons buttons-small">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/blog/categories/edit/'.$category->id, lang('global:edit'), 'class="edit"') ?></li>
      <li><?php echo anchor('admin/blog/categories/delete/'.$category->id, lang('global:delete'), 'class="confirm delete"') ;?></li>
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
                            <div class="no_data"><?php echo lang('cat:no_categories') ?></div>
                    <?php endif ?>
                    </div>
            </div>
        </div>
    </div>
</div>