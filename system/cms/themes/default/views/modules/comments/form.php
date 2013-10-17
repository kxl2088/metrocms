<div class="well">
<?php echo form_open("comments/create/{$module}", 'id="create-comment" role="form"') ?>

	<noscript><?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"') ?></noscript>

	<h4><?php echo lang('comments:your_comment') ?></h4>
{{ session:messages success="alert alert-success" notice="alert alert-warning" error="alert alert-danger" }}
	<?php echo form_hidden('entry', $entry_hash) ?>

	<?php if ( ! is_logged_in()): ?>

	<div class="form-group">
		<label for="name"><?php echo lang('comments:name_label') ?><span class="required">*</span>:</label>
		<input type="text" name="name" id="name" maxlength="40" value="<?php echo $comment['name'] ?>" class="form-control" />
	</div>

	<div class="form-group">
		<label for="email"><?php echo lang('global:email') ?><span class="required">*</span>:</label>
		<input type="text" name="email" maxlength="40" value="<?php echo $comment['email'] ?>" class="form-control" />
	</div>

	<div class="form-group">
		<label for="website"><?php echo lang('comments:website_label') ?>:</label>
		<input type="text" name="website" maxlength="40" value="<?php echo $comment['website'] ?>" class="form-control" />
	</div>

	<?php endif ?>

	<div class="form-group">
		<textarea name="comment" id="comment" rows="3" class="form-control"><?php echo $comment['comment'] ?></textarea>
	</div>

	<div class="form-group">
		<?php echo form_submit('submit', lang('comments:send_label'), 'class="btn btn-primary"') ?>
	</div>

<?php echo form_close() ?>
</div>