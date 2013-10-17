<div class="row-fluid">
    <div class="span6">
        <div class="content-widgets">
                    <div class="widget-head blue">
                            <h3><?php echo lang('widgets:available_title') ?></h3>
                    </div>
                
                    <div class="widget-container">
                            <div class="content" id="available-widgets">
                                    <?php if ($available_widgets): ?>
                                    <ul>
                                            <?php foreach ($available_widgets as $widget): ?>
                                            <li id="widget-<?php echo $widget->slug ?>" class="widget-box">
                                                    <p><span><?php echo $widget->title ?></span> <?php echo $widget->description ?></p>
                                                    <div class="widget_info" style="display: none;">
                                                            <p class="author"><?php echo lang('widgets:widget_author') . ': ' . ($widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author) ?>
                                                    </div>
                                            </li>
                                            <?php endforeach ?>
                                    </ul>
                                    <?php else: ?>
                                    <p><?php echo lang('widgets:no_available_widgets') ?></p>
                                    <?php endif ?>
                            </div>
                    </div>
            </div>
</div>

    <div class="span6">
        <div class="content-widgets">
                    <div class="widget-head blue">
                            <h3><?php echo lang('widgets:widget_area_wrapper') ?></h3>
                    </div>
                
                    <div class="widget-container" id="widget-areas">
                            <div class="content">
                                    <?php if ($widget_areas): ?>
                                    <!-- Available Widget Areas -->
                                    <div id="widget-areas-list">
                                            <?php $this->load->view('admin/areas/index', compact('widget_areas')) ?>
                                    </div>
                                    <?php else: ?>
                                            <?php echo anchor('admin/widgets/areas/create', lang('widgets:add_area'), 'class="add btn btn-primary create-area"') ?>
                                    <?php endif ?>
                            </div>
                    </div>
            </div>
    </div>
</div>