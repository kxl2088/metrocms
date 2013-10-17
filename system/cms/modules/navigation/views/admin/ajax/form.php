<div id="details-container">
	<?php if ($this->method == 'create'): ?>
		<div class="hidden" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo lang('nav:link_create_title');?>
		</div>
	<?php else: ?>
		<div class="hidden" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo sprintf(lang('nav:link_edit_title'), $link->title);?>
		</div>
	<?php endif ?>
	
	<?php echo form_open(uri_string(), 'id="nav-' . $this->method . '" class="navigation-module form-horizontal"') ?>
                <div class="form_inputs">
<?php if ($this->method == 'edit'): ?>
			<?php echo form_hidden('link_id', $link->id) ?>
<?php endif ?>

			<?php echo form_hidden('current_group_id', $link->navigation_group_id) ?>
			    
			<div class="control-group">
				<label class="control-label" for="title"><?php echo lang('global:title');?> <span>*</span></label>
                                <div class="input controls">
                                    <?php echo form_input('title', $link->title, 'maxlength="50" class="text"') ?>
                                </div>
			</div>
			
                        <div class="control-group">
				<label class="control-label" for="lang"><?php echo lang('global:lang');?></label>
                                <div class="input controls">
                                    <?php echo form_input('lang', $link->lang, 'maxlength="255" class="text"') ?>
                                </div>
			</div>
                        
			<?php if ($this->method == 'edit'): ?>
				<div class="control-group">
					<label class="control-label" for="navigation_group_id"><?php echo lang('nav:group_label');?></label>
                                        <div class="input controls">
                                            <?php echo form_dropdown('navigation_group_id', $groups_select, $link->navigation_group_id) ?>
                                        </div>
				</div>
			<?php else: ?>
				<?php echo form_hidden('navigation_group_id', $link->navigation_group_id) ?>
			<?php endif ?>
	
			<div class="control-group">
				<label class="control-label" for="link_type"><?php echo lang('nav:type_label');?></label>
                                <div class="input controls">
                                    <span class="spacer-right">
                                            <?php echo form_radio('link_type', 'url', $link->link_type == 'url') ?> <?php echo lang('nav:url_label');?>
                                            <?php echo form_radio('link_type', 'uri', $link->link_type == 'uri') ?> <?php echo lang('nav:uri_label');?>
                                            <?php echo form_radio('link_type', 'module', $link->link_type == 'module') ?> <?php echo lang('nav:module_label');?>
                                            <?php echo form_radio('link_type', 'page', $link->link_type == 'page') ?> <?php echo lang('nav:page_label');?>
                                    </span>
                                </div>
			</div>

			<div class="control-group link-types">
	
				<p style="<?php echo ! empty($link->link_type) ? 'display:none' : '' ?>">
					<?php echo lang('nav:link_type_desc') ?>
				</p>
	
				<div id="navigation-url" style="<?php echo @$link->link_type == 'url' ? '' : 'display:none' ?>">
					<label class="control-label" class="label" for="url"><?php echo lang('nav:url_label');?></label>
                                        <div class="inputs controls">
                                            <input type="text" id="url" name="url" value="<?php echo empty($link->url) ? 'http://' : $link->url ?>" />
                                        </div>
				</div>
	
				<div id="navigation-module" style="<?php echo @$link->link_type == 'module' ? '' : 'display:none' ?>">
					<label class="control-label" class="label" for="module_name"><?php echo lang('nav:module_label');?></label>
                                        <div class="inputs controls">
                                            <?php echo form_dropdown('module_name', array(lang('nav:link_module_select_default'))+$modules_select, $link->module_name) ?>
                                        </div>
				</div>
	
				<div id="navigation-uri" style="<?php echo @$link->link_type == 'uri' ? '' : 'display:none' ?>">
					<label class="control-label" class="label" for="uri"><?php echo lang('nav:uri_label');?></label>
                                        <div class="inputs controls">
                                            <input type="text" id="uri" name="uri" value="<?php echo $link->uri ?>" />
                                        </div>
				</div>
	
				<div id="navigation-page" style="<?php echo @$link->link_type == 'page' ? '' : 'display:none' ?>">
					<label class="control-label" class="label" for="page_id"><?php echo lang('nav:page_label');?></label>
                                        <div class="inputs controls">
                                            <select name="page_id">
                                                    <option value=""><?php echo lang('global:select-pick');?></option>
                                                    <?php echo $tree_select ?>
                                            </select>
                                        </div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="target"><?php echo lang('nav:target_label') ?></label>
				<div class="input controls">
                                    <?php echo form_dropdown('target', array(''=> lang('nav:link_target_self'), '_blank' => lang('nav:link_target_blank')), $link->target) ?>
                                </div>
			</div>

			<div class="control-group">
				<label class="control-label" for="restricted_to[]"><?php echo lang('nav:restricted_to');?></label>
                                <div class="input controls">
                                    <?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $link->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?>
                                </div>
			</div>
	
			<div class="control-group">
				<label class="control-label" for="class"><?php echo lang('nav:class_label') ?></label>
                                <div class="input controls">
                                    <?php echo form_input('class', $link->class) ?>
                                </div>
			</div>
                </div>
		<div class="buttons float-left padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>
</div>
<script>
		// Pick a rule type, show the correct field
		$('input[name="link_type"]').change( function(){
			$('.link-types').find('#navigation-' + $(this).val())

			// Show only the selected type
			.show().siblings().hide()

			// Reset values when switched
			.find('input:not([value="http://"]), select').val('');

		// Trigger default checked
		}).filter(':checked').change();
                
                // submit create form via ajax
		$('#nav-create button:submit').click( function(e){
			e.preventDefault();
			$.post(SITE_URL + 'admin/navigation/create', $('#nav-create').serialize(), function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('div#content-body').prepend(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});
		});

		// submit edit form via ajax
		$('#nav-edit button:submit').click( function(e){
			e.preventDefault();
			$.post(SITE_URL + 'admin/navigation/edit/' + $('input[name="link_id"]').val(), $('#nav-edit').serialize(), function(message){

				// if message is simply "success" then it's a go. Refresh!
				if (message == 'success') {
					window.location.href = window.location
				}
				else {
					$('.notification').remove();
					$('div#content-body').prepend(message);
					// Fade in the notifications
					$(".notification").fadeIn("slow");
				}
			});

		});
</script>