<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
            <?php if ($this->method == 'create'): ?>
                    <h3><?php echo lang('blog:create_title') ?></h3>
            <?php else: ?>
                    <h3><?php echo sprintf(lang('blog:edit_title'), $post->title) ?></h3>
            <?php endif ?>
            </div>

            <div class="widget-container">
                <div class="content">

                <?php echo form_open_multipart('', 'class="form-horizontal" id="blog-form" data-mode="'.$this->method.'"') ?>

                <div class="tab-widget">

                        <ul class="nav nav-tabs">
                                <li><a href="#blog-content-tab"><span><?php echo lang('blog:content_label') ?></span></a></li>   
                                <?php if(Settings::get('blog_enable_gallery')): ?><li><a href="#blog-gallery-tab"><span><?php echo lang('blog:gallery_label') ?></span></a></li><?php endif; ?>
                                <li><a href="#blog-options-tab"><span><?php echo lang('blog:options_label') ?></span></a></li>
                                <?php if ($stream_fields): ?><li><a href="#blog-custom-fields"><span><?php echo lang('global:custom_fields') ?></span></a></li><?php endif; ?>  
                        </ul>
                        
                        <div class="tab-content">
                            <!-- Content tab -->
                            <div class="form_inputs tab-pane" id="blog-content-tab">
                                    <fieldset>
                                                    <div class="control-group">
                                                            <label class="control-label" for="title"><?php echo lang('global:title') ?> <span>*</span></label>
                                                            <div class="input controls"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100" id="title"') ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="status"><?php echo lang('blog:status_label') ?></label>
                                                            <div class="input controls"><?php echo form_dropdown('status', array('draft' => lang('blog:draft_label'), 'live' => lang('blog:live_label')), $post->status) ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="body"><?php echo lang('blog:content_label') ?></label>
                                                            <div class="input controls small-side">
                                                                    <?php echo form_dropdown('type', array(
                                                                            'html' => 'html',
                                                                            'markdown' => 'markdown',
                                                                            'wysiwyg-simple' => 'wysiwyg-simple',
                                                                            'wysiwyg-advanced' => 'wysiwyg-advanced',
                                                                    ), $post->type) ?>
                                                            </div>
<br />
                                                            <div class="input controls editor">
                                                                    <?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => (($post->type == 'html' || $post->type == 'markdown') ? $post->type . '_editor' : $post->type), 'id' => 'intro')) ?><?php echo form_hidden('preview_hash', $post->preview_hash)?>
                                                            </div>
                                                    </div>
                                    
                                    </fieldset>
                            </div>

                            <?php if(Settings::get('blog_enable_gallery')): ?>
                            <div class="form_inputs tab-pane" id="blog-gallery-tab">
                                    <fieldset>
                                                    <div class="control-group">
                                                        <label class="control-label" for="userfile"><?php echo lang('blog:add_files'); ?> <br /><br />
                                                        </label>
                                                        <div class="input controls skip">
                                                            <div id="upload_progress"></div>
                                                            <?php echo form_upload('userfile', set_value('userfile'), 'class="width-15" id="userfile"'); ?>
                                                            <div id="upload_buttons"></div>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="image_container"><?php echo lang('blog:images_label'); ?></label>
                                                        <div id="image_container" class="input controls">
                                                            <ul class="skip">
                                                            <?php if ($imgs): ?>
                                                                <?php foreach ($imgs as $key => $value): ?>       
                                                                <li>
                                                                    <span>
                                                                        <input type="hidden" name="images[]" value="<?php echo $value; ?>" />
                                                                        <a href="<?php echo ( file_path($value) ? $this->parser->parse_string(file_path($value), false, true) : Asset::get_filepath_img('module::no_image.jpg', true) ); ?>" class="fancybox" data-fancybox-group="gallery"><img src="<?php echo ( file_path($value) ? site_url('files/thumb/'.$value.'/100') : Asset::get_filepath_img('module::no_image.jpg', true) ); ?>" style="width: 100px" /></a>
                                                                        
                                                                        <a class="delete-image" onclick="javascript:metro.delete_image(this, '<?php echo $value; ?>');return false;" href="#"><?php echo lang('global:delete'); ?></a>
                                                                    </span>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            <?php if ($images and empty($imgs)): ?>
                                                                <?php foreach ($images as $img): ?>
                                                                <li>
                                                                    <span>
                                                                        <input type="hidden" name="images[]" value="<?php echo $img->file_id; ?>" />
                                                                        <a href="<?php echo ( file_path($img->file_id) ? $this->parser->parse_string(file_path($img->file_id), false, true) : Asset::get_filepath_img('module::no_image.jpg', true) ); ?>" class="fancybox" data-fancybox-group="gallery"><img src="<?php echo ( file_path($img->file_id) ? site_url('files/thumb/'.$img->file_id.'/100') : Asset::get_filepath_img('module::no_image.jpg', true) ); ?>" style="width: 100px" /></a>
                                                                        <a class="move-image" href="#<?php echo $img->id ?>">X</a>
                                                                        <a class="delete-image" onclick="javascript:metro.delete_image(this, '<?php echo $img->file_id ?>');return false;" href="#"><?php echo lang('global:delete'); ?></a>
                                                                    </span>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                    </fieldset>
                            </div>
                            <?php endif; ?>
                            <!-- Options tab -->
                            <div class="form_inputs tab-pane" id="blog-options-tab">
                                    <fieldset>
                                                    <div class="control-group">
                                                            <label class="control-label" for="category_id"><?php echo lang('blog:category_label') ?></label>
                                                            <div class="input controls">
                                                            <?php echo form_dropdown('category_id', array(lang('blog:no_category_select_label')) + $categories, @$post->category_id) ?>
                                                                    [ <?php echo anchor('admin/blog/categories/create_ajax', lang('blog:new_category_label'), 'id="add_category"') ?> ]
                                                            </div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="keywords"><?php echo lang('global:keywords') ?></label>
                                                            <div class="input controls"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label"><?php echo lang('blog:date_label') ?></label>

                                                            <div class="input controls datetime_input">
                                                                <div id="datetimepicker1" class="input-append date">
                                                                    <?php echo form_input('created_on', date('Y-m-d H:i:s', $post->created_on), 'maxlength="19" data-format="yyyy-MM-dd hh:mm:ss"') ?>
                                                                    <span class="add-on "><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="icon-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                    </div>

                                                    <div class="control-group">
                                                            <label class="control-label" for="comments_enabled"><?php echo lang('blog:comments_enabled_label');?></label>
                                                            <div class="input controls">
                                                                    <?php echo form_dropdown('comments_enabled', array(
                                                                            'no' => lang('global:no'),
                                                                            '1 day' => lang('global:duration:1-day'),
                                                                            '1 week' => lang('global:duration:1-week'),
                                                                            '2 weeks' => lang('global:duration:2-weeks'),
                                                                            '1 month' => lang('global:duration:1-month'),
                                                                            '3 months' => lang('global:duration:3-months'),
                                                                            'always' => lang('global:duration:always'),
                                                                    ), $post->comments_enabled ? $post->comments_enabled : '3 months') ?>
                                                            </div>
                                                    </div>
                                    </fieldset>
                            </div>
                            
                            <?php if ($stream_fields): ?>

                            <div class="form_inputs tab-pane" id="blog-custom-fields">
                                    <fieldset>
                                                    <?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>

                                    </fieldset>
                            </div>

                            <?php endif; ?>
                            
                        </div>
                </div>

                <div class="buttons">
                        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
                </div>

                <?php echo form_close() ?>

                </div>
            </div>
        </div>
    </div>
</div>