<?php if (is_array($categories)): ?>
<ul class="list-unstyled">
	<?php foreach ($categories as $category): ?>
	<li>
		<?php echo anchor("blog/category/{$category->slug}", $category->title) ?>
	</li>
	<?php endforeach ?>
</ul>
<?php endif ?>
