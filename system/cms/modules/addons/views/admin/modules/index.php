<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('addons:modules:addon_list');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <?php if ($addon_modules): ?>
                            <table class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                    <thead>
                                            <tr>
                                                    <th><?php echo lang('name_label');?></th>
                                                    <th class="collapse"><span><?php echo lang('desc_label');?></span></th>
                                                    <th class="center" width="80"><?php echo lang('version_label');?></th>
                                                    <th width="100" class="center"><?php echo lang('addons:modules:status');?></th>
                                                    <th width="180"><?php echo lang('global:actions'); ?></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($addon_modules as $module): ?>
                                            <tr>
                                                    <td class="collapse"><?php echo ($module['is_backend'] and $module['installed']) ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></td>

                                                    <td><?php echo $module['description'] ?></td>
                                                    <td class="center"><?php echo $module['version'] ?></td>
                                                    <td class="center">
                                                    <?php if ($module['installed']): ?>
                                                        <?php if (!$module['is_current']): ?>                
                                                                <?php echo lang('global:upgrade'); ?>
                                                        <?php elseif (!$module['enabled']): ?>
                                                                <?php echo lang('addons:modules:disabled'); ?>  
                                                        <?php elseif ($module['enabled']): ?>
                                                                <?php echo lang('addons:modules:installed'); ?>  
                                                        <?php endif ?>
                                                    <?php else: ?>
                                                        <?php echo lang('addons:modules:uninstalled'); ?>  
                                                    <?php endif ?>        
                                                    </td>
                                                    <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      
    <?php if ($module['installed']): ?>
        <?php if ($module['enabled']): ?>
                <li><?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_disable'))) ?></li>
        <?php else: ?>
                <li><?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_enable'))) ?></li>
        <?php endif ?>
        <?php if ($module['is_current']): ?>
                <li><?php echo anchor('admin/addons/modules/uninstall/'.$module['slug'], lang('global:uninstall'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_uninstall'))) ?></li>
        <?php else: ?>
                <li><?php echo anchor('admin/addons/modules/upgrade/'.$module['slug'], lang('global:upgrade'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_upgrade'))) ?></li>
        <?php endif ?>
    <?php else: ?>
        <li><?php echo anchor('admin/addons/modules/install/'.$module['slug'], lang('global:install'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_install'))) ?></li>
    <?php endif ?>
        <li><?php echo anchor('admin/addons/modules/delete/'.$module['slug'], lang('global:delete'), array('class'=>'confirm ', 'title'=>lang('addons:modules:confirm_delete'))) ?></li>
     
  </ul>
</div>                                                            
                                                    </td>
                                            </tr>
                                    <?php endforeach ?>
                                    </tbody>
                            </table>

                            <?php endif ?>
                    </div>

            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('addons:modules:core_list');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <p><?php echo lang('addons:modules:core_introduction') ?></p>

                            <table class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                    <thead>
                                            <tr>
                                                    <th><?php echo lang('name_label');?></th>
                                                    <th><span><?php echo lang('desc_label');?></span></th>
                                                    <th class="center" width="80"><?php echo lang('version_label');?></th>
                                                    <th width="100" class="center"><?php echo lang('addons:modules:status');?></th>
                                                    <th width="180"><?php echo lang('global:actions'); ?></th>
                                            </tr>
                                    </thead>	
                                    <tbody>
                                    <?php foreach ($core_modules as $module): ?>
                                    <?php if ($module['slug'] === 'addons') continue ?>
                                            <tr>
                                                    <td><?php echo $module['is_backend'] ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></td>
                                                    <td><?php echo $module['description'] ?></td>
                                                    <td class="center"><?php echo $module['version'] ?></td>
                                                    <td class="center">
                                                    <?php if ($module['installed']): ?>
                                                        <?php if (!$module['is_current']): ?>                
                                                                <?php echo lang('global:upgrade'); ?>
                                                        <?php elseif (!$module['enabled']): ?>
                                                                <?php echo lang('addons:modules:disabled'); ?>  
                                                        <?php elseif ($module['enabled']): ?>
                                                                <?php echo lang('addons:modules:installed'); ?>  
                                                        <?php endif ?>
                                                    <?php else: ?>
                                                        <?php echo lang('addons:modules:uninstalled'); ?>  
                                                    <?php endif ?>   
                                                    </td>
                                                    <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
    <?php if ($module['enabled']): ?>
      <li><?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_disable'))) ?><li>
    <?php else: ?>
      <li><?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm', 'title'=>lang('addons:modules:confirm_enable'))) ?></li>
    <?php endif ?>
  </ul>
</div>
                                                    </td>
                                            </tr>
                                    <?php endforeach ?>
                                    </tbody>	
                            </table>

                    </div>
            </div>
        </div>
    </div>
</div>