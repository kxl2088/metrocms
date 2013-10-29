<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>"><?php echo $stream->stream_name;?></a></span> &rarr; <?php echo lang('streams:field_assignments');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

<?php if ( $stream_fields ): ?>

    <table class="table-list responsive table table-hover table-striped table-bordered">
		<thead>
			<tr>	
			    <th></th>
			    <th><?php echo lang('streams:label.field_name');?></th>
			    <th><?php echo lang('streams:label.field_slug');?></th>
			    <th></th>
			</tr>
		</thead>
		<tbody>		
		<?php foreach ($stream_fields as $stream_field):?>
			<tr>
				<td style="width: 30px" class="handle"><?php echo Asset::img('icons/drag_handle.gif', 'Drag Handle'); ?></td>
				<td>
					<input type="hidden" name="action_to[]" value="<?php echo $stream_field->assign_id;?>" />
					<?php echo $stream_field->field_name; ?></td>
				<td><?php echo $stream_field->field_slug; ?></td>
				<td class="actions">
					<?php echo anchor('admin/streams/edit_assignment/'.$stream_field->stream_id . '/'.$stream_field->assign_id, lang('streams:edit_assign'), 'class="button"'); ?>
					<?php echo anchor('admin/streams/remove_assignment/'.$stream_field->stream_id . '/'.$stream_field->assign_id, lang('streams:remove'), 'class="button confirm"'); ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php echo $pagination['links']; ?>

<?php else: ?>

	<div class="no_data">
	<?php if( $total_existing_fields > 0 ): ?>
	
	<?php echo lang('streams:start.no_assign'); ?>
    
    <?php else: ?>
    
	<?php echo lang('streams:start.before_assign');?> <?php echo anchor('admin/streams/fields/add', lang('streams:start.create_field_here'))?>.
    
    <?php endif; ?>
	</div>
   
<?php endif;?>
                    </div>
            </div>
        </div>
    </div>
</div>