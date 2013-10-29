<?php if(!empty($templates)): ?>

<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('templates:default_title') ?></h3>
            </div>

            <div class="widget-container">
                    <div class="content">

                        <?php echo form_open('admin/templates/action') ?>

                        <table  class="table-list responsive table table-hover table-striped table-bordered" >
                            <thead>
                                <tr>
                                    <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                                    <th><?php echo lang('name_label') ?></th>
                                    <th class="collapse"><?php echo lang('global:description') ?></th>
                                    <th class="collapse"><?php echo lang('templates:language_label') ?></th>
                                    <th style="width: 180px"><?php echo lang('global:actions'); ?></th>
                                </tr>
                            </thead>

                            <tbody>

                        <?php foreach ($templates as $template): ?>
                                    <?php if($template->is_default): ?>
                                <tr>
                                                    <td><?php echo form_checkbox('action_to[]', $template->id);?></td>
                                    <td><?php echo $template->name ?></td>
                                    <td class="collapse"><?php echo $template->description ?></td>
                                    <td class="collapse"><?php echo $template->lang ?></td>
                                    <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class="preview modal-ajax" title="'. lang('buttons:preview') . ' - ' . $template->name .'"') ?></li>
      <li><?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="edit"') ?></li>
      <li><?php echo anchor('admin/templates/create_copy/' . $template->id, lang('buttons:clone'), 'class="clone"') ?></li>
  </ul>
</div>
                                    </td>
                                </tr>
                                    <?php endif ?>
                        <?php endforeach ?>
                            </tbody>
                            </table>
                        <?php echo form_close() ?>

                            <div class="table_action_buttons">
                                    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
	<div class="widget-head blue">
		<h3><?php echo lang('templates:user_defined_title') ?></h3>
	</div>
	
	<?php echo form_open('admin/templates/delete') ?>
	   
	<div class="widget-container">
		<div class="content">
			<table  class="table-list clear-both" >
		        <thead>
		            <tr>
		                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
		                <th><?php echo lang('name_label') ?></th>
		                <th><?php echo lang('global:description') ?></th>
		                <th><?php echo lang('templates:language_label') ?></th>
		                <th style="width: 180px"><?php echo lang('global:actions'); ?></th>
		            </tr>
		        </thead>
		
		        <tbody>
			
		    <?php foreach ($templates as $template): ?>
				<?php if(!$template->is_default): ?>
		            <tr>
						<td><?php echo form_checkbox('action_to[]', $template->id);?></td>
		                <td><?php echo $template->name ?></td>
		                <td><?php echo $template->description ?></td>
		                <td><?php echo $template->lang ?></td>
		                <td class="actions">
<div class="btn-group">
  <button type="button" class="btn btn-primary"><?php echo lang('global:actions'); ?></button>
  <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"><span class="caret"></span> </button>
  <ul class="dropdown-menu">
      <li><?php echo anchor('admin/templates/preview/' . $template->id, lang('buttons:preview'), 'class= preview modal-ajax" title="'. lang('buttons:preview') . ' - ' . $template->name .'"') ?></li>
      <li><?php echo anchor('admin/templates/edit/' . $template->id, lang('buttons:edit'), 'class="edit"') ?></li>
      <li><?php echo anchor('admin/templates/delete/' . $template->id, lang('buttons:delete'), 'class="delete"') ?></li>
  </ul>
</div>
		                </td>
		            </tr>
				<?php endif ?>
		    <?php endforeach ?>
			
			
		        </tbody>
		    </table>
		
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
			</div>
		
		    <?php echo form_close() ?>
		</div>
	</div>
        </div>
    </div>
</div>
	
<?php else: ?>

<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
	<div class="widget-container">
		<div class="content">
                    <div class="no_data"><?php echo lang('templates:currently_no_templates') ?></div>
		</div>
	</div>
        </div>
    </div>
</div>

<?php endif ?>