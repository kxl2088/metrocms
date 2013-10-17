jQuery(function($){

	$.extend($.ui.accordion.prototype, {
		refresh: function(){
			this.destroy();
			this.widget().accordion(this.options);
			return this;
		}
	});

	metro.cache.widget_forms = {
		add		:{},
		edit	:{}
	}

	metro.widgets = {

		$areas		: null,
		$boxes		: null,
		$instances	: null,
		$container	: null,
		selector	: {
			container	: 'null',
			instances	: 'null'
		},

		ui_options: {
			// Widget Areas
			accordion: {
				collapsible	: true,
				header		: '> .widget-areas-list > header',
				autoHeight	: true,
				clearStyle	: true
			},
			// Widget Instances List
			sortable: {
				cancel		: '.no-sortable, a, :input, option',
				placeholder	: 'empty-drop-item',

				start: function(){
					metro.widgets.$areas.accordion('refresh');
				},

				stop: function(){
					metro.widgets.$areas.accordion('refresh');
				},

				update: function(){
					var order = [];
					
					$(this).children('li').each(function(){					
						order.push($(this).attr('id'));
					});

					$.post(SITE_URL + 'widgets/ajax/update_order', { order: order.join(',') });
				}
			},
			// Widget Box
			draggable: {
				revert		: 'invalid',
				cursor		: 'move',
				helper		: 'clone',
				cursorAt	: {left: 100},
				refreshPositions: true,

				start : function(e, ui){
					// Grab our desired width from the widget area list
					var width = metro.widgets.$instances.width() - 22;

					// Setup our new dragging object
					$(this).addClass('widget-drag')
					$(ui.helper).css('width', width);
				},
				stop: function() {
					$(this).removeClass('widget-drag');
				}
			},
			// Widget Instances List
			droppable: {
				hoverClass	: 'drop-hover',
				accept		: '.widget-box',
				greedy		: true,
				tolerance	: 'pointer',

				over : function(){
					metro.widgets.$areas.accordion('refresh');
				},
				out : function(){
					metro.widgets.$areas.accordion('refresh');
				},
				drop : function(e, ui){
					$('li.empty-drop-item', this).show().addClass('loading');

					metro.widgets.prep_instance_form(ui.draggable, $(metro.widgets.selector.instances, this));

				}
			}
		},

		init: function()
		{
			// Create/Edit Areas
			$('a.create-area, .widget-area-content > .buttons > a.edit').livequery(function(){
				$(this).fancybox({
					width		:'500',
					height		:'260',
                                        fitToView: false,
                                        autoSize: false,
                                        closeClick: false,
                                        openEffect: 'fade',
                                        closeEffect: 'fade',
                                        closeBtn: true,
                                        ajax: {
                                            dataType  : 'html'
                                        },
					afterShow: function(){
                                                metro.generate_slug('input[name="title"]', 'input[name="slug"]');
						metro.widgets.handle_area_form(this);
					}
				});
			});

			// Delete Areas
			$('.widget-area-content > .buttons > button[value=delete]').on('click-confirmed', function(e){
				e.preventDefault();

				var $area	= $(this).parents('.widget-area-box'),
					id		= $area.attr('data-id'),
					url		= SITE_URL + 'admin/widgets/areas/delete/' + id;

				$.post(url, {}, function(response){
					if (response.status == 'success')
					{
						$area.slideUp(function(){
							$(this).remove();
						});
					}
					metro.add_notification(response.message);
				}, 'json');
			});

			// Edit Instances
			$('.widget-actions > a.btn.edit').click( function(e){
				e.preventDefault();

				var $anchor = $(this);

				// hide
				$anchor.parents('.widget-instance').slideUp(50, function(){
					// fake loading..
					$(this).siblings('li.empty-drop-item').clone()
						// move
						.insertAfter(this)
						// show
						.show().addClass('loading clone');

						// next step
						metro.widgets.prep_instance_form($anchor, this, 'edit');
				});
			});

			// Delete Instances
			$('.widget-actions > button[value=delete]').on('click-confirmed', function(e){
				e.preventDefault();

				var $item	= $(this).parents('li.widget-instance'),
					id		= $item.attr('id').replace(/instance-/, ''),
					url		= SITE_URL + 'admin/widgets/instances/delete/' + id;

				$.post(url, {}, function(response){
					if (response.status == 'success')
					{
						$item.slideUp(50, function(){
							$(this).remove();
						});
					}
					metro.add_notification(response.message);
				}, 'json');

				metro.widgets.$areas.accordion('refresh');
			});

			$.extend(true, metro.widgets, {
				$areas		: $('#widget-areas-list'),
				$boxes		: $('.widget-box'),
				selector	: {
					instances	: '.widget-list > ol',
					container	: '.widget-area-content'
				}
			});

			// Widget Instances Sortable
			metro.widgets.$areas.bind('accordioncreate', function(){
				metro.widgets.$instances = $(metro.widgets.selector.instances).sortable(metro.widgets.ui_options.sortable);
			});

			// Widget Instances Droppable
			metro.widgets.$areas.bind('accordioncreate', function(){
				metro.widgets.$container = $(metro.widgets.selector.container).droppable(metro.widgets.ui_options.droppable);
				metro.widgets.$areas.find('> section > header').droppable({
					accept: '.widget-box',
					addClasses: false,
					greedy: true,
					tolerance: 'pointer',
					over: function(){
						metro.widgets.$areas.accordion('option', 'active', this);
					}
				});
			});

			// Widget Areas Accordion
			metro.widgets.$areas.accordion(metro.widgets.ui_options.accordion);

			// Widget Boxes Draggable
			metro.widgets.$boxes.draggable(metro.widgets.ui_options.draggable);

			// Create a slug
			metro.generate_slug('input[name="title"]', 'input[name="slug"]');


			// MANAGE ------------------------------------------------------------------------------

			$('#widgets-list > tbody').livequery(function(){
				$(this).sortable({
					handle: 'span.move-handle',
					stop: function(){
						$('#widgets-list > tbody > tr').removeClass('alt');
						$('#widgets-list > tbody > tr:nth-child(even)').addClass('alt');

						var order = [];

						$('#widgets-list > tbody > tr input[name="action_to\[\]"]').each(function(){
							order.push(this.value);
						});

						order = order.join(',');

						$.post(SITE_URL + 'widgets/ajax/update_order/widget', { order: order });
					}
				});
			});

		},

		handle_area_form: function(anchor)
		{
			var $loading	= $('.fancybox-overlay'),
				$cbox		= $('.fancybox-inner'),
				$submit		= $cbox.find('button[value=save]'),
				$cancel		= $cbox.find('.btn.cancel'),
				$form		= $cbox.find('form'),
				url			= $(anchor).attr('href');

			$cancel.click(function(e){
				e.preventDefault();

				$.fancybox.close();
			});

			$submit.click(function(e){
				e.preventDefault();

				var data = $form.slideUp().serialize();

				$loading.show();

				$.post(url, data, function(response){
					var callback = false;

					if (response.status == 'success')
					{
						if (response.title)
						{
							// editing replace area title
						}

						if (response.html)
						{
							metro.widgets.$areas
								.html(response.html)
								.accordion('refresh');

							if (response.active)
							{
								metro.widgets.$areas.accordion('option', 'active', response.active);
							}
						}

						url.match(/create/) && $form.get(0).reset();

						callback = function(){
							$.fancybox.update();
							$.fancybox.close();
						};
					}
					else
					{
						callback = $.fancybox.update;
					}

					$loading.hide();
					$form.slideDown();

					metro.add_notification(response.message, {ref: $cbox, method: 'prepend'}, callback);

				}, 'json');
			});

			$.fancybox.update();
		},

		update_area: function(){
			var url = SITE_URL + 'admin/widgets/areas';

			metro.widgets.$areas.load(url, function(){
				$(this).accordion('refresh');
			});
		},

		prep_instance_form: function(item, container, action)
		{
			action || (action = 'add');

			var key	= (action == 'add') ? $(item).attr('id').replace(/^widget-/, '') : $(container).attr('id').replace(/^instance-/, ''),
				url	= (action == 'add') ? SITE_URL + 'admin/widgets/instances/create/' + key : $(item).attr('href');

			// known? receive the action form
			if (key in metro.cache.widget_forms[action])
			{
				// next step
				return metro.widgets.add_instance_form(metro.cache.widget_forms[action][key], container, action, key);
			}

			$.get(url, function(response){

				response = '<li id="' + action + '-instance-box" class="box widget-instance no-sortable">' +
							response + '</li>';

				// write action form into cache
				metro.cache.widget_forms[action][key] = response;

				metro.widgets.add_instance_form(response, container, action, key);

			}, 'html');
                        
		},

		add_instance_form: function(item, container, action, key)
		{
			var widget = {
				$item: $(item),
				$container: $(container)
			}, method = 'appendTo';

			if (action === 'edit')
			{
				widget.$container.parent().children('li.empty-drop-item.clone').slideUp(50, function(){
					$(this).remove();
				});
				method = 'insertAfter';
			}
			else
			{
				widget.$container.children('li.empty-drop-item').hide().removeClass('loading');
			}

			metro.widgets.handle_instance_form(widget.$item[method](widget.$container).slideDown(200, function(){
				metro.widgets.$boxes.draggable('disable');
				metro.widgets.$areas.accordion('refresh');
			}).children('form'), action, key);
		},

		handle_instance_form: function(form, action, key)
		{
			var $form		= $(form),
				$submit		= $form.find('#instance-actions button[value=save]'),
				$cancel		= $form.find('#instance-actions a.cancel')
				area_id		= $form.parents('div.widget-area-box').attr('data-id'),
				url			= $form.attr('action');

			if ($form.data('has_events'))
			{
				return;
			}
                                                
			$form.data('has_events', true);

			$cancel.click(function(e){
				e.preventDefault();

				var callback = action === 'edit' ? function(){
					$('li#instance-'+key).slideDown(function(){
						metro.widgets.$areas.accordion('refresh');
					});
				} : false;

				metro.widgets.rm_instance_form($form, action, key, callback);
			});

			$submit.click(function(e){
				e.preventDefault();

				var data = $form.serialize() + (action === 'add' ? '&widget_area_id=' + area_id : '');

				$.post(url, data, function(response){
					var callback	= false,
						options		= {};

					if (response.status == 'success')
					{
						callback = function(){
							metro.widgets.rm_instance_form($form, action, key, function(){
								metro.widgets.update_area();
								var $active = metro.widgets.$areas.find('> .instance-form > header:eq('+metro.widgets.$areas.accordion('option', 'active')+')').parent();

								if (response.active && response.active !== ('#' + $active.attr('id') + ' header'))
								{
									metro.widgets.$areas.accordion('option', 'active', response.active);
								}
							});
						}
                                                callback();
					}
					else
					{
						options = {
							ref: $form.children('header:eq(0)')
						}
					}

					metro.add_notification(response.message, options, callback);

				}, 'json');
			});
		},

		rm_instance_form: function(form, action, key, callback)
		{
			$(form).parent().slideUp(50, function(){
				action === 'add'
					? $(this).remove()
					: key
						? metro.cache.widget_forms[action][key] = $(this).detach()
						: metro.cache.widget_forms[action] = {};

				metro.widgets.$boxes.draggable('enable');
				metro.widgets.$areas.accordion('refresh');
				callback && callback();
                                window.history.go(0);
			});
		}

//		,scroll_to: function(ele){
//			$('html, body').animate({
//				scrollTop: $(ele).offset().top
//			}, 1000);
//		}

	};
	
	metro.widgets.init();

	// Slide toggle for widget codes
	$(".instance-code").on('click', function(){
		$('#'+$(this).attr('id')+'-wrap').toggle();
	});

	// Select code 
	$(".widget-code").focus(function(){$(this).select()});
	$(".widget-code").mouseup(function(e){e.preventDefault();});

});