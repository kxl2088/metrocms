<?php if ($this->controller === 'admin_areas' and ! $this->input->is_ajax_request()): ?>
<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('widgets:areas') ?></h3>
            </div>

            <div class="widget-container">
		<div class="content">
		<?php endif ?>
		
			<?php foreach ($widget_areas as $widget_area): ?>
				<div class="widget-area-box" id="area-<?php echo $widget_area->slug ?>" data-id="<?php echo $widget_area->id ?>">
					<header>
						<h3><?php echo $widget_area->title ?></h3>
					</header>
					<div class="widget-area-content accordion-content">
						<div class="area-buttons buttons buttons-small">
									
							<?php echo anchor('admin/'.$this->module_details['slug'].'/areas/edit/'.$widget_area->slug, lang('global:edit'), 'class="btn btn-primary edit" data-fancybox-type="ajax"') ?>
							<button type="submit" name="btnAction" value="delete" class="btn btn-danger delete confirm"><span><?php echo lang('global:delete') ?></span></button>
		
						</div>
		
						<!-- Widget Area Tag -->
						<input type="text" class="widget-div-code widget-code" value='<?php echo sprintf('{{ widgets:area slug="%s" }}', $widget_area->slug) ?>' />
		
						<!-- Widget Area Instances -->
						<div class="widget-list">
							<?php $this->load->view('admin/instances/index', array('widgets' => $widget_area->widgets)) ?>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		
		<?php if ($this->controller === 'admin_areas' and ! $this->input->is_ajax_request()): ?>
		</div>
            </div>
	</div>
    </div>
</div>
<?php endif; ?>