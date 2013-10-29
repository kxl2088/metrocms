<div id="upload-box">
	<h3><?php echo lang('files:upload') ?><span class="close ui-icon ui-icon-closethick"><?php echo lang('buttons:close') ?></span></h3>
	<?php echo form_open_multipart('admin/wysiwyg/upload') ?>
		<?php echo form_hidden('redirect_to', 'files_wysiwyg') ?>
		<ul>
			<li>
				<label for="name"><?php echo lang('files:name') ?></label>
				<?php echo form_input('name', set_value('name'), 'id="name"') ?>
			</li>
			<li>
				<label for="file"><?php echo lang('files:location'); ?><span class="required">*</span></label>
				<?php echo form_upload('userfile', 'id="file"') ?>
			</li>
			<li>
				<label for="folder_id"><?php echo lang('files:folder'); ?><span class="required">*</span></label>
				<?php echo form_dropdown('folder_id', array(0 => lang('files:select_folder')) + $folders_tree, 'id="folder"') ?>
			</li>
			<li>
				<label for="description"><?php echo lang('files:description') ?></label>
				<?php echo form_textarea('description', set_value('description'), 'id="description"') ?>
			</li>
			<li>
				<?php echo form_button(array('type' => 'submit', 'name' => 'button_action'), '<i class="icon-upload-alt"></i> ' . lang('files:upload'), 'class="btn btn-info"') ?>
				<a href="<?php echo current_url() ?>#" class="btn btn-danger cancel"><?php echo lang('buttons:cancel') ?></a>
			</li>
		</ul>
	<?php echo form_close() ?>
</div>
<div id="files_browser">
    <div id="files_left_pane">
        <h3><?php echo lang('files:folders') ?></h3>
		<ul id="files-nav">
		<?php foreach ($folders as $folder): ?>
		<?php if ( ! $folder->parent_id): ?>
			<li id="folder-id-<?php echo $folder->id ?>" class="<?php echo $current_folder && $current_folder->id == $folder->id ? 'current' : '' ?>">
				<?php echo anchor("admin/wysiwyg/files_wysiwyg/index/{$folder->id}", $folder->name, 'title="'.$folder->slug.'"') ?>
			</li>
		<?php endif ?>
		<?php endforeach ?>
		<?php if ($folders): ?>
			<li class="upload">
				<?php echo anchor("admin/wysiwyg/files_wysiwyg/upload", lang('files:upload'), 'title="upload"') ?>
			</li>
		<?php endif ?>
		</ul>
	</div>
	<div id="files_right_pane">
		<div id="files-wrapper">
		<?php if ($current_folder): ?>
			<h3><?php echo $current_folder->name ?></h3>
			<!-- subfolders -->
			<div id="files_panel">
				<ul>
					<li>
						<label for="folder"><?php echo lang('files:subfolders') ?>:</label>
						<?php echo form_dropdown('parent_id', $subfolders, $current_folder->id, 'id="parent_id" title="files_wysiwyg"') ?>
					</li>
				</ul>
			</div>
			<?php  if ($current_folder->items): ?>
			<table class="table-list responsive table table-hover table-striped table-bordered"  >
				<thead>
					<tr>
						<th><?php echo lang('global:actions') ?></th>
						<th><?php echo lang('files:name') . '/' . lang('files:description') ?></th>
						<th><?php echo lang('files:filename') . '/' . lang('files:added') ?></th>
						<th><?php echo lang('wysiwyg.meta.mime') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($current_folder->items as $file): ?>
					<tr class="<?php echo alternator('', 'alt') ?>">
						<td class="image">
							<button onclick="javascript:insertFile('<?php echo $file->id."', '".htmlentities(addslashes($file->name))."', '".$file->location."', '".$file->path ?>');" class="btn btn-primary">
								<?php echo lang('wysiwyg.insert'); ?>
							</button>
						</td>
						<td class="name-description">
							<p><?php echo $file->name ?><p>
							<p><?php echo $file->description ?></p>
						</td>
						<td class="filename">
							<p><?php echo $file->filename ?></p>
							<p><?php echo format_date($file->date_added) ?></p>
						</td>
						<td class="meta width"><?php echo $file->mimetype ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<?php else: ?>
			<p class="panel_no_files"><?php echo lang('files:no_files') ?></p>
			<?php endif ?>
		<?php else: ?>
			<div class="blank-slate file-folders">
				<h2><?php echo lang('files:no_folders_wysiwyg');?></h2>
			</div>
		<?php endif ?>
		</div>
	</div>
</div>
<script>
    
</script>