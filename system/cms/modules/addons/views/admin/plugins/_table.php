<table class="table-list responsive table table-hover table-striped table-bordered" >

	<thead>
		<tr>
			<th><?php echo lang('name_label');?></th>
			<th class="collapse"><span><?php echo lang('desc_label');?></span></th>
			<th><?php echo lang('version_label');?></th>
			<th></th>
		</tr>
		</thead>

	<tbody>
	<?php foreach ($plugins as $plugin): ?>
	<tr>
		<td style="width: 30%"><?php echo $plugin['name'] ?></td>
		<td style="width: 60%"><?php echo $plugin['description'] ?></td>
		<td><?php echo $plugin['version'] ?></td>
		<td style="text-align: center"><?php if ($plugin['self_doc']): ?>
			<a href="#<?php echo $plugin['slug'] ?>" title="<?php echo $plugin['name'] .' - '. lang('global:preview')?>"  class="icon-search ti inline-modal" style="margin-right:8px;"></a>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>

</table>