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
                                                <th width="180"><?php echo lang('global:actions'); ?></th>
                                        </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($keywords as $keyword):?>
                                        <tr>
                                                <td style="text-align: left!important;"><?php echo $keyword->name ?></td>
                                                <td class="actions">
<div class="btn-group">
  <button class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/keywords/edit/'.$keyword->id, lang('global:edit'), 'class="edit"') ?></li>
                                                <?php if ( ! in_array($keyword->name, array('user', 'admin'))): ?>
      <li><?php echo anchor('admin/keywords/delete/'.$keyword->id, lang('global:delete'), 'class="confirm delete"') ?></li>
                                                <?php endif ?>
  </ul>
</div>
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