/**
 * Metro object
 *
 * The Metro object is the foundation of all PyroUI enhancements
 */
// It may already be defined in metadata partial
if (typeof(metro) == 'undefined') {
	var metro = {};
}

$(document).ready(function() {
    
        // Set up an object for caching things
	metro.cache = {
		// set this up for the slug generator
		url_titles	: {}
	};
        
        $('.responsive-leftbar').click(function(){
            $('.leftbar').toggleClass('leftbar-close expand',500, 'easeOutExpo');
        });
        
        // Is Mobile?
	metro.is_mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
        
        if($(document).find('.no_data, .no-data').index() != -1)
        {
            $(document).find('.table_action_buttons').hide();
        }
        else
        {
            $(document).find('.table_action_buttons').show();
        }
        
        // Add icon and button close to alert boxes
        metro.alert_boxes = function(){
             $(document).find('.alert').addClass('animated fadeIn');
             $(document).find('.alert.error').removeClass('error').addClass('alert-error');
             $(document).find('.alert.notice').removeClass('notice');
             $(document).find('.alert.warning').removeClass('warning');
             $(document).find('.alert.success').removeClass('success').addClass('alert-success');
                          
             $('.alert').find('i:not(.skip), button:not(.skip)').remove();
             $('.alert').prepend('<i class="icon-exclamation-sign"></i><button type="button" class="close" data-dismiss="alert">×</button>');
             $('.alert.alert-success .icon-exclamation-sign').removeClass('icon-exclamation-sign').addClass('icon-ok-sign');
             $('.alert.alert-error .icon-exclamation-sign').removeClass('icon-minus-sign').addClass('icon-minus-sign');
             
             $(document).find('.cancel').addClass('btn btn-danger');
             $(document).find('.button.red').removeClass('button red').addClass('btn btn-danger');
             $(document).find('.button.blue').removeClass('button blue').addClass('btn btn-primary');
             $(document).find('.button.green').removeClass('button green').addClass('btn btn-success');
             $(document).find('.button.orange').removeClass('button orange').addClass('btn btn-warning');
             $(document).find('.button.black').removeClass('button black').addClass('btn btn-inverse');
             $(document).find('.button').removeClass('button btn').addClass('btn');
             $(document).find('.add.btn i.icon-plus').remove();
             $(document).find('.add.btn').prepend('<i class="icon-plus"></i>&nbsp;').removeClass('add').addClass('add_button');
             $(document).find('button[value=delete]').removeClass('btn-primary').addClass('btn-danger');
        };
        
	/**
	 * Overload the json converter to avoid error when json is null or empty.
	 */
	$.ajaxSetup({
		converters: {
			'text json': function(text) {
				var json = $.parseJSON(text);
				if (!$.ajaxSettings.allowEmpty && (json == null || $.isEmptyObject(json)))
				{
					$.error('The server is not responding correctly, please try again later.');
				}
				return json;
			}
		},
		data: {
			csrf_hash_name: $.cookie(metro.csrf_cookie_name)
		}
	});
        
	/**
	 * Hides admin header to avoid overlapping when CKEDITOR is maximized
	 */
	metro.init_ckeditor_maximize = function() {
		if (typeof CKEDITOR != 'undefined')
		{
			$.each(CKEDITOR.instances, function(instance) {
				CKEDITOR.instances[instance].on('maximize', function(e) {
					if(e.data == 1) //maximize
					{
						$('.hide-on-ckeditor-maximize').addClass('hidden');
						$('.cke_button__maximize').addClass('ckeditor-metro-logo');
					}
					else if(e.data == 2) //snap back
					{
						$('.hide-on-ckeditor-maximize').removeClass('hidden');
						$('.cke_button__maximize').removeClass('ckeditor-metro-logo');
					}
				});
			});
		}
	};
        
        /**
	 * Autocomplete Search
	 */
	metro.init_autocomplete_search = function(){
            
                function split( val ) {
                  return val.split( /,\s*/ );
                }
                function extractLast( term ) {
                  return split( term ).pop();
                }

                $( ".search-query" )
                  // don't navigate away from the field on tab when selecting an item
                  .bind( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                        $( this ).data( "ui-autocomplete" ).menu.active ) {
                      event.preventDefault();
                    }
                  })
                  .autocomplete({
                    source: function( request, response ) {
                      $.getJSON( SITE_URL + "admin/search/ajax_autocomplete", {
                        term: extractLast( request.term )
                      }, response );
                    },
                    search: function() {
                      // custom minLength
                      var term = extractLast( this.value );
                      if ( term.length < 2 ) {
                        return false;
                      }
                    },
                    focus: function() {
                      // prevent value inserted on focus
                      return false;
                    },
                    select: function( event, ui ) {
                      window.location.href = ui.item.value;
                      return false;
                    }
                  });
	};

	/**
	 * This initializes all JS goodness
	 */
        
        metro.init = function() {           

		// Close the notifications when the close link is clicked
		$('a.close').click( function(e){
			e.preventDefault();
			$(this).fadeTo(200, 0); // This is a hack so that the close link fades out in IE
			$(this).parent().fadeTo(200, 0);
			$(this).parent().slideUp(400, function(){
				$(window).trigger('notification-closed');
				$(this).remove();
			});
		});
                
                $.fn.datetimepicker.defaults = {
                    maskInput: true,           // disables the text input mask
                    pickDate: true,            // disables the date picker
                    pickTime: true,            // disables de time picker
                    pick12HourFormat: false,   // enables the 12-hour format time picker
                    pickSeconds: true,         // disables seconds in the time picker
                    startDate: -Infinity,      // set a minimum date
                    endDate: Infinity          // set a maximum date
                };
                
                $('#datetimepicker1, .datetimepicker1').datetimepicker({
                    pickTime: true
                });
                
                $('#datetimepicker2, .datetimepicker2').datetimepicker({
                    pickTime: false
                });
                                                 
		// Fade in the notifications
		$('.alert').fadeIn('slow', function(){
			$(window).trigger('notification-complete');

		});
        };
              
        metro.confirm_box = function(){            
                // Confirmation
		$('a.confirm').click( function(e){
			e.preventDefault();

			var href		= $(this).attr('href');
			var removemsg           = $(this).attr('title');
                        var selector            = $(this);
                        
                        bootbox.confirm((metro.lang.dialog_message || removemsg) , function (result) {
                            if (result == true)
                            {
                                selector.trigger('click-confirmed');

				if ($.data(this, 'stop-click')){
					$.data(this, 'stop-click', false);
					return;
				}
				window.location.replace(href);
                            }
                        });
		});

		//use a confirm dialog on "delete many" buttons
		$(':submit.confirm').click( function(e, confirmation){
                        
			if (confirmation)
			{
				return true;
			}
                        
			e.preventDefault();

			var removemsg   = $(this).attr('title');
                        var selector    = $(this);
                        
                        bootbox.confirm((metro.lang.dialog_message || removemsg) , function (result) {
                            if (result == true)
                            {
                                
                                selector.trigger('click-confirmed');

				if (selector.data('stop-click')){
					selector.data('stop-click', false);
					return;
				}

				selector.trigger('click', true);
                                
                            }
                        });
		});            
        };
                
        metro.checkboxes = function(){
		// Check all checkboxes in container table or grid
		$(".check-all").click( function () {
			var check_all		= $(this),
				all_checkbox	= $(this).is('.grid-check-all')
					? $(this).parents(".list-items").find(".grid input[type='checkbox']")
					: $(this).parents("table").find("tbody input[type='checkbox']");

			all_checkbox.each(function () {
				if (check_all.is(":checked") && ! $(this).is(':checked'))
				{
					$(this).click();
				}
				else if ( ! check_all.is(":checked") && $(this).is(':checked'))
				{
					$(this).click();
				}
			});

			// Check all?
			$(".table_action_buttons .btn").prop('disabled', false);
		});
                                
		// Table action buttons start out as disabled
		$(".table_action_buttons .btn").prop('disabled', true);

		// Enable/Disable table action buttons
		$('input[name="action_to[]"], .check-all').click( function () {

			if( $('input[name="action_to[]"]:checked, .check-all:checked').length >= 1 ){
				$(".table_action_buttons .btn").prop('disabled', false);
			} else {
				$(".table_action_buttons .btn").prop('disabled', true);
			}
		});
        };
                
        metro.fancyboxes = function(){
                function set_title_modal (element){
                        var module_title = $('.main-wrapper .container-fluid .row-fluid .span12 .primary-head h3.page-header a').first().text();
                        var help_title = $('.main-wrapper .container-fluid .row-fluid .span12 .primary-head a.modal-ajax').text();
                        var current_module_title = '';

                        if ( element != '' )
                        {
                            current_module_title = element;
                        }
                        else
                        {
                            current_module_title = module_title + ' - ' + help_title;
                        }   

                        return current_module_title;
                }
                
                $(".fancybox").fancybox();
                
                // Colorbox modal window
		$('a[rel=modal-popup], a.modal-popup').livequery(function() {
                        var current_module_title = set_title_modal($(this).attr('title'));
			$(this).fancybox({
				width: "60%",
				maxHeight: "90%",
				fitToView: false,
                                autoSize: false,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'iframe',
                                title: current_module_title,
                                iframe: {
                                    scrolling : 'auto',
                                    preload   : true
                                },
                                beforeShow: function(){
                                    metro.alert_boxes();          
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
			});
		});

		$('a.inline-modal').livequery(function() {
                        var current_module_title = set_title_modal($(this).attr('title'));
			$(this).fancybox({
				width: "60%",
				maxHeight: "90%",
				fitToView: false,
                                autoSize: false,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'inline',
                                title: current_module_title,
                                beforeShow: function(){
                                    metro.alert_boxes();       
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
			});
		});

		$('a[rel="modal-large"], a.modal-large').livequery(function() {
                        var current_module_title = set_title_modal($(this).attr('title'));
			$(this).fancybox({
				width: "90%",
				height: "95%",
				fitToView: false,
                                autoSize: false,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'iframe',
                                title: current_module_title,
                                iframe: {
                                    scrolling : 'auto',
                                    preload   : true
                                },
                                beforeShow: function(){
                                    metro.alert_boxes();        
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
			});
		});
                
                $('a[rel="modal-small"], a.modal-small').livequery(function() {
                        var current_module_title = set_title_modal($(this).attr('title'));
			$(this).fancybox({
				width: "60%",
				height: "80%",
				fitToView: false,
                                autoSize: false,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'iframe',
                                title: current_module_title,
                                iframe: {
                                    scrolling : 'auto',
                                    preload   : true
                                },
                                beforeShow: function(){
                                    metro.alert_boxes();          
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
			});
		});
                
                $('a[rel="modal-resize"], a.modal-resize').livequery(function() {
                        var current_module_title = set_title_modal($(this).attr('title'));
			$(this).fancybox({
				width: "420",
				height: "280",
                                maxWidth: "60%",
                                maxHeight: "80%",
				fitToView: false,
                                autoSize: true,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'iframe',
                                title: current_module_title,
                                iframe: {
                                    scrolling : 'auto',
                                    preload   : true
                                },
                                beforeShow: function(){
                                    metro.alert_boxes();          
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
			});
		});
                
                $('a[rel="modal-ajax"], a.modal-ajax').livequery(function() {
                        var current_module_title = set_title_modal($(this).attr('title'));
			$(this).fancybox({
                                width: "60%",
                                height: "80%",
				maxWidth: "60%",
				maxHeight: "80%",
				fitToView: false,
                                autoSize: true,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'ajax',
                                ajax: {
                                    dataType : 'html'
                                },
                                beforeShow: function(){ 
                                    $('.fancybox-inner').find('hr').remove();
                                    $('.fancybox-inner').find('.no_doc_title').text(current_module_title);
                                    $.fancybox.update();
                                    metro.alert_boxes();          
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
			});
		});
                                
                // Fancybox iframe
                $('a[rel="modal-iframe"], a.modal-iframe').livequery(function(){
                        var current_module_title = set_title_modal($(this).attr('title'));
                        $(this).fancybox({
                                width: "60%",
                                maxHeight: "90%",
                                fitToView: false,
                                autoSize: false,
                                closeClick: false,
                                openEffect: 'fade',
                                closeEffect: 'fade',
                                closeBtn: true,
                                type: 'iframe',
                                title: current_module_title,
                                iframe: {
                                    scrolling : 'auto',
                                    preload   : true
                                },
                                beforeShow: function(){
                                    metro.alert_boxes();              
                                    metro.fancybox_cancel();
                                    metro.fix_table_lists();
                                }
                        });    
                });
                
        };
                
        metro.clear_notifications = function()
	{
		$('.alert .close').click();

		return metro;
	};
                
	metro.add_notification = function(notification, options, callback)
	{
		var defaults = {
			clear	: true,
			ref	: '#content-body',
			method	: 'prepend'
		}, opt;

		// extend options
		opt = $.isPlainObject(options) ? $.extend(defaults, options) : defaults;

		// clear old notifications
		opt.clear && metro.clear_notifications();

		// display current notifications
		$(opt.ref)[opt.method](notification);

		// call callback
		$(window).one('notification-complete', function(){
			callback && callback();
		});
                
                metro.alert_boxes();
                
		return metro;
	};

	// Used by Pages and Navigation and is available for third-party add-ons.
	// Module must load jquery/jquery.ui.nestedSortable.js and jquery/jquery.cooki.js
	metro.sort_tree = function($item_list, $url, $cookie, data_callback, post_sort_callback, sortable_opts)
	{
		// set options or create a empty object to merge with defaults
		sortable_opts = sortable_opts || {};
		
		// collapse all ordered lists but the top level
		$item_list.find('ul').children().hide();

		// this gets ran again after drop
		var refresh_tree = function() {

			// add the minus icon to all parent items that now have visible children
			$item_list.find('li:has(li:visible)').removeClass().addClass('minus');

			// add the plus icon to all parent items with hidden children
			$item_list.find('li:has(li:hidden)').removeClass().addClass('plus');
			
			// Remove any empty ul elements
			$('.plus, .minus').find('ul').not(':has(li)').remove();
			
			// remove the class if the child was removed
			$item_list.find("li:not(:has(ul li))").removeClass();

			// call the post sort callback
			post_sort_callback && post_sort_callback();
		}
		refresh_tree();

		// set the icons properly on parents restored from cookie
		$($.cookie($cookie)).has('ul').toggleClass('minus plus');

		// show the parents that were open on last visit
		$($.cookie($cookie)).children('ul').children().show();

		// show/hide the children when clicking on an <li>
		$item_list.find('li').click( function()
		{
			$(this).children('ul').children().slideToggle('fast');

			$(this).has('ul').toggleClass('minus plus');

			var items = [];

			// get all of the open parents
			$item_list.find('li.minus:visible').each(function(){ items.push('#' + this.id) });

			// save open parents in the cookie
			$.cookie($cookie, items.join(', '), { expires: 1 });

			 return false;
		});
		
		// Defaults for nestedSortable
		var default_opts = {
			delay: 100,
			disableNesting: 'no-nest',
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .4,
			placeholder: 'placeholder',
			tabSize: 25,
			listType: 'ul',
			tolerance: 'pointer',
			toleranceElement: '> div',
			update: function(event, ui) {

				post = {};
				// create the array using the toHierarchy method
				post.order = $item_list.nestedSortable('toHierarchy');

				// pass to third-party devs and let them return data to send along
				if (data_callback) {
					post.data = data_callback(event, ui);
				}

				// Refresh UI (no more timeout needed)
				refresh_tree();

				$.post(SITE_URL + $url, post );
			}
		};

		// init nestedSortable with options
		$item_list.nestedSortable($.extend({}, default_opts, sortable_opts));
	}

	// Create a clean slug from whatever garbage is in the title field
	metro.generate_slug = function(input_form, output_form)
	{
		$(output_form).slugify(input_form);
	};

	$(document).ajaxError(function(e, jqxhr, settings, exception) {
		if (exception != 'abort' && exception.length > 0) {
			metro.add_notification($('<div class="alert alert-error">'+exception+'</div>'));
                        metro.alert_boxes();
		}
	});
                
        //close colorbox only when cancel button is clicked
        metro.fancybox_cancel = function()
        {
            $('.fancybox-inner a.cancel').click(function(e) {
                    $.fancybox.close();
                    return false;
            });    
        };
        
        //Activing tabs
        metro.active_tabs = function(){
            $('#content-body .tab-widget ul.nav li:first').first().addClass('active');
            $('#content-body .tab-widget div.form_inputs').first().addClass('active');
            $('#content-body .tab-widget ul.nav li a').click(function(e){
                e.preventDefault();
                $(this).tab('show');
                return false;
            }); 
        },
                        
        metro.fix_filters = function(){
            $('#content-body').find('#filters form').addClass('form-filters');
        };
        
        metro.fix_table_lists = function(){
            if($(document).find('table:not(.skip,.responsive.table.table-hover.table-striped.table-bordered)').index() !== -1)
            {
                $(document).find('table:not(.skip)').addClass('responsive table table-hover table-striped table-bordered');                
            }
            if($('.table tr th:first-child, .table tr td:first-child').find('input').index() !== -1)
            {
                $('.table tr th:first-child, .table tr td:first-child').css('text-align', 'center');
            }
        };
        
	$('.fancybox-inner a.cancel').click(function(e) {
		e.preventDefault();
		$.fancybox.close();
                return false;
	});        
        
        metro.chosen = function(){
            $('select:not(.skip)').addClass('chzn-select');
            $('.chzn-select').chosen();
        };
                       
        metro.dashboard_quick_links = function (){
            
            // Draggable / Droppable
            if($(document).find('#sortable'))
            {
                $("#sortable").sortable({
                    placeholder : 'dropzone',
                    handle : '.board-widgets-head',
                    update : function () {
                      sort = new Array();

                      $('.row-fluid .span12', this).each(function(){
                            sort.push( $(this).find('input[name="shortcut[]"]').val() );
                      });
                      sort = sort.join(',');

                      $.post(SITE_URL + 'admin/update_shortcuts_order', { order: sort }, function(e){
                          if(e.status)
                          {
                              $.post(SITE_URL + 'admin/update_user_shortcuts', { order: sort }, function(f){
                                          $('.alert').slideUp('fast').delay(100).remove();
                                          $('#content-body').delay(120).prepend('<div class="alert alert-'+ f.status +' animated fadeIn"><i class="icon-minus-sign"></i><button type="button" class="close" data-dismiss="alert">×</button>'+ f.message +'</div>');
                                          metro.alert_boxes();
                                      }, 'json');  
                          }
                      }, 'json');               
                    }
                 });
            }
        };
        
        metro.fileupload = function(){
            var inputs_type = $('.controls:not(.skip) input[type=file]');
            
            if(inputs_type){
                $(inputs_type).each(function(){
                        $(this).before('<div class="fileupload fileupload-new" data-provides="fileupload"><div class="input-append"><div class="uneditable-input span3"> <i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span> </div><span class="btn btn-primary btn-file"><span class="fileupload-new">Selecione o arquivo</span><span class="fileupload-exists">Alterar</span><input type="file" name="'+ $(this).attr('name') +'"></span><a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remover</a> </div></div>');
                        $(this).remove();
                  });
            }
        };
                
        if(CURRENT_LANGUAGE == 'br') bootbox.setLocale('br');
        
        metro.init();
        metro.alert_boxes();
        metro.active_tabs();
        metro.chosen();
        metro.fix_table_lists();
        metro.init_ckeditor_maximize();
        metro.init_autocomplete_search();
        metro.fancyboxes();
        metro.checkboxes();
        metro.confirm_box();
        metro.fileupload();
        metro.dashboard_quick_links();
        
        $('.topbar-search').find('.btn.ok').click(function(){
            return false;
        });
	// Tooltip
	$('.tooltip').tooltip({
                placement: 'top'
        });

	$('.tooltip-t').tooltip({
		placement: 'top'
	});

	$('.tooltip-b').tooltip({
		placement: 'bottom'
	});

	$('.tooltip-r').tooltip({
		placement: 'right'
	});
        
        $('.tooltip-l').tooltip({
		placement: 'left'
	});
        
        //Fix CKEditor textarea value when submit a form
        $('form').submit(function(){

            var wysiwyg_areas = $('textarea.wysiwyg-simple, textarea.wysiwyg-advanced, textarea#intro.wysiwyg-simple');

            $.each(wysiwyg_areas, function(){        
                $(this).html($(this).val());
            });

        });
        
	//functions for codemirror
	$('.html_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'text/html',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});

	$('.css_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'css',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});

	$('.js_editor').each(function() {
		CodeMirror.fromTextArea(this, {
		    mode: 'javascript',
		    tabMode: 'indent',
			height : '500px',
			width : '500px',
		});
	});     
        
        $(".scroll-top").hide();
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scroll-top').fadeIn();
            } else {
                $('.scroll-top').fadeOut();
            }
        });

        $('.scroll-top a').click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 500);
            return false;
        });
        
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
            $('#myTab1 a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
            $('#myTab2 a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
            $('#chat-tab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('.left-primary-nav li a').tooltip({
            placement: 'right'
        });
            $('.row-action .btn').tooltip({
            placement: 'top'
        });
});