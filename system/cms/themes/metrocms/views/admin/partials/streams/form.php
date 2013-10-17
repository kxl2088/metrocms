<?php if ($fields): ?>

<?php echo form_open_multipart(uri_string(), 'class="streams_form form-horizontal"'); ?>

<div class="form_inputs">

	<?php foreach ($fields as $field ) { ?>

		<div class="control-group <?php echo in_array($field['input_slug'], $hidden) ? 'hidden' : null; ?>">
			<label class="control-label" for="<?php echo $field['input_slug'];?>"><?php echo $this->fields->translate_label($field['input_title']);?> <?php echo $field['required'];?>
			
			<?php if( $field['instructions'] != '' ): ?>
				<br /><small><?php echo $this->fields->translate_label($field['instructions']); ?></small>
			<?php endif; ?>
			</label>
			
			<div class="input controls"><?php echo $field['input']; ?></div>
		</div>

	<?php } ?>
	

</div>

	<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="float-right buttons">
                <button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
		<?php if ($mode == 'edit'){ ?><button type="submit" name="btnAction" value="save_exit" class="btn btn-primary"><span><?php echo lang('buttons:save_exit'); ?></span></button><?php } ?>
		<a href="<?php echo site_url(isset($return) ? $return : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	</div>

<?php echo form_close();?>

<?php else: ?>

<div class="no_data">
	<?php
		
		if (isset($no_fields_message) and $no_fields_message)
		{
			echo lang_label($no_fields_message);
		}
		else
		{
			echo lang('streams:no_fields_msg_first');
		}

	?>
</div><!--.no_data-->

<?php endif; ?>