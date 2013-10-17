<div class="row-fluid">
    <div class="span12">
        <div class="content-widgets">
            <div class="widget-head blue">
                    <h3><?php echo lang('global:plugins');?></h3>
            </div>

            <div class="widget-container">
                <div class="content">
                <h4><?php echo lang('addons:plugins:add_on_plugins');?></h4>
                <?php echo $this->load->view('admin/plugins/_table', array('plugins' => $plugins), true) ?>

                <h4><?php echo lang('addons:plugins:core_plugins');?></h4>
                <?php echo $this->load->view('admin/plugins/_table', array('plugins' => $core_plugins), true) ?>

                </div>
            </div>

            <div id="plugin-docs" style="display:none">
                    <?php echo $this->load->view('admin/plugins/_docs', array('plugins' => array($plugins, $core_plugins)), true) ?>
            </div>
        </div>
    </div>
</div>