<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo $module_details['name'] ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">
                            <?php if ($setting_sections): ?>
                                    <?php echo form_open('admin/settings/edit', 'class="crud form-horizontal"');?>

                                            <div class="tab-widget">

                                                    <ul class="nav nav-tabs">
                                                            <?php foreach ($setting_sections as $section_slug => $section_name): ?>
                                                            <li>
                                                                    <a href="#<?php echo $section_slug ?>" title="<?php printf(lang('settings:section_title'), $section_name) ?>">
                                                                            <span><?php echo $section_name ?></span>
                                                                    </a>
                                                            </li>
                                                            <?php endforeach ?>
                                                    </ul>
                                                
                                                    <div class="tab-content">
                                                        <?php foreach ($setting_sections as $section_slug => $section_name): ?>
                                                        <div class="form_inputs tab-pane" id="<?php echo $section_slug;?>">
                                                                <fieldset>
                                                                        <?php $section_count = 1; foreach ($settings[$section_slug] as $setting): ?>
                                                                                <div id="<?php echo $setting->slug ?>" class="control-group <?php echo $section_count++ % 2 == 0 ? 'even' : '' ?>"><i class="icon-move"></i>
                                                                                        <label for="<?php echo $setting->slug ?>" class="control-label">
                                                                                                <?php echo $setting->title ?>
                                                                                                <?php if($setting->description): echo '<small>'.$setting->description.'</small>'; endif ?>
                                                                                        </label>

                                                                                        <div class="input <?php echo 'type-'.$setting->type ?> controls">
                                                                                                <?php echo $setting->form_control ?>
                                                                                        </div>
                                                                                        
                                                                                </div>
                                                                        <?php endforeach ?>
                                                                </fieldset>
                                                        </div>
                                                        <?php endforeach ?>
                                                    </div>

                                            </div>

                                            <div class="buttons padding-top">
                                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
                                            </div>

                                    <?php echo form_close() ?>
                            <?php else: ?>
                                    <div>
                                            <p><?php echo lang('settings:no_settings');?></p>
                                    </div>
                            <?php endif ?>
                    </div>
            </div>
        </div>
    </div>
</div>