			<?php foreach ($module_details['sections'] as $name => $section): ?>
			<?php if(isset($section['name']) && isset($section['uri'])): ?>
			<li class="<?php if ($name === $active_section) echo 'active' ?>">
				<?php echo anchor($section['uri'], (lang($section['name']) ? lang($section['name']) : $section['name'])); ?>
				<?php if ($name === $active_section): ?>
					<!-- Arrow -->
				<?php endif; ?>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>