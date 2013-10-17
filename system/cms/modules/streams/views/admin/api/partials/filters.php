<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		<ul>
			<li class="">
                                <label for="f_enabled"><?php echo lang('streams:enabled_label') ?></label>
                                <?php echo form_dropdown('f_enabled', array('all' => lang('global:select-all'), 'yes'=>lang('global:yes'), 'no'=>lang('global:no'))) ?>
                        </li>

			<li class="">
				<label for="f_keywords"><?php echo lang('global:keywords') ?></label>
				<?php echo form_input('f_keywords', '', '') ?>
			</li>

			<li class="">
				<?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="button red"') ?>
			</li>
		</ul>
	<?php echo form_close() ?>
</fieldset>