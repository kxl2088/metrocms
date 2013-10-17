<?php if ($apis) : ?>
        <table cellspacing="0" class="responsive table table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th><?php echo lang('streams:application_label') ?></th>
                                <th class="collapse"><?php echo lang('streams:token_label') ?></th>
				<th class="collapse"><?php echo lang('streams:created_label') ?></th>
				<th class="collapse"><?php echo lang('streams:expires_on_label') ?></th>
                                <th width="100"><?php echo lang('streams:expired') ?></th>
				<th width="100"><?php echo lang('streams:enabled_label') ?></th>
				<th width="180"><?php echo lang('global:actions') ?></th>
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
						<a href="<?php echo site_url('admin/streams/api/edit/' . $api->id) ?>" title="<?php echo lang('global:edit')?>" class="btn btn-primary"><?php echo lang('global:edit')?></a>
						<a href="<?php echo site_url('admin/streams/api/delete/' . $api->id) ?>" title="<?php echo lang('global:delete')?>" class="btn btn-danger confirm"><?php echo lang('global:delete')?></a>
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