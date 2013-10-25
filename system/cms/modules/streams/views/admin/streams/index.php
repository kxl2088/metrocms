<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('streams:streams');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

<?php if (!empty($streams)): ?>
			
<table border="0" class="table-list responsive table table-hover table-striped table-bordered" cellspacing="0">
	<thead>
		<tr>
		    <th><?php echo lang('streams:stream_name');?></th>
		    <th><?php echo lang('streams:stream_slug');?></th>
		    <th><?php echo lang('streams:about');?></th>
		    <th><?php echo lang('streams:total_entries');?></th>
		    <th width="180"><?php echo lang('global:actions'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($streams as $stream):?>

	<?php
	
	// Does this table exist?
	if($this->db->table_exists($stream->stream_prefix.$stream->stream_slug)):
	
		$table_exists = true;
		echo '<tr>';
	
	else:

		$table_exists = false;
		echo '<tr class="inactive">';
	
	endif;
	
	?>
			<td><?php echo $stream->stream_name; ?></td>
			<td><?php echo $stream->stream_slug; ?></td>
			<td><?php echo $stream->about; ?></td>

			<td><?php if($table_exists): echo number_format($this->streams_m->count_stream_entries($stream->stream_slug, $stream->stream_namespace)); endif; ?></td>
			
			<td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <?php if(group_has_role('streams', 'admin_streams')): echo '<li>' . anchor('admin/streams/manage/' . $stream->id, lang('streams:manage'), 'class="edit"') . '</li>'; endif; ?> 
      <li><?php echo anchor('admin/streams/entries/index/' . $stream->id, lang('streams:entries'), 'class="edit"');?></li>
      <li><?php echo anchor('admin/streams/entries/add/'.$stream->id, lang('streams:new_entry'), 'class=""');?></li>
  </ul>
</div>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<div class="no_data">
	<?php 
	
		if ( ! group_has_role('streams', 'admin_streams'))
		{
			echo lang('streams:start.no_streams_yet');
		}
		else
		{
			echo lang('streams:start.no_streams').' '.anchor('admin/streams/add', lang('streams:start.adding_one')).'.';
		}
			
	?>
	</div>
<?php endif;?>
                    </div>
            </div>
        </div>
    </div>
</div>