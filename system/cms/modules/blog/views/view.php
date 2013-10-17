
<div class="post">

	<h3><?php echo $post['title']; ?></h3>

	<div class="meta">

		<div class="date">
                        <?php echo lang('blog:posted_label'); ?>
			<span>
                            <?php echo format_date($post['created_on'], 'd/m/Y'); ?>
                        </span>
		</div>

		<div class="author">
                        <?php echo lang('blog:written_by_label'); ?>
			<span>
                            <?php echo anchor('user/' . $post['author_url'], $post['author']); ?>
                           </span>
		</div>

		<?php if($post['category']): ?>
		<div class="category">
                        <?php echo lang('blog:category_label'); ?>:
			<span>
                            <?php echo anchor($post['category_url'], $post['category']['title']); ?>
                        </span>
		</div>
		<?php endif; ?>

                <?php if($post['keywords_arr']): ?>
		<div class="keywords">
                    <?php $keywords_anchors = ''; ?>
                        <?php foreach ($post['keywords_arr'] as $keyword): ?>				
                                    <?php $keywords_anchors .= anchor('blog/tagged/' . $keyword, $keyword) . ',&nbsp;'; ?>
			<?php endforeach; ?>
                    <?php $keywords_anchors = substr($keywords_anchors, 0, (strlen($keywords_anchors)-7)); ?>
                    <?php echo $keywords_anchors; ?>
		</div>
		<?php endif; ?>

	</div>
                
	<div class="body">
                <?php if($post['image']): ?>
                    <?php echo img($post['image']) . br() . br(); ?>
                <?php endif; ?>
            
                <?php if($post['images']): ?>
                    <?php foreach($post['images'] as $image): ?>
                        <div class="gallery">
                            <?php echo img($image['thumb']); ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            
		<?php echo $post['body']; ?>
	</div>

</div>



<?php if (Settings::get('enable_comments')): ?>

<div id="comments">

	<div id="existing-comments">
		<h4><?php echo lang('comments:title') ?></h4>
		<?php echo $this->comments->display() ?>
	</div>

	<?php if ($form_display): ?>
		<?php echo $this->comments->form() ?>
	<?php else: ?>
	<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post['comments_enabled'])))) ?>
	<?php endif ?>
</div>

<?php endif ?>
