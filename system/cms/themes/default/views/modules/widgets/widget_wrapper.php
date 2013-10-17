<div class="well <?php echo $widget->slug ?>">
	<?php if ($widget->options['show_title']): ?>
		<h4><?php echo $widget->instance_title ?></h4>
	<?php endif ?>

	<?php echo $widget->body ?>
</div>