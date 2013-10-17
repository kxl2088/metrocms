<div class="content-widgets skip gray">
        <div class="widget-head blue">
                <h3>{header}</h3>
        </div>
        <div class="widget-container gray">
                <div class="form-container grid-form form-background">
                        <div class="form-horizontal left-align">
                                {intro_text}
                        </div>
                </div>
        </div>
</div>

<?php echo form_open(uri_string(), 'id="install_frm" class="form-horizontal"'); ?>
<div class="content-widgets skip gray">
        <div class="widget-head blue">
                <h3>{default_user}</h3>
        </div>
        <div class="widget-container gray">
                <div class="form-container grid-form form-background">
                        <div class="form-horizontal left-align">
                                <input type="hidden" id="site_ref" name="site_ref" value="default" />
                                <div class="control-group">
                                        <label class="control-label" for="user_name">{user_name}</label>
                                        <div class="controls"><?php echo form_input(array('id' => 'user_name', 'name' => 'user_name', 'value' => set_value('user_name', 'admin'))); ?></div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label" for="user_firstname">{first_name}</label>
                                        <div class="controls"><?php echo form_input(array('id' => 'user_firstname', 'name' => 'user_firstname', 'value' => set_value('user_firstname'))); ?></div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label" for="user_lastname">{last_name}</label>
                                        <div class="controls"><?php echo form_input(array('id' => 'user_lastname', 'name' => 'user_lastname', 'value' => set_value('user_lastname'))); ?></div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label" for="user_email">{email}</label>
                                        <div class="controls"><?php echo form_input(array('id' => 'user_email', 'name' => 'user_email', 'value' => set_value('user_email'))); ?></div>
                                </div>
                                <div class="control-group">
                                        <label class="control-label" for="user_password">{password}</label>
                                        <div class="controls">
                                                <?php echo form_password(array('id' => 'user_password', 'name' => 'user_password', 'value' => set_value('user_password'))); ?>
                                                <div class="input-append">
                                                    <div id="progressbar"><div id="progress"></div></div>
                                                    <div id="status"><span id="complexity">0% Força</span></div>
                                                </div>
                                        </div>
                                </div>
                                <div class="control-group">
                                    <p class="pull-right">
                                        <input class="btn btn-primary" id="next_step" type="submit" id="submit" value="<?php echo lang('finish'); ?>" />
                                    </p>
                                </div>
                        </div>
                </div>
        </div>
</div>
<?php echo form_close(); ?>