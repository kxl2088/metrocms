<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('streams:sure');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

<?php if( $total_fields == 1 ):

	$field_word = lang('streams:field_singular');

else:

	$field_word = lang('streams:field_plural');

endif; ?>

<p><?php echo sprintf( lang('streams:delete_summary'), $stream->stream_name, $total_fields, $field_word ); ?></p>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="buttons">

	<button type="submit" name="action" value="save" class="btn btn-danger"><span><?php echo lang('streams:yes_delete');?> "<?php echo $stream->stream_name;?>"</span></button>

	<a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>" class="btn btn-primary"><span><?php echo lang('streams:no_thanks');?></span></a>
	
</div><!--.buttons-->

<?php echo form_close();?>	

                    </div>
            </div>
        </div>
    </div>
</div>