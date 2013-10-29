<?php if ($blog) : ?>
        <table  class="responsive table table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th style="width: 20px"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
				<th><?php echo lang('blog:post_label') ?></th>
				<th class="collapse"><?php echo lang('blog:category_label') ?></th>
				<th class="collapse"><?php echo lang('blog:date_label') ?></th>
				<th class="collapse"><?php echo lang('blog:written_by_label') ?></th>
				<th><?php echo lang('blog:status_label') ?></th>
				<th style="width: 180px"><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($blog as $post) : ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $post->id) ?></td>
					<td><?php echo $post->title ?></td>
					<td class="collapse"><?php echo $post->category_title ?></td>
					<td class="collapse"><?php echo format_date($post->created_on) ?></td>
					<td class="collapse">
					<?php if (isset($post->display_name)): ?>
						<?php echo anchor('user/'.$post->username, $post->display_name, 'target="_blank"') ?>
					<?php else: ?>
						<?php echo lang('blog:author_unknown') ?>
					<?php endif ?>
					</td>
					<td><?php echo lang('blog:'.$post->status.'_label') ?></td>
					<td>
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
        <?php if($post->status=='live') : ?>
      <li><a href="<?php echo site_url('blog/'.date('Y/m', $post->created_on).'/'.$post->slug) ?>" title="<?php echo lang('global:view')?>" target="_blank"><?php echo lang('global:view')?></a></li>
        <?php else: ?>
      <li><a href="<?php echo site_url('blog/preview/' . $post->preview_hash) ?>" title="<?php echo lang('global:preview')?>" target="_blank"><?php echo lang('global:preview')?></a></li>
        <?php endif ?>
      <li><a href="<?php echo site_url('admin/blog/edit/' . $post->id) ?>" title="<?php echo lang('global:edit')?>" class=""><?php echo lang('global:edit')?></a></li>
      <li><a href="<?php echo site_url('admin/blog/delete/' . $post->id) ?>" title="<?php echo lang('global:delete')?>" class="confirm"><?php echo lang('global:delete')?></a></li>
  </ul>
</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

        <?php $this->load->view('admin/partials/pagination') ?>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))) ?>
	</div>
<?php else: ?>
        <div class="no_data"><?php echo lang('blog:currently_no_posts') ?></div>
<?php endif; ?>
