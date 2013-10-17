<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">

<?php if($this->method == 'edit' and ! empty($email_template)): ?>
            <div class="widget-head blue">
            <h3><?php echo sprintf(lang('templates:edit_title'), $email_template->name) ?></h3>
            </div>
<?php else: ?>
            <div class="widget-head blue">
            <h3><?php echo lang('templates:create_title') ?></h3>
            </div>
<?php endif ?>

            <div class="widget-container">
                    <div class="content">
                    <?php echo form_open(current_url(), 'class="crud form-horizontal"') ?>

                            <div class="form_inputs">

                                            <?php if ( ! $email_template->is_default): ?>
                                            <div class="control-group">
                                                    <label class="control-label" for="name"><?php echo lang('name_label') ?> <span>*</span></label>
                                                    <div class="input controls"><?php echo form_input('name', $email_template->name) ?></div>
                                            </div>

                                            <div class="control-group">
                                                    <label class="control-label" for="slug"><?php echo lang('templates:slug_label') ?> <span>*</span></label>
                                                    <div class="input controls"><?php echo form_input('slug', $email_template->slug) ?></div>
                                            </div>

                                            <div class="control-group">
                                                    <label class="control-label" for="lang"><?php echo lang('templates:language_label') ?></label>
                                                    <div class="input controls"><?php echo form_dropdown('lang', $lang_options, array($email_template->lang)) ?>
                                                    </div>
                                            </div>

                                            <div class="control-group">
                                                    <label class="control-label" for="description"><?php echo lang('desc_label') ?> <span>*</span></label>
                                                    <div class="input controls"><?php echo form_input('description', $email_template->description) ?></div>
                                            </div>

                                            <?php endif ?>
                                            <div class="control-group">
                                                    <label class="control-label" for="subject"><?php echo lang('templates:subject_label') ?> <span>*</span></label>
                                                    <div class="input controls"><?php echo form_input('subject', $email_template->subject) ?></div>
                                            </div>

                                            <div class="control-group">
                                                    <label class="control-label" for="body"><?php echo lang('templates:body_label') ?> <span>*</span></label>
                                                    <div class="input controls">
                                                    <?php echo form_textarea('body', $email_template->body, 'class="templates wysiwyg-advanced"') ?>
                                                    </div>
                                            </div>

                                    </ul>

                                    <div class="buttons padding-top">
                                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
                                    </div>


                    <?php echo form_close() ?>
                    </div>
            </div>
       </div>
    </div>
</div>