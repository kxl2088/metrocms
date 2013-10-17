<div class="row-fluid">
    <div class="span6">
        <div class="content-widgets">
                    <div class="widget-head blue">
                        <h3><?php echo lang('pages:list_title') ?></h3>
                    </div>
            
                    <div class="widget-container">
                            <div class="content">
                                    <div id="page-list">
                                    <ul class="sortable">
                                            <?php echo tree_builder($pages, '<li id="page_{{ id }}"><div><a href="#" class="{{ status }}" rel="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
                                    </ul>
                                    </div>
                            </div>
                    </div>
        </div>
    </div>
    <div class="span6">
        <div class="content-widgets">
                    <div class="widget-head blue">
                            <h3><?php echo lang('pages:tree_explanation_title') ?></h3>
                    </div>

                    <div class="widget-container">
                            <div class="content">
                                    <div id="page-details">
                                            <p>
                                                    <?php echo lang('pages:tree_explanation') ?>
                                            </p>
                                    </div>
                            </div>
                    </div>
        </div>
    </div>
</div>