        <div class="row-fluid ">
                <div class="span12">
                    <input type="hidden" name="shortcut[]" value="<?php echo $widget->slug ?>">
                        <div class="board-widgets">
                                <div class="board-widgets-head clearfix">
                                        <h4 class="pull-left"><?php if ($widget->options['show_title']): echo $widget->instance_title; endif; ?></h4>
                                        <a class="widget-settings toggle tooltip-l" title="<?php echo lang('global:togle-this-element'); ?>"><i class="icon-move"></i></a>
                                </div>
                                <div class="board-widgets-content">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <?php echo $widget->body ?>
                                            </div>                                            
                                        </div>
                                </div>
                        </div>
                </div>
        </div>