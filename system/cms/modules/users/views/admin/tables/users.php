<?php if (!empty($users)): ?>
	<table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th with="30" class="align-center"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('user:name_label');?></th>
				<th class="collapse"><?php echo lang('user:email_label');?></th>
				<th><?php echo lang('user:group_label');?></th>
				<th class="collapse"><?php echo lang('user:active') ?></th>
				<th class="collapse"><?php echo lang('user:joined_label');?></th>
				<th class="collapse"><?php echo lang('user:last_visit_label');?></th>
				<th width="180"><?php echo lang('global:actions'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $link_profiles = Settings::get('enable_profiles') ?>
			<?php foreach ($users as $member): ?>
				<tr>
					<td class="align-center"><?php echo form_checkbox('action_to[]', $member->id) ?></td>
					<td>
					<?php if ($link_profiles) : ?>
						<?php echo anchor('admin/users/preview/' . $member->id, $member->display_name, 'target="_blank" class="modal-large"') ?>
					<?php else: ?>
						<?php echo $member->display_name ?>
					<?php endif ?>
					</td>
					<td class="collapse"><?php echo mailto($member->email) ?></td>
					<td><?php echo $member->group_name ?></td>
					<td class="collapse"><?php echo $member->active ? lang('global:yes') : lang('global:no')  ?></td>
					<td class="collapse"><?php echo format_date($member->created_on) ?></td>
					<td class="collapse"><?php echo ($member->last_login > 0 ? format_date($member->last_login) : lang('user:never_label')) ?></td>
					<td class="actions">
<div class="btn-group">
  <button class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/users/edit/' . $member->id, lang('global:edit'), array('class'=>' edit')) ?></li>
      <li><?php echo anchor('admin/users/delete/' . $member->id, lang('global:delete'), array('class'=>'confirm delete')) ?></li>
  </ul>
</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
        <?php $this->load->view('admin/partials/pagination') ?>
<?php endif ?>