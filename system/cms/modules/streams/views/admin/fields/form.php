<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
            <?php if($method == 'new'): ?>
                    <h3><?php echo lang('streams:add_field'); ?></h3>
            <?php else: ?>
                    <h3><?php echo lang('streams:edit_field'); ?></h3>
            <?php endif; ?>
            </div>

            <div class="widget-container">
                    <div class="content">

<?php echo form_open(uri_string(), 'class="form-horizontal"'); ?>

<input type="hidden" name="fields_current_namespace" id="fields_current_namespace" value="<?php echo $this->config->item('streams:core_namespace');?>" />
<input type="hidden" name="field_namespace" id="field_namespace" value="<?php echo $this->config->item('streams:core_namespace');?>" />

                <div class="form_inputs">

                                <div class="control-group">
                                        <label class="control-label"  for="field_name"><?php echo lang('streams:label.field_name');?> <span>*</span></label>
                                        <div class="input controls"><?php echo form_input('field_name', $field->field_name, 'maxlength="60" id="field_name" autocomplete="off"'); ?></div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label"  for="field_slug"><?php echo lang('streams:label.field_slug');?> <span>*</span></label>
                                        <div class="input controls"><?php echo form_input('field_slug', $field->field_slug, 'maxlength="60" id="field_slug"'); ?></div>
                                </div>

                                <?php

                                        // We send some special params in an edit situation
                                        $ajax_url = 'streams/ajax/build_parameters';	

                                        if ($this->uri->segment(4) == 'edit')
                                        {
                                                $ajax_url .= '/edit/'.$current_field->id;
                                        }

                                ?>

                                <div class="control-group">
                                        <label class="control-label"  for="field_type"><?php echo lang('streams:label.field_type'); ?> <span>*</span></label>
                                        <div class="input controls"><?php echo form_dropdown('field_type', $field_types, $field->field_type, 'data-placeholder="'.lang('streams:choose_a_field_type').'" id="field_type" onchange="add_field_parameters();"'); ?></div>
                                </div>

                                <div id="parameters">

                                <?php if( $method == "edit" or isset($current_type->custom_parameters) ): ?>

                                <?php

                                $data = array();

                                $data['count'] = 0;

                                if (isset($current_type->custom_parameters))
                                {
                                        foreach ($current_type->custom_parameters as $param)
                                        {
                                                // Sometimes these values may not be set. Let's set
                                                // them to null if they are not.
                                                $value = (isset($current_field->field_data[$param])) ? $current_field->field_data[$param] : null;

                                                if (method_exists($current_type, 'param_'.$param))
                                                {
                                                        $call = 'param_'.$param;

                                                        $input = $current_type->$call($value, $current_field->field_namespace, $current_field);

                                                        if (is_array($input))
                                                        {
                                                                $data['input'] 			= $input['input'];
                                                                $data['instructions']	= $input['instructions'];
                                                        }
                                                        else
                                                        {
                                                                $data['input'] 			= $input;
                                                                $data['instructions']	= null;
                                                        }

                                                        $data['input_name']			= $this->lang->line('streams:'.$this->type->types->{$current_field->field_type}->field_type_slug.'.'.$param);
                                                }	
                                                elseif (method_exists($parameters, $param))
                                                {		
                                                        $data['input'] 				= $parameters->$param($value);
                                                        $data['input_name']			= $this->lang->line('streams:'.$param);
                                                }

                                                $data['input_slug']		= $param;

                                                echo $this->load->view('streams_core/extra_field', $data, TRUE);

                                                $data['count']++;
                                                unset($value);
                                        }
                                }

                                ?>

                                <?php endif; ?>

                                </div>

                </div>
		
		<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url('admin/streams/fields'); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	</div>
	
<?php echo form_close();?>
                    </div>
            </div>
        </div>
    </div>
</div>
