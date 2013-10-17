<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $module_details['name'] ?></h3>
            </div>

            <div class="widget-container">
                <div class="content">

                <?php if ($keywords): ?>
                    <table class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                <thead>
                                        <tr>
                                                <th style="text-align: left!important;"><?php echo lang('keywords:name');?></th>
                                                <th width="200"><?php echo lang('global:actions'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($keywords as $keyword):?>
                                        <tr>
                                                <td style="text-align: left!important;"><?php echo $keyword->name ?></td>
                                                <td class="actions">
                                                <?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="btn btn-primary edit"') ?>
                                                <?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
                                                        <?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="confirm btn btn-danger delete"') ?>
                                                <?php endif ?>
                                                </td>
                                        </tr>
                                <?php endforeach;?>
                                </tbody>
                    </table>
                    
                    <?php $this->load->view('admin/partials/pagination') ?>

                <?php else: ?>
                        <div class="no_data"><?php echo lang('keywords:no_keywords');?></div>
                <?php endif;?>

                </div>
            </div>
        </div>
    </div>
</div>