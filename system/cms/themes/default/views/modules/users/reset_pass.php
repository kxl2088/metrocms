{{ theme:partial name="header" }}
<div class="container">
    <div class="row">
<div class="col-lg-12">
    <?php if(!empty($error_string)):?>
            <div class="alert alert-danger">
                    <?php echo $error_string;?>
            </div>
    <?php endif;?>

    <?php if(!empty($success_string)): ?>
            <div class="alert alert-success">
                    <?php echo $success_string ?>
            </div>
    <?php endif; ?>
            
            <h2 class="page-title"><?php echo lang('user:reset_password_title');?></h2>
            
            <?php if(empty($success_string)): ?>
            <?php echo form_open('users/reset_pass', array('id'=>'reset-pass')) ?>

            <div><?php echo lang('user:reset_instructions') ?></div>
            <br />
            </div>

            <div class="col-lg-6">  
                <div class="input-group">
                    <span class="input-group-addon">@</span>
                    <input type="text" name="email" maxlength="100" value="<?php echo set_value('email') ?>" class="form-control" placeholder="<?php echo lang('global:email'); ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <?php echo form_submit('', lang('user:reset_pass_btn'), 'class="btn btn-primary"') ?>
            </div>
            <?php echo form_close() ?>
            <?php endif; ?>
    </div>
</div>