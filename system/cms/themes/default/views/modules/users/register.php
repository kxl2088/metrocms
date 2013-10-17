{{ theme:partial name="header" }}
<div class="container">
    <div class="row">
<div class="col-lg-12">
    <h2 class="page-title" id="page_title"><?php echo lang('user:register_header') ?></h2>

    <div class="workflow_steps">
            <span id="active_step"><?php echo lang('user:register_step1') ?></span> /
            <span><?php echo lang('user:register_step2') ?></span>
    </div>

    <?php if ( ! empty($error_string)):?>
    <div class="alert alert-danger">
            <?php echo $error_string;?>
    </div>
    <?php endif;?>

    <?php if( Settings::get('enable_maskedinputplugin_user') ): ?>
    <script src="<?php echo site_url('users/masked_settings'); ?>"></script>
    <?php endif; ?>

    <?php echo form_open('register', array('id' => 'register')) ?>

    <ul>

            <?php if ( ! Settings::get('auto_username')): ?>
            <li>
                    <label for="username"><?php echo lang('user:username') ?></label>
                    <input type="text" name="username" maxlength="100" value="<?php echo $_user->username ?>" class="form-control" />
            </li>
            <?php endif ?>

            <li>
                    <label for="email"><?php echo lang('global:email') ?></label>
                    <input type="text" name="email" maxlength="100" value="<?php echo $_user->email ?>" class="form-control" />
                    <?php echo form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"') ?>
            </li>

            <li>
                    <label for="password"><?php echo lang('global:password') ?></label>
                    <input type="password" name="password" maxlength="100" class="form-control" />
            </li>

            <li>
                    <label for="password2"><?php echo lang('user:password_confirm_label') ?></label>
                    <input type="password" name="password2" maxlength="100" class="form-control" />
            </li>

            <?php foreach($profile_fields as $field) { if($field['required'] and $field['field_slug'] != 'display_name') { ?>
            <li>
                    <label for="<?php echo $field['field_slug'] ?>"><?php echo (lang($field['field_name'])) ? lang($field['field_name']) : $field['field_name'];  ?></label>
                    <?php 
                            echo str_replace(array(
                                '<input type="text"',
                            ), array(
                                '<input type="text" class="form-control"',
                            ), $field['input']);
                    ?>
            </li>
            <?php } } ?>

            <?php if ( Settings::get('enable_recaptcha') AND Settings::get('recaptcha_public_key') AND Settings::get('recaptcha_private_key') ): ?>
            <li>
                    <label for="recaptcha_response_field"><?php echo lang('user_security_key'); ?></label>
                    <div class="input recaptcha"><?php echo recaptcha_get_html(Settings::get('recaptcha_public_key')); ?></div>
            </li>
            <?php endif; ?>

            <li>
                    <?php echo form_submit('btnSubmit', lang('user:register_btn')) ?>
            </li>
    </ul>
    <?php echo form_close() ?>
</div>
    </div>
</div>