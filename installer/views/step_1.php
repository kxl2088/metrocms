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

<?php echo form_open(uri_string(), 'id="install_frm" class="form-horizontal step_1"'); ?>

<div class="content-widgets skip gray">
        <div class="widget-head blue">
                <h3>{db_settings}</h3>
        </div>
        <div class="widget-container gray">
                <div class="form-container grid-form form-background">
                        <div class="form-horizontal left-align">
                                <p>{db_text}</p>
                                <?php if (!$this->installer_lib->mysql_available()): ?>
                                <p class="result fail">{db_missing}</p>
                                <?php endif; ?>

                                        <div class="control-group">
                                                <label for="database" class="control-label">{database}</label>
                                                <div class="controls"><input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" /></div>
                                        </div>

                                        <div class="control-group">
                                                <label for="create_db" class="control-label">{db_create}</label>
                                                <div class="controls"><input type="checkbox" name="create_db" value="true" id="create_db" <?php if($this->input->post('create_db') == 'true') { echo ' checked="checked"'; } ?> />
                                                <small>({db_notice})</small></div>
                                        </div>

                                        <div class="control-group">
                                                <label for="hostname" class="control-label">{server}</label>
                                                <div class="controls"><?php echo form_input(array('id' => 'hostname', 'name' => 'hostname'), set_value('hostname', 'localhost')); ?></div>
                                        </div>

                                        <div class="control-group">
                                                <label for="port" class="control-label">{portnr}</label>
                                                <div class="controls"><?php echo form_input(array('id' => 'port', 'name' => 'port'), set_value('port', $port)); ?></div>
                                        </div>

                                        <div class="control-group">
                                                <label for="username" class="control-label">{username}</label>
                                                <div class="controls"><?php echo form_input(array('id' => 'username', 'name' => 'username'), set_value('username')); ?></div>
                                        </div>

                                        <div class="control-group">
                                                <label for="password" class="control-label">{password}</label>
                                                <div class="controls"><?php echo form_password(array('id' => 'password', 'name' => 'password'), set_value('password')); ?></div>
                                        </div>

                                        <div id="confirm_db"></div>
                        </div>
                </div>
        </div>
</div>

<div class="content-widgets skip gray">
        <div class="widget-head blue">
                <h3>{server_settings}</h3>
        </div>
        <div class="widget-container gray">
                <div class="form-container grid-form form-background">
                        <div class="form-horizontal left-align">
                                <p>{httpserver_text}</p>

                                <div class="control-group">
                                        <label for="http_server"  class="control-label">{httpserver}</label>
                                        <div class="controls"><?php echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"'); ?></div>
                                </div>
                                
                                <div class="control-group">
                                        <input type="hidden" name="installation_step" value="step_1"/>
                                        <p class="pull-right">
                                            <input type="submit" disabled="disabled" id="next_step" value="{step2}" class="button-next btn-primary btn btn-extend">
                                        </p>
                                </div>
                        </div>
                </div>
        </div>
</div>

<?php echo form_close(); ?>
