<div class="row-fluid ">
        <div class="span2">
          <div class="profile-thumb"> 
              <?php if(avatar($_user->email)): ?>
                <?php echo avatar($_user->email, 300, 'fit', false, array('alt' => $_user->display_name, 'class' => 'img-polaroid')); ?>
              <?php else: ?>
              <div class="img-polaroid no_avatar"><i class="icon-user"></i></div>
              <?php endif; ?>
            <ul class="list-item">
              <li><a href="<?php echo base_url('admin/profile'); ?>"><i class="icon-user"></i> <?php echo lang('global:my_profile'); ?> </a></li>
              <li><a href="<?php echo base_url('admin/profile/edit'); ?>"><i class="icon-pencil"></i> <?php echo lang('edit_profile_label'); ?> </a></li>
              <li><a href="<?php echo base_url('admin/profile/change_password'); ?>"><i class="icon-lock"></i> <?php echo lang('user:password_section'); ?></a></li>
            </ul>
          </div>
        </div>        
        <div class="span10">
            <?php if($method == 'profile'): ?>
            <div class="profile-info">
                
              <div class="tab-widget">
                <ul class="nav nav-tabs" id="myTab1">
                    <li class="active"><a href="#user"><i class="icon-user"></i> <?php echo sprintf(lang('profile_of_title'), $_user->display_name); ?></a></li>


                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="user">
                  <div class=" information-container">
                    <?php if($_user->bio): ?>
                    <h4><?php echo lang('profile_bio'); ?></h4>
                    <p>
                        <?php echo $_user->bio; ?>
                    </p>
                    <?php endif; ?>
                    <h4><?php echo lang('profile_user_details_label'); ?></h4>
                    <ul class="profile-intro">
                        <?php foreach ($profile_fields as $profile): ?>
                        <?php if($profile['slug'] != 'avatar' AND (!empty($profile['value']))): ?>
                        <li>
                            <label><?php echo $profile['name']; ?></label> <?php echo $profile['value']; ?>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                </div>    
                  </div>


                </div>
              </div>
            </div>
            <?php elseif($method == 'profile_edit'): ?>
            <?php echo form_open_multipart(uri_string(), 'class="crud form-horizontal"') ?>
            <?php echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
            <?php echo form_hidden('group_id', empty($member->group_id) ? 2 : $member->group_id); ?>
            <?php echo form_hidden('active', $member->active) ?>
            <?php echo form_hidden('username', $member->username) ?>  
            <?php echo form_hidden('email', $member->email) ?>
            <div class="profile-info">
              <div class="tab-widget">
                <ul class="nav nav-tabs" id="myTab1">
                    <li class="active"><a href="#profile"><i class="icon-user"></i> <?php echo sprintf(lang('profile_of_title'), $_user->display_name); ?></a></li>
                </ul>
                <div class="tab-content">                    
                    <div class="tab-pane active" id="profile">
                            <div class="control-group">
                                    <label class="control-label" for="display_name"><?php echo lang('profile_display_name') ?> <span>*</span></label>
                                    <div class="input controls">
                                            <?php echo form_input('display_name', $display_name, 'id="display_name"') ?>
                                    </div>
                            </div>
                            <?php foreach ($profile_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>
                        
                        <div class="buttons">
                        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit') )) ?>
                        <?php echo anchor('admin/profile', lang('buttons:cancel'), 'class="btn btn-danger"'); ?>
              </div>  
                  </div>
                </div>
              </div>                       
            </div>
             <?php echo form_close() ?>
            <?php elseif($method == 'change_password'): ?>
            <div class="profile-info">
              <div class="tab-widget">
                <ul class="nav nav-tabs" id="myTab1">
                    <li class="active"><a href="#user"><i class="icon-user"></i> <?php echo sprintf(lang('profile_of_title'), $_user->display_name); ?></a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="user">

                    <h4><?php echo lang('user:reset_password_title'); ?></h4>
                    <?php echo form_open(current_url(), 'class="form-horizontal"'); ?>
                    <div class="control-group">
                            <label class="control-label "><?php echo lang('user:old_password_label'); ?></label>
                            <div class="controls">
                                    <input type="password" name="old_password" value="" placeholder="" >
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label "><?php echo lang('user:new_password_label'); ?></label>
                            <div class="controls">
                                    <input type="password" name="password" value="" placeholder="" >
                            </div>
                    </div>
                    <div class="control-group">
                            <label class="control-label"><?php echo lang('user:password_new_confirm_label'); ?></label>
                            <div class="controls">
                                    <input type="password" name="confirm_password" value="" placeholder="" >
                            </div>
                    </div>
                    <div class="control_buttons">
                        <?php echo form_button(array('name' => 'submit', 'type' => 'submit', 'class' => 'btn btn-primary'), lang('buttons:save')); ?>
                        <?php echo anchor('admin/profile', lang('buttons:cancel'), 'class="btn btn-danger"'); ?>
                    </div>
                    
                    <?php echo form_close(); ?>
           
                  </div>


                </div>
              </div>
            </div>
            <?php endif; ?>
        </div>
      </div>