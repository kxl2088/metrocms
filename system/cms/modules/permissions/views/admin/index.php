<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $module_details['name'] ?></h3>
            </div>
            <div class="widget-container">
                    <div class="content">
                            <p><?php echo lang('permissions:introduction') ?></p>
                            <table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                    <thead>
                                            <tr>
                                                    <th style="text-align: left !important;"><?php echo lang('permissions:group') ?></th>
                                                    <th width="320"><?php echo lang('global:actions'); ?></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <?php foreach ($groups as $group): ?>
                                            <tr>
                                                    <td style="text-align: left !important;"><?php echo $group->description ?></td>
                                                    <td class="buttons actions">
                                                            <?php if ($admin_group != $group->name):?>
                                                            <?php echo anchor('admin/permissions/group/' . $group->id, lang('permissions:edit'), array('class'=>'btn btn-primary')) ?>
                                                            <?php else: ?>
                                                            <?php echo lang('permissions:admin_has_all_permissions') ?>
                                                            <?php endif ?>
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