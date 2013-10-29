<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $stream->stream_name;?></span> &rarr; <?php echo lang('streams:entry');?> <?php echo $row->id;?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

    <table class="table-list responsive table table-hover table-striped table-bordered" >
		<thead>
			<tr>
				<th><?php echo lang('streams:label.field');?></th>
			    <th><?php echo lang('streams:value');?></th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<td style="width: 25%"><strong><?php echo lang('streams:id');?></strong></td>
			<td><?php echo $row->id;?></td>
		</tr>
		<tr>
			<td><strong><?php echo lang('streams:created_date');?></strong></td>
			<td><?php echo date('M j Y g:i a', $row->created);?></td>
		</tr>
		<tr>
			<td><strong><?php echo lang('streams:updated_date');?></strong></td>
			<td><?php if( $row->updated ): echo date('M j Y g:i a', $row->updated); endif; ?></td>
		</tr>
		<tr>
			<td><strong><?php echo lang('streams:created_by');?></strong></td>
			<td><a href="<?php echo site_url('admin/users/edit/'. $row->created_by_user_id); ?>"><?php echo $row->created_by_username; ?></a></td>
		</tr>
		
		<?php foreach ($stream_fields as $stream_field):?>
			<tr>
				<td><strong><?php echo $stream_field->field_name;?></strong></td>
				<td><?php $node = $stream_field->field_slug; echo $row->$node; ?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>


 	<div class="float-right buttons">
    	<?php echo anchor('admin/streams/entries/edit/'.$this->uri->segment(5).'/'.$row->id, lang('global:edit'), 'class="btn btn-primary"')?>
	    <?php echo anchor('admin/streams/entries/delete/'.$this->uri->segment(5).'/'.$row->id, lang('global:delete'), 'class="btn btn-danger confirm"')?>
	</div>
   
                    </div>
            </div>
        </div>
    </div>
</div>