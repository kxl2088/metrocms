<?php if ( ! empty($comments)): ?>

	<table  class="table-list responsive table table-hover table-striped table-bordered" >
		<thead>
			<tr>
				<th style="width: 20px"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th style="width: 25%"><?php echo lang('comments:message_label') ?></th>
				<th style="width: 25%"><?php echo lang('comments:item_label') ?></th>
				<th><?php echo lang('global:author') ?></th>
				<th style="width: 180px"><?php echo lang('comments:date_label') ?></th>
				<th style="width: 180px"><?php echo lang('global:actions'); ?></th>
			</tr>
		</thead>
	
	
		<tbody>
			<?php foreach ($comments as $comment): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $comment->id) ?></td>
					<td>
						<a href="<?php echo site_url('admin/comments/preview/'.$comment->id) ?>" rel="modal-popup">
							<?php if( strlen($comment->comment) > 30 ): ?>
								<?php echo character_limiter((Settings::get('comment_markdown') and $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment, 30) ?>
							<?php else: ?>
								<?php echo (Settings::get('comment_markdown') and $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment ?>
							<?php endif ?>
						</a>
					</td>
				
					<td>
						<strong><?php echo lang($comment->singular) ? lang($comment->singular) : $comment->singular ?>: </strong>
						<?php echo anchor($comment->cp_uri ? $comment->cp_uri : $comment->uri, $comment->entry_title ? $comment->entry_title : '#'.$comment->entry_id) ?>
					</td>
					
					<td>
						<?php if ($comment->user_id > 0): ?>
							<?php echo anchor('admin/users/edit/'.$comment->user_id, user_displayname($comment->user_id, false)) ?>
						<?php else: ?>
							<?php echo mailto($comment->user_email, $comment->user_name) ?>
						<?php endif ?>
					</td>
				
					<td><?php echo format_date($comment->created_on) ?></td>
					
					<td class="align-center buttons buttons-small">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
						<?php if ($this->settings->moderate_comments): ?>
							<?php if ($comment->is_active): ?>
      <li><?php echo anchor('admin/comments/unapprove/'.$comment->id, lang('buttons:deactivate'), 'class="confirm deactivate"') ?></li>
							<?php else: ?>
      <li><?php echo anchor('admin/comments/approve/'.$comment->id, lang('buttons:activate'), 'class="activate"') ?></li>
							<?php endif ?>
						<?php endif ?>
					
      <li><?php echo anchor('admin/comments/edit/'.$comment->id, lang('global:edit'), 'class="edit"') ?></li>
      <li><?php echo anchor('admin/comments/delete/'.$comment->id, lang('global:delete'), array('class'=>'confirm delete')) ?></li>
      <li><?php echo anchor('admin/comments/report/'.$comment->id, lang('comments:report'), array('class'=>'confirm edit')) ?><li>
  </ul>
</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

<?php $this->load->view('admin/partials/pagination') ?>
	
<?php else: ?>

	<div class="no_data"><?php echo lang('comments:no_comments') ?></div>

<?php endif ?>
