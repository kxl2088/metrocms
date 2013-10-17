	<!-- Begin Recent Comments -->
	<?php if (isset($recent_comments) AND is_array($recent_comments) AND $theme_options->metrocms_recent_comments == 'yes' AND module_enabled('comments')) : ?>
        <div class="row-fluid ">            
                <div class="span12">
                    <input type="hidden" name="shortcut[]" value="metrocms_recent_comments">
                        <div class="board-widgets">
                                <div class="board-widgets-head clearfix">
                                        <h4 class="pull-left"><?php echo lang('comments:recent_comments'); ?></h4>
                                        <a class="widget-settings toggle tooltip-l" title="<?php echo lang('global:togle-this-element'); ?>"><i class="icon-move"></i></a>
                                </div>
                                <div class="board-widgets-content">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                    <div class="comment-items">
                                                            <?php if (count($recent_comments)): ?>
                                                                    <?php foreach ($recent_comments as $comment): ?>
                                                                            <div class="item-block clearfix">    
                                                                                <div class="item-intro pull-left">
											<div class="item-meta">
												<ul>
                                                                                                        <li class="item-pic"><?php echo gravatar($comment->user_email) ?></li>
													<li><?php echo sprintf(lang('comments:list_comment'), $comment->user_name, $comment->entry_title) ?> </li>
													<li><?php echo format_date($comment->created_on) ?></li>
												</ul>
											</div>
                                                                                        <div class="comment">
                                                                                            <?php echo (Settings::get('comment_markdown') AND $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment ?> 
                                                                                        </div>
										</div>
                                                                                
                                                                            </div>
                                                                    <?php endforeach ?>
                                                            <?php else: ?>
                                                                    <div class="no-items"><?php echo lang('comments:no_comments') ?></div>
                                                            <?php endif ?>
                                                    </div>
                                            </div>                                            
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
	<?php endif ?>
	<!-- End Recent Comments -->