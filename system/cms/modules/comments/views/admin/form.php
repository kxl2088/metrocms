<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo sprintf(lang('comments:edit_title'), $comment->id) ?></h3>
            </div>

                <div class="widget-container">
                    <div class="content">
                    <?php echo form_open($this->uri->uri_string(), 'class="form_inputs"') ?>

                            <?php echo form_hidden('user_id', $comment->user_id) ?>
                            <?php echo form_hidden('active', $comment->is_active) ?>

                                    <?php if ( ! $comment->user_id): ?>
                                    <div class="control-group">
                                            <label class="control-label" for="user_name"><?php echo lang('comments:name_label') ?>:</label>
                                            <div class="input controls">
                                                    <?php echo form_input('user_name', $comment->user_name, 'maxlength="100"') ?>
                                            </div>
                                    </div>

                                    <div class="control-group">
                                            <label class="control-label" for="user_email"><?php echo lang('global:email') ?>:</label>
                                            <div class="input controls">
                                                    <?php echo form_input('user_email', $comment->user_email, 'maxlength="100"') ?>
                                            </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="control-group">
                                            <label class="control-label" for="user_name"><?php echo lang('comments:name_label') ?>:</label>
                                            <div class="input controls"><?php echo $comment->user_name ?></div>
                                    </div>
                                    <div class="control-group">
                                            <label class="control-label" for="user_email"><?php echo lang('global:email') ?>:</label>
                                            <div class="input controls"><?php echo $comment->user_email ?></div>
                                    </div>
                                    <?php endif ?>

                                    <div class="control-group">
                                            <label class="control-label" for="user_website"><?php echo lang('comments:website_label') ?>:</label>
                                            <div class="input controls">
                                                    <?php echo form_input('user_website', $comment->user_website) ?>
                                            </div>
                                    </div>

                                    <div class="control-group">
                                            <label class="control-label" for="comment"><?php echo lang('comments:message_label') ?>:</label><br />
                                            <div class="input controls">
                                                <?php echo form_textarea(array('name'=>'comment', 'value' => $comment->comment, 'rows' => 5)) ?>
                                            </div>
                                    </div>

                            <div class="buttons float-right padding-top">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                            </div>

                    <?php echo form_close() ?>                        
                </div>
          </div>
        </div>
    </div>
</div>