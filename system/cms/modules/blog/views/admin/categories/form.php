<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
                    <h3><?php echo sprintf(lang('cat:edit_title'), $category->title);?></h3>
                    <?php else: ?>
                    <h3><?php echo lang('cat:create_title');?></h3>
                    <?php endif ?>
            </div>

            <div class="widget-container">
                <div class="content">
                <?php echo form_open($this->uri->uri_string(), 'class="crud form-horizontal'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>
                <?php echo  form_hidden('id', $category->id) ?>

                <div class="form_inputs">

                            <div class="control-group">
                                    <label class="control-label" for="title"><?php echo lang('global:title');?> <span>*</span></label>
                                    <div class="input controls"><?php echo  form_input('title', $category->title) ?></div>       
                            </div>                          

                </div>

                        <div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?></div>

                <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>