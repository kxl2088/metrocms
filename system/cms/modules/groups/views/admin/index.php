<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $module_details['name'] ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <?php if ($groups): ?>
                                    <table class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                            <thead>
                                                    <tr>
                                                            <th style="text-align: left!important;"><?php echo lang('groups:name');?></th>
                                                            <th><?php echo lang('groups:short_name');?></th>
                                                            <th width="340"><?php echo lang('global:actions'); ?></th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($groups as $group):?>
                                                    <tr>
                                                            <td style="text-align: left!important;"><?php echo $group->description ?></td>
                                                            <td><?php echo $group->name ?></td>
                                                            <td class="actions">
                                                            <?php echo anchor('admin/groups/edit/'.$group->id, lang('buttons:edit'), 'class="btn btn-primary edit"') ?>
                                                            <?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
                                                                    <?php echo anchor('admin/groups/delete/'.$group->id, lang('buttons:delete'), 'class="confirm btn btn-danger delete"') ?>
                                                            <?php endif ?>
                                                            <?php if ( ! in_array($group->name, array('admin'))): ?>
                                                            <?php echo anchor('admin/permissions/group/'.$group->id, lang('permissions:edit').' &rarr;', 'class="btn btn-info edit"') ?>
                                                            <?php endif; ?>
                                                            </td>
                                                    </tr>
                                            <?php endforeach;?>
                                            </tbody>
                                    </table>
                                    <?php $this->load->view('admin/partials/pagination') ?>
                            <?php else: ?>
                                    <div class="title">
                                            <div class="no_data"><?php echo lang('groups:no_groups');?></div>
                                    </div>
                            <?php endif;?>
                    </div>
            </div>
        </div>
    </div>
</div>