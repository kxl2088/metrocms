<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('page_types:list_title'); ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <?php echo form_open('admin/pages/types/delete');?>

                                    <?php if ( ! empty($page_types)): ?>
                                            <table class="responsive table table-hover table-striped table-bordered"  >		    
                                                    <thead>
                                                            <tr>
                                        <th><?php echo lang('global:title');?></th>
                                        <th><?php echo lang('global:description');?></th>
                                        <th style="width: 180px"><?php echo lang('global:actions');?></th>
                                                            </tr>
                                                    </thead>

                                                    <tbody>
                                                            <?php foreach ($page_types as $page_type): ?>
                                                                    <tr>
                                                                            <td><?php echo $page_type->title;?></td>
                                            <td><?php echo $page_type->description;?></td>
                                                                            <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <?php if ($page_type->save_as_files == 'y' and $page_type->needs_sync): ?>
      <li><?php echo anchor('admin/pages/types/sync/'.$page_type->id, lang('page_types:sync_files'), array('class'=>''));?></li>
      <?php endif; ?>
      <li><?php echo anchor('admin/pages/types/fields/'.$page_type->id, lang('global:fields'), array('class'=>''));?> </li>
      <li><?php echo anchor('admin/pages/types/edit/' . $page_type->id, lang('global:edit'), array('class'=>''));?> </li>
      <li><?php if ($page_type->slug !== 'default') echo anchor('admin/pages/types/delete/' . $page_type->id, lang('global:delete'), array('class'=>'confirm'));?></li>
  </ul>
</div>
                                                                            </td>
                                                                    </tr>
                                                            <?php endforeach; ?>
                                                    </tbody>
                                            </table>

                                            <?php else:?>
                                                    <div class="no_data"><?php echo lang('page_types:no_pages');?></div>
                                            <?php endif; ?>		

                                    <?php echo form_close(); ?>
                    </div>
            </div>
        </div>
    </div>
</div>