<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('streams:api_list') ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

				<?php echo $this->load->view('admin/api/partials/filters') ?>
	
				<?php echo form_open('admin/streams/api/delete') ?>
					<div id="filter-stage">
						<?php echo $this->load->view('admin/api/tables/streams') ?>
					</div>
				<?php echo form_close() ?>
                    </div>
            </div>
        </div>
    </div>
</div>