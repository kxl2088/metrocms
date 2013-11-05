	<?php if ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->metrocms_analytics_graph == 'yes'): ?>
	<script type="text/javascript">
	
	$(function($) {
			var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0 ?>;
			var views = <?php echo isset($analytic_views) ? $analytic_views : 0 ?>;                        
                        var browsers = <?php echo isset($analytic_browsers) ? $analytic_browsers : 0 ?>;    
			var systems = <?php echo isset($analytic_systems) ? $analytic_systems : 0 ?>;  
			var avgtimeonsite = <?php echo isset($analytic_avgtimeonsite) ? $analytic_avgtimeonsite : 0 ?>;  
			
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
			    // Average Time On Site
			    $.plot($('#timeonsite-chart #timeonsite-container'), [{ 
					label: '<?php echo lang('cp:analytic_average_time'); ?>',
                                        data: avgtimeonsite,
                                        lines: {
                                            fill: true
                                        }                                                                            
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
                                colors: ["#e88a05"],
                                tooltip: true,
                                tooltipOpts: {
                                    shifts: { 
                                            x: -100                     //10
                                    },
                                    defaultTheme: false
                                },
                                xaxis: { mode: "time" },
				yaxis: { mode: "time", timeformat: "%H:%M:%S" },
                                yaxes: [{
                                    /* First y axis */
                                }, {
                                    /* Second y axis */
                                    position: "right" /* left or right */
                                }]
                            });
			    // Browsers 
                            $.plot($("#pie-chart-donut #pie-donutContainer"), 
                            browsers,
                            {
                                series: {
                                    pie: {
                                        show: true,
					radius: 1,
                                        innerRadius: 0.5,
                                        label: {
                                            show: true,
					    radius: 0.77,
					    formatter: function(label, series){
						return '<div style="font-size:8pt;text-align:center;padding:2px;color:#fff;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
					    },
					    threshold: 0.1

                                        }
                                    }
                                },
                                legend: {
                                    show: true
                                },
                                grid: {
                                    hoverable: true,
                                    clickable: true
                                },
                                colors: ["#b086c3", "#ea701b"],
                                tooltip: false,                                
                            }
                            );
			    // Systems
			    $.plot($("#pie-chart-systems #pie-systemsContainer"), 
                            systems,
                            {
                                series: {
                                    pie: {
                                        show: true,
					radius: 1,
                                        innerRadius: 0.5,
                                        label: {
                                            show: true,
					    radius: 0.77,
					    formatter: function(label, series){
						return '<div style="font-size:8pt;text-align:center;padding:2px;color:#fff;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
					    },
					    threshold: 0.1

                                        }
                                    }
                                },
                                legend: {
                                    show: true
                                },
                                grid: {
                                    hoverable: true,
                                    clickable: true
                                },
				colors: ["#3498DB", "#5b3ab6"],
                                tooltip: false,
                            }
                            );
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
                                                <div class="span8">
							<h4 class="widget-header color-black"><?php echo lang('cp:analytic_visits_and_views'); ?></h4>
                                                        <div class="widget-container">
                                                                <div id="visitors-chart">
                                                                        <div id="visitors-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>    
						<div class="span4">
							<h4 class="widget-header color-black"><?php echo lang('cp:analytic_browsers'); ?></h4>
                                                         <div class="widget-container">
                                                                <div id="pie-chart-donut" class="pie-chart">
                                                                        <div id="legendPlaceholder">
                                                                        </div>
                                                                        <div id="pie-donutContainer" style="width: 100%;height:280px; text-align: left;">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div> 
                                        </div>
					<div class="clearfix">&nbsp;</div>
					<div class="row-fluid">
						<div class="span8">
							<h4 class="widget-header color-black"><?php echo lang('cp:analytic_avgtimeonsite'); ?></h4>
                                                        <div class="widget-container">
                                                                <div id="timeonsite-chart">
                                                                        <div id="timeonsite-container" style="width: 100%;height:300px; text-align: center; margin:0 auto;">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div> 
						<div class="span4">
							<h4 class="widget-header color-black"><?php echo lang('cp:analytic_systems'); ?></h4>
							<div class="widget-container">
                                                                <div id="pie-chart-systems" class="pie-chart">
                                                                        <div id="legendPlaceholder">
                                                                        </div>
                                                                        <div id="pie-systemsContainer" style="width: 100%;height:280px; text-align: left;">
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