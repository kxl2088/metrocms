<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('addons:widgets') ?></h3>
            </div>
            <div class="widget-container">
                <div class="content">
                <?php if ($widgets): ?>
                        <?php echo form_open(uri_string(), 'class="crud"') ?>
                        <!-- Available Widget List -->

                        <table border="0" id="widgets-list" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
                                <thead>
                                <tr>
                                        <th width="30"></th>
                                        <th width="20%"><?php echo lang('global:title') ?></th>
                                        <th><?php echo lang('desc_label') ?></th>
                                        <th width="130"><?php echo lang('global:author') ?></th>
                                        <th width="80" class="center"><?php echo lang('version_label') ?></th>
					<th width="100" class="center"><?php echo lang('addons:modules:status');?></th>
                                        <th width="180"><?php echo lang('global:actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                        <?php foreach ($widgets as $widget): ?>
                                        <tr>
					    <td class="center">
                                                    <span class="move-handle"></span>
                                                    <input type="hidden" name="action_to[]" value="<?php echo $widget->id; ?>">
                                                </td>
                                                <td><?php echo $widget->title ?></td>
                                                <td><?php echo $widget->description ?></td>
                                                <td>
                                                        <?php echo $widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author ?>
                                                </td>
                                                <td class="center"><?php echo $widget->version ?></td>
						<td class="center">
						<?php if ($widget->enabled == '1'): ?>
						<?php echo lang('addons:modules:installed'); ?>  
						<?php else: ?>
					        <?php echo lang('addons:modules:disabled'); ?>  
						<?php endif ?>
						</td>
                                                <td class="align-center buttons buttons-small actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
        <?php if ($widget->enabled == '1'): ?>
      <li><?php echo anchor('admin/addons/widgets/disable/' . $widget->id, lang('buttons:disable'), 'class="disable"') ?></li>
        <?php else: ?>
      <li><?php echo anchor('admin/addons/widgets/enable/' . $widget->id, lang('buttons:enable'), 'class="enable"') ?></li>
        <?php endif ?>
  </ul>
</div>

                                                </td>
                                        </tr>
                                        <?php endforeach ?>
                                </tbody>
                        </table>
                        <?php echo form_close() ?>

                <?php else: ?>
                        <p><?php echo lang('widgets:no_available_widgets') ?></p>
                <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>