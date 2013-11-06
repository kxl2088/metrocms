	<div class="control-group <?php if(isset($this->type->types->{$field['field_type']}->admin_display) and $this->type->types->{$field['field_type']}->admin_display == 'full'): ?> full_width_input<?php endif; ?>">

		<label class="control-label" for="<?php echo $field['field_slug'];?>"><?php echo $field['field_name'];?> <?php if ($field['required']): ?><span>*</span><?php endif; ?>
		
		<?php if( $field['instructions'] != '' ): ?>
			<br /><small><?php echo ((substr($field['instructions'], 0, 5) === 'lang:' and lang(substr($field['instructions'], 5))) ? lang(substr($field['instructions'], 5)) : $field['instructions']); ?></small>
		<?php endif; ?>
		</label>

		<div class="input controls skip"><?php echo $field['input']; ?></div>

	</div>