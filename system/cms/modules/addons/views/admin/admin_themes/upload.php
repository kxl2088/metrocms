<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('addons:themes:upload_title');?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                            <?php echo form_open_multipart('admin/addons/admin_themes/upload', array('class' => 'crud form-horizontal', 'target' => '_parent')) ?>

                                            <div class="control-group">
                                                    <h4><?php echo lang('addons:themes:upload_desc') ?></h4>
                                            </div>

                                            <div class="control-group">
                               
                                                    <input type="file" name="userfile" />
                                                                                           
                                            </div>
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload'))) ?>

                            <?php echo form_close() ?>

                    </div>
            </div>
        </div>
    </div>
</div>