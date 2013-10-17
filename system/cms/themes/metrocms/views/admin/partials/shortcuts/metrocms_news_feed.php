	<!-- Begin RSS Feed -->
	<?php if ( !empty($rss_items) AND $theme_options->metrocms_news_feed == 'yes') : ?>
        <div class="row-fluid ">
                <div class="span12">
                    <input type="hidden" name="shortcut[]" value="metrocms_news_feed">
                        <div class="board-widgets">
                                <div class="board-widgets-head clearfix">
                                        <h4 class="pull-left"><?php echo lang('cp:news_feed_title'); ?></h4>
                                        <a class="widget-settings toggle tooltip-l" title="<?php echo lang('global:togle-this-element'); ?>"><i class="icon-move"></i></a>
                                </div>
                                <div class="board-widgets-content">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <div class="comment-items">
                                                        <?php foreach($rss_items as $rss_item): ?>
                                                        <?php
                                                                $item_date	= strtotime($rss_item->get_date());
                                                                $item_month = format_date($item_date, 'M');
                                                                $item_day	= format_date($item_date, 'j');
                                                        ?>
                                                    
                                                        <div class="item-block clearfix">
                                                            <div class="item-intro pull-left">
                                                                <div class="item-meta">
                                                                    <ul>
                                                                        <li>
                                                                            <span class="label label-info"><?php echo $item_month ?> <?php echo $item_day ?></span>
                                                                        </li>
                                                                        <li>
                                                                            <h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"') ?></h4>
                                                                        </li>
                                                                        <li>
                                                                            &nbsp;
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="comment">
                                                                    <?php echo $rss_item->get_description() ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach ?>
                                                </div>
                                            </div>                                            
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
	<?php endif ?>
	<!-- End RSS Feed -->