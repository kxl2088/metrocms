<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>"><?php echo $stream->stream_name;?></a></span> &rarr; <?php echo $perm_lang;?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

<?php if ($groups): ?>

<?php echo form_open(uri_string(), 'class="crud form-horizontal"'); ?>

<div class="form_inputs">

	<?php foreach ($groups as $group ): ?>

		<div class="control-group">
			<label class="control-label" for="<?php echo $group->name; ?>"><?php echo $group->description; ?></label>
			<div class="input controls"><input type="checkbox" name="groups[]" id="<?php echo $group->name; ?>" value="<?php echo $group->group_id; ?>"<?php if (in_array($group->group_id, $permissions)): echo ' checked '; endif; ?>/></div>
		</div>
		
	<?php endforeach; ?>
		
					
</div>

<input type="hidden" name="edited" value="y">

<button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
<a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	
<?php echo form_close();?>

<?php else: ?>

<div class="no_data"><?php echo lang('streams:no_group_eliguibe'); ?></div>

<?php endif; ?>

                    </div>
            </div>
        </div>
    </div>
</div>