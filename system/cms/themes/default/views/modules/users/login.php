{{ theme:partial name="header" }}
<div class="container">
    <div class="row">
<?php echo form_open('users/login', array('id'=>'main_login', 'class'=>'form-signin'), array('redirect_to' => $redirect_to)) ?>

    <?php if (validation_errors()): ?>
    <div class="alert alert-danger">
            <?php echo validation_errors();?>
    </div>
    <?php endif ?>

    <h2 class="form-signin-heading"><?php echo lang('user:login_header') ?></h2>
    <input type="text" name="email" class="form-control" placeholder="<?php echo lang('global:email') ?>" autofocus>
    <input type="password" name="password" class="form-control" placeholder="<?php echo lang('global:password') ?>">
    <label class="checkbox">
      <input type="checkbox" name='remember' value="1"> <?php echo lang('user:remember') ?>
    </label>
    <div>
      <?php echo anchor('users/reset_pass', lang('user:reset_password_link'));?>  
      <?php if (Settings::get('enable_registration')): ?>
      | <?php echo anchor('users/register', lang('user:register_btn'));?>
      <?php endif ?> 
    </div>
    <div class="btn-submit">
        <button class="btn btn-large btn-primary btn-block" type="submit"><?php echo lang('user:login_btn') ?></button>
    </div>

<?php echo form_close() ?>
    </div>
</div>