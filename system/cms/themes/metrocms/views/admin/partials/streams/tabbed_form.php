<?php echo form_open_multipart(uri_string(), 'class="streams_form form-horizontal"'); ?>

<div class="tab-widget">

	<ul class="nav nav-tabs">
	<?php foreach($tabs as $tab): ?>
		<li>
			<a href="#<?php echo $tab['id']; ?>" title="<?php echo $tab['title']; ?>">
				<span><?php echo $tab['title']; ?></span>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>

        <div class="tab-content">
            <?php foreach($tabs as $tab): ?>
            <div class="form_inputs tab-pane" id="<?php echo $tab['id']; ?>">
                    <fieldset>

                            <?php foreach( $tab['fields'] as $field ) { ?>

                                    <div class="control-group <?php echo in_array($fields[$field]['input_slug'], $hidden) ? 'hidden' : null; ?>">
                                            <label class="control-label" for="<?php echo $fields[$field]['input_slug'];?>"><?php echo $this->fields->translate_label($fields[$field]['input_title']);?> <?php echo $fields[$field]['required'];?>

                                            <?php if( $fields[$field]['instructions'] != '' ): ?>
                                                    <br /><small><?php echo $this->fields->translate_label($fields[$field]['instructions']); ?></small>
                                            <?php endif; ?>
                                            </label>

                                            <div class="input controls"><?php echo $fields[$field]['input']; ?></div>
                                    </li>

                            <?php } ?>

                    </fieldset>

            </div>
            <?php endforeach; ?>
        </div>

</div>

	<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url(isset($return) ? $return : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	</div>

<?php echo form_close();?>