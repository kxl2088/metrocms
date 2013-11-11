<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <?php if ($this->method == 'create'): ?>
                    <h3><?php echo lang('page_types:create_title');?></h3>
                    <?php else: ?>
                    <h3><?php echo sprintf(lang('page_types:edit_title'), $page_type->title);?></h3>
                    <?php endif; ?>
            </div>

            <div class="widget-container">
                    <div class="content">

                            <?php echo form_open('', 'class="form-horizontal"'); ?>

                                    <div class="tab-widget">

                                            <ul class="nav nav-tabs">
                                                    <li><a href="#page-layout-basic"><span><?php echo lang('page_types:basic_info');?></span></a></li>
                                                    <li><a href="#page-layout-layout"><span><?php echo lang('page_types:layout');?></span></a></li>
                                                    <li><a href="#page-layout-meta"><span><?php echo lang('pages:meta_label');?></span></a></li>
                                                    <li><a href="#page-layout-css"><span><?php echo lang('page_types:css_label');?></span></a></li>
                                                    <li><a href="#page-layout-script"><span><?php echo lang('pages:script_label');?></span></a></li>
                                            </ul>
                                        <div class="tab-content">
                                            <div class="form_inputs tab-pane" id="page-layout-basic">

                                                    <fieldset>

                                                            

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="title"><?php echo lang('global:title');?> <span>*</span></label>
                                                                            <div class="input controls"><?php echo form_input('title', $page_type->title, 'id="text" maxlength="60"'); ?></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="title"><?php echo lang('global:slug');?> <span>*</span></label>
                                                                            <div class="input controls">
                                                                            <?php if ($this->method == 'create'): ?>
                                                                            <?php echo form_input('slug', $page_type->slug, 'id="slug" maxlength="60"'); ?>
                                                                            <?php else: ?>
                                                                            <em><?php echo $page_type->slug; ?></em>
                                                                            <?php endif; ?>
                                                                            </div>
                                                                    </div>

                                        <div class="control-group">
                                            <label class="control-label" for="description"><?php echo lang('global:description');?></label>
                                            <div class="input controls"><?php echo form_input('description', $page_type->description, 'id="description"'); ?></div>
                                        </div>

                                                                    <?php if ($this->method == 'edit'): ?>
                                                                            <?php echo form_hidden('old_slug', $page_type->slug); ?>
                                                                    <?php endif; ?>

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="stream_slug"><?php echo lang('page_types:select_stream');?> <span>*</span><?php if ($this->method == 'new'): ?><br><small><?php echo lang('page_types:stream_instructions'); ?></small><?php endif; ?></label>

                                                                            <div class="input controls">

                                                                                    <?php if ($this->method == 'create'): ?>

                                                                                            <?php echo form_dropdown('stream_id', array('new' => lang('page_types:auto_create_stream')) + $streams_dropdown, isset($page_type->stream_slug) ? $page_type->stream_slug : false); ?>

                                                                                    <?php else: ?>

                                                                                            <p><em><?php echo $this->db->limit(1)->select('stream_name')->where('id', $page_type->stream_id)->get(STREAMS_TABLE)->row()->stream_name; ?></em></p>

                                                                                    <?php endif; ?>
                                                                            </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="theme_layout"><?php echo lang('page_types:theme_layout_label');?> <span>*</span></label>
                                                                            <div class="input controls"><?php echo form_dropdown('theme_layout', $theme_layouts, $page_type->theme_layout ? $page_type->theme_layout : 'default'); ?></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="save_as_files"><?php echo lang('page_types:save_as_files');?><br><small><?php echo lang('page_types:saf_instructions'); ?></small></label>
                                                                            <div class="input controls"><?php echo form_checkbox('save_as_files', 'y', $page_type->save_as_files == 'y' ? true : false, 'id="save_as_files"'); ?></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="content_label"><?php echo lang('page_types:content_label');?><br><small><?php echo lang('page_types:content_label_instructions'); ?></small></label>
                                                                            <div class="input controls"><?php echo form_input('content_label', $page_type->content_label, 'id="content_label" maxlength="60"'); ?></div>
                                                                    </div>		

                                                                    <div class="control-group">
                                                                            <label class="control-label" for="title_label"><?php echo lang('page_types:title_label');?><br><small><?php echo lang('page_types:title_label_instructions'); ?></small></label>
                                                                            <div class="input controls"><?php echo form_input('title_label', $page_type->title_label, 'id="title_label" maxlength="100"'); ?></div>
                                                                    </div>

                                                            

                                                    </fieldset>

                                            </div>

                                            <div class="form_inputs tab-pane" id="page-layout-layout">

                                                    <fieldset>

                                                            
                                                                    <div class="control-group">
                                                                            <label class="control-label" for="html_editor"><?php echo lang('page_types:layout'); ?> <span>*</span></label>
                                                                            <div class="input controls">
                                                                            <?php echo form_textarea(array('id'=>'html_editor', 'class' => 'html_editor', 'name'=>'body','rows' => 30), ($page_type->body == '' ? '<h2>{{ title }}</h2>' : ($page_type->body))); ?></div>
                                                                    </div>
                                                            

                                                    </fieldset>

                                            </div>

                                            <!-- Meta data tab -->
                                            <div class="form_inputs tab-pane" id="page-layout-meta">

                                                    <fieldset>

                                                    
                                                            <div class="control-group">
                                                                    <label class="control-label" for="meta_title"><?php echo lang('pages:meta_title_label');?></label>
                                                                    <div class="input controls"><input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page_type->meta_title; ?>" /></div>
                                                            </div>

                                                            <div class="control-group">
                                                                    <label class="control-label" for="meta_keywords"><?php echo lang('pages:meta_keywords_label');?></label>
                                                                    <div class="input controls"><input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page_type->meta_keywords; ?>" /></div>
                                                            </div>

                                                            <div class="control-group">
                                                                    <label class="control-label" for="meta_description"><?php echo lang('pages:meta_desc_label');?></label>
                                                                    <div class="input controls">
                                                                    <?php echo form_textarea(array('name' => 'meta_description', 'value' => $page_type->meta_description, 'rows' => 5)); ?>
                                                                    </div>
                                                            </div>
                                                    

                                                    </fieldset>

                                            </div>


                                            <!-- Design tab -->
                                            <div class="form_inputs tab-pane" id="page-layout-css">

                                                    <fieldset>

                                                    
                                                            <div class="control-group">
                                                                    <label class="control-label" for="css"><?php echo lang('page_types:css_label'); ?></label>
                                                                    <div class="input controls">
                                                                    <?php echo form_textarea('css', $page_type->css, 'class="css_editor" id="css"'); ?></div>
                                                            </div>
                                                    

                                                    </fieldset>

                                            </div>

                                            <!-- Script tab -->
                                            <div class="form_inputs tab-pane" id="page-layout-script">

                                                    <fieldset>

                                                    
                                                            <div class="control-group">
                                                                    <label class="control-label" for="js">JavaScript</label>
                                                                    <div class="input controls">
                                                                    <?php echo form_textarea('js', $page_type->js, 'class="js_editor" id="js"'); ?></div>
                                                            </div>
                                                    

                                                    </fieldset>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="buttons float-right padding-top">
                                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
                                    </div>

                            <?php echo form_close(); ?>
                    </div>
            </div>
        </div>
    </div>
</div>