<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                <h3><?php echo lang('log.physical_title'); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="content-widgets">
            <div class="widget-head orange">
                 <?php echo heading(lang('log.quick_select_title'), 3); ?>
            </div>
            <div class="widget-container">
                    <div class="content">
                           
                            <a href="#" class="btn btn-primary" id="btnSelectAll"><?php echo lang('global:check-all'); ?></a>
                            <a href="#" class="btn btn-success" id="btnToggleSelect"><?php echo lang('log.toggle_select'); ?></a>
                            <a href="#" class="btn btn-warning" id="btnSelectNonSynced"><?php echo lang('log.non_synchronized'); ?></a>
                            <a href="#" class="btn btn-danger" id="btnSelectOversized"><?php echo lang('log.oversized'); ?></a>
                            
                    </div>
            </div>
            <div class="widget-container">
                <div class="content">
                            <table class="responsive table table-hover table-striped table-bordered">
                                <tr>
                                    <th><?php echo lang('name_label'); ?></th>
                                    <th><?php echo lang('log.edited_on_label'); ?></th>
                                    <th><?php echo lang('log.size_label'); ?></th>
                                </tr>
                            </table>
                            <div id="tree2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="content-widgets">
            <div class="widget-head orange">
                <?php echo heading(lang('log.actions_label'), 3); ?>
            </div>
            <div class="widget-container">
                    <div class="content">       
                            <div class="buttons float-right padding-top">
                                
                                <?php echo anchor('#', lang('log.sync_label'), 'class="btn btn-success" rel="sync"'); ?>
                                <?php echo anchor('#', lang('log.download_physical'), 'class="btn btn-warning" rel="download"'); ?>
                                <?php echo anchor('#', lang('log.delete_physical'), 'class="btn btn-danger" rel="del_physical"'); ?>
                            </div>                            
                    </div>
            </div>
            <div class="widget-container">
                    <div class="content"> 
                            <div class="gray" style="padding: 20px;">
                                <?php echo lang('log.physical_info'); ?>
                            </div>
                            <div>
                                <?php echo form_hidden('directory_size', $directory_size); ?>
                            </div>
                            <div id="box"></div>
                    </div>
            </div>
        </div>
    </div>
</div>