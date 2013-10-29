<?php if ($apis) : ?>
        <table  class="responsive table table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th style="width: 20px"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th><?php echo lang('streams:application_label') ?></th>
                                <th class="collapse"><?php echo lang('streams:token_label') ?></th>
				<th class="collapse"><?php echo lang('streams:created_label') ?></th>
				<th class="collapse"><?php echo lang('streams:expires_on_label') ?></th>
                                <th style="width: 100px"><?php echo lang('streams:expired') ?></th>
				<th style="width: 100px"><?php echo lang('streams:enabled_label') ?></th>
				<th style="width: 180px"><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($apis as $api) : ?>
				<tr class="<?php if($api->expires_on < date('Y-m-d H:i:s')): echo 'expired'; endif; ?>">
					<td><?php echo form_checkbox('action_to[]', $api->id) ?></td>
					<td><?php echo $api->application ?></td>
                                        <td><?php echo $api->token ?></td>
					<td class="collapse"><?php echo format_date($api->created, 'd/m/Y') ?></td>
					<td class="collapse"><?php echo format_date($api->expires_on, 'd/m/Y') ?></td>
                                        <td class="collapse"><?php echo $api->expires_on < date('Y-m-d H:i:s') ? lang('global:yes') : lang('global:no') ?></td>
					<td class="collapse"><?php echo lang('global:'.$api->enabled) ?></td>
					<td>
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><a href="<?php echo site_url('admin/streams/api/edit/' . $api->id) ?>" title="<?php echo lang('global:edit')?>" class=""><?php echo lang('global:edit')?></a></li>
      <li><a href="<?php echo site_url('admin/streams/api/delete/' . $api->id) ?>" title="<?php echo lang('global:delete')?>" class=" confirm"><?php echo lang('global:delete')?></a></li>
  </ul>
</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

        <?php $this->load->view('admin/partials/pagination') ?>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))) ?>
	</div>

        <?php else : ?>
                <div class="no_data"><?php echo lang('streams:no_data') ?></div>
        <?php endif ?>