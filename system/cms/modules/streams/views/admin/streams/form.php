<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
        <?php if($method == 'new'): ?>
                <h3><?php echo lang('streams:add_stream');?></h3>
        <?php else: ?>
                <h3><?php echo lang('streams:edit_stream');?></h3>
        <?php endif; ?>
            </div>
            
<?php echo form_open(uri_string(), 'class="crud form-horizontal"'); ?>
            <div class="widget-container">
                    <div class="content">

                        <div class="form_inputs">

                                <div class="control-group">
                                        <label class="control-label" for="stream_name"><?php echo lang('streams:stream_name'); ?> <span>*</span></label>
                                        <div class="input controls"><?php echo form_input('stream_name', $stream->stream_name, 'maxlength="60" autocomplete="off" id="stream_name"'); ?></div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="about"><?php echo lang('streams:about_stream'); ?><small><?php echo lang('streams:about_instructions'); ?></small></label>
                                        <div class="input controls"><?php echo form_input('about', $stream->about, 'maxlength="255"'); ?></div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="stream_slug"><?php echo lang('streams:stream_slug'); ?> <span>*</span><small><?php echo lang('streams:slug_instructions'); ?></small></label>
                                        <div class="input controls"><?php echo form_input('stream_slug', $stream->stream_slug, 'maxlength="60" id="stream_slug"'); ?></div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="stream_slug"><?php echo lang('streams:stream_prefix'); ?> <small><?php echo lang('streams:prefix_instructions'); ?></small></label>
                                        <div class="input controls"><?php echo form_input('stream_prefix', $stream->stream_prefix, 'maxlength="60" id="stream_prefix"'); ?></div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="stream_slug"><?php echo lang('streams:menu_path'); ?> <small><?php echo lang('streams:menu_path_instructions'); ?></small></label>
                                        <div class="input controls"><?php echo form_input('menu_path', $stream->menu_path, 'maxlength="255" id="menu_path"'); ?></div>
                                </div>


                                <?php if( $method == 'edit' ): ?>

                                <div class="control-group">
                                        <label class="control-label" for="title_column"><?php echo lang('streams:title_column');?></label>
                                        <div class="input controls"><?php echo form_dropdown('title_column', $fields, $stream->title_column); ?></div>
                                </div>

                                <div class="control-group">
                                        <label class="control-label" for="sorting"><?php echo lang('streams:sort_method');?></label>
                                        <div class="input controls"><?php echo form_dropdown('sorting', array('title'=>lang('streams:by_title_column'), 'custom'=>lang('streams:manual_order')), $stream->sorting); ?></div>
                                </div>

                                <?php endif; ?>

                        </div>
                                                
                        <div class="pull-right buttons">
                                <button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	

                                <?php if($this->uri->segment(3)=='add'): ?>

                                        <a href="<?php echo site_url('admin/streams'); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>

                                <?php else: ?>

                                        <a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>" class="btn btn-primary"><?php echo lang('buttons:cancel'); ?></a>

                                <?php endif; ?>
                        </div>
                    </div>
              </div>
<?php echo form_close();?>	
       </div>
    </div>
</div>