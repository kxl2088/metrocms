<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><span><a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>"><?php echo $stream->stream_name;?></a></span> &rarr; <?php echo lang('streams:view_options');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

<?php echo form_open(uri_string(), 'class="crud form-horizontal"'); ?>

<div class="form_inputs">

		<div class="control-group">
			<label class="control-label" for="stream_name"><?php echo lang('streams:id');?></label>
			<div class="input controls"><input type="checkbox" name="view_options[]" id="stream_name" value="id"<?php if(in_array('id', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="created"><?php echo lang('streams:created_date');?></label>
			<div class="input controls"><input type="checkbox" name="view_options[]" id="created" value="created"<?php if(in_array('created', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="updated"><?php echo lang('streams:updated_date');?></label>
			<div class="input controls"><input type="checkbox" name="view_options[]" id="updated" value="updated"<?php if(in_array('updated', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="created_by"><?php echo lang('streams:created_by');?></label>
			<div class="input controls"><input type="checkbox" name="view_options[]" id="created_by" value="created_by"<?php if(in_array('created_by', $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</div>
		
	<?php if( $stream_fields ): ?>
	
	<?php foreach( $stream_fields as $stream_field ): ?>

		<div class="control-group">
			<label class="control-label" for="<?php echo $stream_field->field_slug;?>"><?php echo $stream_field->field_name;?></label>
			<div class="input controls"><input type="checkbox" name="view_options[]" id="<?php echo $stream_field->field_slug;?>" value="<?php echo $stream_field->field_slug;?>"<?php if(in_array($stream_field->field_slug, $stream->view_options)): echo ' checked '; endif; ?>/></div>
		</div>
		
	<?php endforeach; ?>
	
	<?php endif; ?>
				
</div>

		<button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	
<?php echo form_close();?>
                    </div>
            </div>
        </div>
    </div>
</div>