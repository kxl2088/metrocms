	<?php if ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->metrocms_analytics_graph == 'yes'): ?>
	<script type="text/javascript">
	
	$(function($) {
			var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0 ?>;
			var views = <?php echo isset($analytic_views) ? $analytic_views : 0 ?>;                        
                                                
			var buildGraph = function() {
				$.plot($('#visitors-chart #visitors-container'), [{ 
                                        label: '<?php echo lang('global:statistics-visits'); ?>', 
                                        data: visits,
                                        lines: {
                                            fill: true
                                        }                                                                            
                                },{ 
                                        label: '<?php echo lang('global:statistics-page-views'); ?>', 
                                        data: views,
                                        points: {
                                            show: true
                                        },
                                        lines: {
                                            show: true
                                        },
                                        yaxis: 2    
                                }],{
                                series: {
                                    lines: {
                                        show: true,
                                        fill: false
                                    },
                                    points: {
                                        show: true,
                                        lineWidth: 2,
                                        fill: true,
                                        fillColor: "#ffffff",
                                        symbol: "circle",
                                        radius: 5,
                                    },
                                    shadowSize: 0,
                                },
                                selection: { mode: "x" },
                                grid: {
                                    hoverable: true,
                                    clickable: true,
                                    tickColor: "#f9f9f9",
                                    borderWidth: 1
                                },
                                colors: ["#b086c3", "#ea701b"],
                                tooltip: true,
                                tooltipOpts: {
                                    shifts: { 
                                            x: -100                     //10
                                    },
                                    defaultTheme: false
                                },
                                xaxis: { mode: "time" },
				yaxis: { min: 0},
                                yaxes: [{
                                    /* First y axis */
                                }, {
                                    /* Second y axis */
                                    position: "right" /* left or right */
                                }]
                            });                            
			}
                        
			// create the analytics graph when the page loads
			buildGraph();
	
			// re-create the analytics graph on window resize
			$(window).resize(function(){
				buildGraph();
			});
			
		
		});
	</script>
        <div class="row-fluid ">            
                <div class="span12">
                    <input type="hidden" name="shortcut[]" value="metrocms_analytics_graph">
                        <div class="board-widgets gray">
                                <div class="board-widgets-head clearfix">
                                        <h4 class="pull-left"><?php echo lang('global:statistics'); ?></h4>
                                        <a class="widget-settings toggle tooltip-l" title="<?php echo lang('global:togle-this-element'); ?>"><i class="icon-move"></i></a>
                                </div>
                                <div class="board-widgets-content">
                                        <div class="row-fluid">
                                                <div class="span12">
                                                        <div class="widget-container">
                                                                <div id="visitors-chart">
                                                                        <div id="visitors-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>                                                
                                        </div>
                                </div>
                        </div>
                </div>
        </div>	
	<?php endif ?>
	<!-- End Analytics -->