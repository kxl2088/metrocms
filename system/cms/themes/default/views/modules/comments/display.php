<?php if ($comments): ?>
	<hr>
	<?php foreach ($comments as $item): ?>
          <!-- the comments -->
          <h3><?php echo $item->user_name ?> <small><?php echo format_date($item->created_on, 'H:i a') ?> on <?php echo format_date($item->created_on, 'F d, Y') ?></small></h3>

            <?php if (Settings::get('comment_markdown') and $item->parsed): ?>
                    <?php echo $item->parsed ?>
            <?php else: ?>
                    <p><?php echo nl2br($item->comment) ?></p>
            <?php endif ?>

	<?php endforeach ?>
	
<?php else: ?>
	<p><?php echo lang('comments:no_comments') ?></p>
<?php endif ?>