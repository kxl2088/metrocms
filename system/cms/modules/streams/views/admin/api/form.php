<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
            <?php if ($this->method == 'add'): ?>
                    <h3><?php echo lang('streams:create_api') ?></h3>
            <?php else: ?>
                    <h3><?php echo sprintf(lang('streams:edit_api'), $application) ?></h3>
            <?php endif ?>
            </div>

            <div class="widget-container">
                    <div class="content">

                <?php echo form_open_multipart('', 'id="edit-permissions" class="form-horizontal"') ?>

                <div class="tab-widget">

                        <ul class="nav nav-tabs">
                                <li><a href="#streams-data-tab"><span><?php echo lang('streams:data_tab') ?></span></a></li>
                                <li><a href="#streams-client-tab"><span><?php echo lang('streams:client_tab') ?></span></a></li>
                                <li><a href="#streams-permissions-tab"><span><?php echo lang('streams:permissions_tab') ?></span></a></li>
                        </ul>
                        
                        <div class="tab-content">
                        
                            <!-- Data tab -->
                            <div class="form_inputs tab-pane" id="streams-data-tab">
                                    <fieldset>
                                                    <div class="control-group">
                                                            <label class="control-label" for="application"><?php echo lang('streams:application_label') ?> <span>*</span></label>
                                                            <div class="input controls"><?php echo form_input('application', set_value('application', $application)) ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="token"><?php echo lang('streams:token_label') ?> <span>*</span></label>
                                                            <div class="input controls">
                                                                <strong><?php echo $token; ?></strong>
                                                                <?php echo form_hidden('token', set_value('token', $token)) ?>
                                                            </div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="expires_on"><?php echo lang('streams:expires_on_label') ?> <span>*</span></label>
                                                            <div class="input controls datetime_input">
                                                                <div id="datetimepicker1" class="input-append date">
                                                                    <?php echo form_input('expires_on', set_value('expires_on', ($expires_on ? $expires_on : date('Y-m-d H:i:s'))), 'maxlength="19" data-format="yyyy-MM-dd hh:mm:ss"') ?>
                                                                    <span class="add-on "><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="control-group">
                                                            <label class="control-label" for="enabled"><?php echo lang('streams:enabled_label') ?> <span>*</span></label>
                                                            <div class="input controls type-radio">
                                                                <label class="control-label" class="inline">
                                                                    <input type="radio" name="enabled" value="yes"<?php echo set_value('enabled', $enabled) == 'yes' ? ' checked="checked"' : '' ?>>
                                                                    <?php echo lang('global:yes'); ?>
                                                                </label> 
                                                                <label class="control-label" class="inline">
                                                                    <input type="radio" name="enabled" value="no"<?php echo set_value('enabled', $enabled) == 'no' ? ' checked="checked"' : '' ?>>
                                                                    <?php echo lang('global:no'); ?>
                                                                </label> 	
                                                            </div>  
                                                    </div>
                                    </fieldset>
                            </div>

                            <!-- Client tab -->
                            <div class="form_inputs tab-pane" id="streams-client-tab">
                                    <fieldset>
                                                    <div class="control-group">
                                                            <label class="control-label" for="contact"><?php echo lang('streams:contact_label') ?> </label>
                                                            <div class="input controls"><?php echo form_input('contact', set_value('contact', $contact)) ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="company"><?php echo lang('streams:company_label') ?> </label>
                                                            <div class="input controls"><?php echo form_input('company', set_value('company', $company)) ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="nip"><?php echo lang('streams:nip_label') ?> </label>
                                                            <div class="input controls"><?php echo form_input('nip', set_value('nip', $nip)) ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="phone"><?php echo lang('streams:phone_label') ?> </label>
                                                            <div class="input controls"><?php echo form_input('phone', set_value('phone', $phone)) ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="email"><?php echo lang('streams:email_label') ?> </label>
                                                            <div class="input controls"><?php echo form_input('email', set_value('email', $email)) ?></div>
                                                    </div>
                                    </fieldset>
                            </div>

                            <!-- Permissions tab -->
                            <div class="form_inputs tab-pane" id="streams-permissions-tab">
                                    <fieldset>
                                                    <div class="control-group">
                                                            <p><?php echo lang('streams:permissions_desc'); ?></p>
                                                            <table class="responsive table table-hover table-striped table-bordered"  >
                                                                    <thead>
                                                                            <tr>
                                                                                    <th style="width: 30px"><?php echo form_checkbox(array('id'=>'check-all', 'name' => 'action_to_all', 'class' => 'check-all')) ?></th>
                                                                                    <th style="width: 200px"><?php echo lang('streams:permission:stream_slug') ?></th>
                                                                                    <th><?php echo lang('streams:permission:stream_namespace') ?></th>
                                                                                    <th style="width: 30%"><?php echo lang('streams:permission:roles') ?></th>
                                                                            </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                            <?php foreach ($permissions_list as $streams): ?>
                                                                            <tr>
                                                                                    <td style="width: 30px">
                                                                                            <?php echo form_checkbox(array(
                                                                                                    'id'=> $streams->stream_slug,
                                                                                                    'class' => 'select-row',
                                                                                                    'value' => true,
                                                                                                    'name'=>'permissions['.$streams->stream_slug.']',
                                                                                                    'checked'=> (isset($permissions[$streams->stream_slug]) AND array_key_exists($streams->stream_slug, $permissions))

                                                                                            )) ?>
                                                                                    </td>
                                                                                    <td>
                                                                                            <label class="inline" for="<?php echo $streams->stream_slug ?>">
                                                                                                    <?php echo $streams->stream_slug ?>
                                                                                            </label>
                                                                                    </td>
                                                                                    <td>
                                                                                            <label class="inline" for="<?php echo $streams->stream_namespace ?>">
                                                                                                    <?php echo $streams->stream_namespace ?>
                                                                                            </label>
                                                                                    </td>
                                                                                    <td>
                                                                                    <?php if ( ! empty($streams->permissions)): ?>
                                                                                            <?php foreach ($streams->permissions as $key => $role): ?>
                                                                                            <label class="inline">
                                                                                                    <?php echo form_checkbox(array(
                                                                                                            'class' => 'select-rule',
                                                                                                            'name' => 'permissions['.$streams->stream_slug.']['.$key.']',
                                                                                                            'value' => true,
                                                                                                            'checked' => isset($permissions[$streams->stream_slug]) AND array_key_exists($key, $permissions[$streams->stream_slug])
                                                                                                    )) ?>
                                                                                                    <?php echo $role; ?>
                                                                                            </label>
                                                                                            <?php endforeach ?>
                                                                                    <?php endif ?>
                                                                                    </td>
                                                                            </tr>
                                                                            <?php endforeach ?>
                                                                    </tbody>
                                                            </table>
                                                    </div>
                                    </fieldset>
                            </div>
                        </div>
                </div>

                <div class="buttons">
                        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
                </div>

                <?php echo form_close() ?>

                    </div>
            </div>
        </div>
    </div>
</div>