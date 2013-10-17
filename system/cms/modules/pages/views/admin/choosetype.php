<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('pages:choose_type_title');?></h3>
            </div>

            <div class="widget-container">
                <div class="content">
                    <table class="responsive table table-hover table-striped table-bordered" border="0" cellspacing="0">
                        <thead>
                            <th width="20%"><?php echo lang('global:title');?></th>
                            <th><?php echo lang('global:description');?></th>
                            <th width="20%"></th>
                        </thead>
                        <tbody>
                            <?php foreach ($page_types as $pt): ?>
                            <tr>
                                <td>
                                    <?php echo anchor('admin/pages/create?page_type='.$pt->id.$parent, $pt->title);?>
                                </td>
                                <td>
                                    <?php echo $pt->description;?>
                                </td>
                                <td class="actions">
                                    <?php echo anchor('admin/pages/create?page_type='.$pt->id.$parent, Lang('pages:create_title'), array('class'=>'button'));?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>