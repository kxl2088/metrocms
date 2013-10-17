<div class="control-group streams_param_input">
	<label class="control-label" for="<?php echo $input_slug ?>"><?php echo $input_name ?>
	<?php if( isset($instructions) and $instructions ): ?>
		<br /><small><?php echo $instructions ?></small>
	<?php endif ?>
	</label>
	<div class="input controls"><?php echo $input ?></div>
</div>