<?php if ( ! empty($groups)): ?>
	<?php foreach ($groups as $group): ?>
<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-container">
		<div rel="<?php echo $group->id ?>" class="group-<?php echo $group->id ?> box">
				<div class="widget-head blue titles">
					<h3 class="tooltip-l" title="<?php echo lang('nav:abbrev_label').': '.$group->abbrev ?>"><?php echo $group->title;?></h3>
                                        <div class="widget-head-buttons">
                                            <?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => 'tooltip-t confirm btn btn-danger',  'title' => lang('nav:group_delete_confirm'))) ?>
                                            
                                            <?php echo anchor('admin/navigation/create/'.$group->id, lang('nav:link_create_title'), 'rel="'.$group->id.'" class="add ajax btn btn-warning"') ?>
                                        </div>

				</div>

				<?php if ( ! empty($navigation[$group->id])): ?>

				<div class="span12 items collapsed">
						<div class="content">
							<div class="span6">
								<div id="link-list">
									<ul class="sortable">
										<?php echo tree_builder($navigation[$group->id], '<li id="link_{{ id }}"><div><a href="#" rel="'.$group->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
									</ul>
								</div>
							</div>

							<div class="span6">
								<div id="link-details" class="group-<?php echo $group->id ?>">

									<p>
										<?php echo lang('navs.tree_explanation') ?>
									</p>

								</div>
							</div>
						</div>
					</div>
				<?php else:?>

				<div class="span12 items collapsed">
					<div class="content">
						<div class="span6">
							<div id="link-list" class="empty">
								<ul class="sortable">

									<p class="no_data"><?php echo lang('nav:group_no_links');?></p>

								</ul>
							</div>
						</div>

						<div class="span6">
							<div id="link-details" class="group-<?php echo $group->id ?>">

								<p>
									<?php echo lang('navs.tree_explanation') ?>
								</p>

							</div>
						</div>
					</div>
				</div>
				<?php endif ?>
		</div>
            </div>
        </div>
    </div>
</div>
	<?php endforeach ?>

<?php else: ?>
<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-container">
                <div class="content no_data">
                        <?php echo lang('nav:no_groups');?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif ?>