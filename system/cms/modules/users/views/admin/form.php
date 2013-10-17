<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <?php if ($this->method === 'create'): ?>
                            <h3><?php echo lang('user:add_title') ?></h3>
                    <?php else: ?>
                            <h3><?php echo sprintf(lang('user:edit_title'), $member->username) ?></h3>
                    <?php endif ?>
            </div>
            <div class="widget-container">

                    <div class="content">
                    <?php if ($this->method === 'create'): ?>
                            <?php echo form_open_multipart(uri_string(), 'class="crud form-horizontal" autocomplete="off"') ?>
                    <?php else: ?>
                            <?php echo form_open_multipart(uri_string(), 'class="crud form-horizontal"') ?>
                            <?php echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
                    <?php endif ?>
                            <div class="tab-widget">

                                    <ul class="nav nav-tabs">
                                            <li><a href="#user-basic-data-tab"><span><?php echo lang('profile_user_basic_data_label') ?></span></a></li>
                                            <li><a href="#user-profile-fields-tab"><span><?php echo lang('user:profile_fields_label') ?></span></a></li>
                                    </ul>
                                
                                <div class="tab-content">
                                    
                                    <!-- Content tab -->
                                    <div class="form_inputs tab-pane" id="user-basic-data-tab">
                                            <fieldset>
                                                            <div class="control-group">
                                                                    <label class="control-label" for="email"><?php echo lang('global:email') ?> <span>*</span></label>
                                                                    <div class="input controls">
                                                                            <?php echo form_input('email', $member->email, 'id="email"') ?>
                                                                    </div>
                                                            </div>

                                                            <div class="control-group">
                                                                    <label class="control-label" for="username"><?php echo lang('user:username') ?> <span>*</span></label>
                                                                    <div class="input controls">
                                                                            <?php echo form_input('username', $member->username, 'id="username"') ?>
                                                                            <?php if( $member->username != 'admin' OR $member->id != 1): echo anchor(current_url() . '#', lang('user_generate_username_label'), 'id="generate_username" class="btn btn-primary"'); endif; ?>
                                                                    </div>
                                                            </div>

                                                            <?php 
                                                            if (function_exists('group_has_role')):

                                                                    if(group_has_role('permissions', 'set_permissions') AND group_has_role('groups', 'admin_groups')):
                                                            ?>        
                                                            <div class="control-group">
                                                                    <label class="control-label" for="group_id"><?php echo lang('user:group_label');?></label>
                                                                    <div class="input controls">
                                                                    <?php echo form_dropdown('group_id', array('' => lang('global:select-pick')) + $groups_select, empty($member->group_id) ? 2 : $member->group_id, 'id="group_id"'); ?>
                                                                    </div>
                                                            </div>
                                                            <?php  
                                                                    else:
                                                            ?>
                                                            <div class="control-group">
                                                                    <label class="control-label" for="group_id"><?php echo lang('user:group_label');?></label>
                                                                    <div class="input controls">
                                                                    <?php echo form_hidden('group_id', empty($member->group_id) ? 2 : $member->group_id, 'id="group_id"'); ?>    
                                                                        <strong><?php echo empty($member->group_id) ? $groups_select[2] : $groups_select[$member->group_id]; ?></strong>
                                                                    </div>
                                                            </div>
                                                            <?php
                                                                    endif;
                                                            endif;
                                                            ?>

                                                            <div class="control-group">
                                                                    <label class="control-label" for="active"><?php echo lang('user:activate_label') ?></label>
                                                                    <div class="input controls">
                                                                            <?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
                                                                            <?php echo form_dropdown('active', $options, $member->active, 'id="active"') ?>
                                                                    </div>
                                                            </div>
                                                            <div class="control-group">
                                                                    <label class="control-label" for="password">
                                                                            <?php echo lang('global:password');?> <span id="passwd_genereated"></span>
                                                                            <?php if ($this->method == 'create'): ?> <span>*</span><?php endif; ?>
                                                                    </label>
                                                                    <div class="input controls">
                                                                            <?php echo form_password('password', '', 'id="password" autocomplete="off"'); ?> 
                                                                            <?php echo anchor(current_url() . '#', lang('user_generate_password_label'), 'id="generate_passwd" class="btn btn-warning"'); ?>
                                                                    </div>
                                                            </div>
                                            </fieldset>
                                    </div>

                                    <div class="form_inputs tab-pane" id="user-profile-fields-tab">

                                            <fieldset>
                                                            <div class="control-group">
                                                                    <label class="control-label" for="display_name"><?php echo lang('profile_display_name') ?> <span>*</span></label>
                                                                    <div class="input controls">
                                                                            <?php echo form_input('display_name', $display_name, 'id="display_name"') ?>
                                                                    </div>
                                                            </div>
                                                            <?php foreach ($profile_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>
                                            </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="buttons">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
                            </div>
                            <?php echo form_close() ?>
                    </div>
            </div>
        </div>
    </div>
</div>