/**
 * Metro object
 *
 * The Metro object is the foundation of all PyroUI enhancements
 */
// It may already be defined in metadata partial
if (typeof(metro) == 'undefined') {
	var metro = {};
}

(function ($) {
	$(function () {
                                
                var timingRun = setInterval("$('.alert').slideUp('slow')",5000);    
                                
		// generate a slug when the user types a title in
		metro.generate_slug('#blog-content-tab input[name="title"]', '#blog-content-tab input[name="slug"]');

		// needed so that Keywords can return empty JSON
		$.ajaxSetup({
			allowEmpty: true
		});

		$('#keywords').tagsInput({
			autocomplete_url: SITE_URL + 'admin/keywords/autocomplete'
		});
                
                $(".colorbox-image").fancybox();
                
		// editor switcher
		$('select[name=type]').change(function () {

			var textarea = $('.editor textarea');

			// Destroy existing WYSIWYG instance
                        textarea.removeClass('html');
                        textarea.removeClass('html_editor');
                        textarea.removeClass('markdown');
                        textarea.removeClass('markdown_editor');
                        textarea.removeClass('wysiwyg-simple');
                        textarea.removeClass('wysiwyg-advanced');
                        $('.ace_edit_html').remove(); 
                        $('.ace_edit_markdown').remove(); 

                        var instance = CKEDITOR.instances[textarea.attr('id')];
                        instance && instance.destroy();
                        
                        if(this.value == 'html' || this.value == 'markdown'){
                                textarea.addClass(this.value + '_editor');
                        }
                        
			// Set up the new instance
			textarea.addClass(this.value);
			metro.init_ckeditor();
                        metro.init_ace_editor();
		});
                
                $('#add_category').livequery(function(){
                    $(this).fancybox({
                            width: 600,
                            height: 200,
                            fitToView: false,
                            autoSize: false,
                            closeClick: false,
                            openEffect: 'fade',
                            closeEffect: 'fade',
                            closeBtn: true,
                            type: 'ajax',
                            ajax: {
                                dataType : 'html'
                            },
                            afterShow: function () {
                                    $.fancybox.update();
                                    metro.fancybox_cancel();
                                    metro.alert_boxes();
                                    
                                    var $form_categories = $('form#categories');
                                    $form_categories.removeAttr('action');
                                    $form_categories.submit(function (e) {

                                            var form_data = $(this).serialize();

                                            $.ajax({
                                                    url: SITE_URL + 'admin/blog/categories/create_ajax',
                                                    type: "POST",
                                                    data: form_data,
                                                    success: function (obj) {

                                                            if (obj.status == 'ok') {

                                                                    //succesfull db insert do this stuff
                                                                    var $select = $('select[name=category_id]');
                                                                    //append to dropdown the new option
                                                                    $select.append('<option value="' + obj.category_id + '" selected="selected">' + obj.title + '</option>');
                                                                    $select.trigger("liszt:updated");
                                                                    // TODO work this out? //uniform workaround
                                                                    $(document.getElementById('blog-options-tab')).find('li').first().find('span').html(obj.title);

                                                                    //close the colorbox
                                                                    $.fancybox.close();
                                                            } else {
                                                                    //no dice
                                                                    var html = "<script>";
                                                                    html += "\tmetro.alert_boxes();\n";
                                                                    html += "</script>";
                                                                    //append the message to the dom
                                                                    var $cboxLoadedContent = $('.fancybox-inner');
                                                                    $cboxLoadedContent.prepend(html + obj.message);
                                                            }
                                                    }
                                            });
                                            e.preventDefault();
                                    });
                            }
                    });
            });
            
            metro.sortable = function(){
                
                /**
                * Sortable
                */
                $('#image_container ul').sortable({
                    handle: 'a.move-image',
                    helper: 'clone',
                    cursor: "move",
                    distance: 1,
                    opacity: 0.1,
                    scroll: true,
                    
                    start: function(event, ui) {
                            $('li').removeClass('alt');
                    },                    
                    update: function() {
                            order = new Array();
                            $('li', this).each(function(){
                                    order.push( $(this).find('input[name="images[]"]').val() );
                            });
                            order = order.join(',');

                            $.post(BASE_URL + 'admin/blog/ajax_update_order', { order: order }, function(e) {
                                    $('li').removeClass('alt');
                                    $('li:even').addClass('alt');
                            
                            }, 'json');
                    },                    
                    stop: function(event, ui) {
                            $("ul li:nth-child(even)").livequery(function () {
                                    $(this).addClass("alt");
                            });
                    }
                    
                }).disableSelection();   
                
            };
            
            metro.delete_image = function(obj, image_id){
                
                bootbox.confirm('Tem certeza que deseja remover esta imagem?', function (result) {
                    if(result == true && image_id)
                    {
                        $.ajax({
                            type: "POST",
                            url: BASE_URL + "admin/blog/uploader/delete/" + image_id,
                            data: { id : image_id },
                            dataType: "json",
                            success: function(json){
                               if(json.process == 'success')
                               {
                                   $('#content-body').prepend('<div id="'+ image_id +'" class="alert success animated fadeIn"><p>O arquivo '+ json.message +' com sucesso.</p></div>')
                                   $(image_id).fadeIn('slow')
                                   $(obj).parent().remove();
                                   window.setInterval("$('.alert').remove()", 5000);
                                   metro.alert_boxes();
                                   return false;
                               }
                               else
                               {
                                   $('#content-body').prepend('<div id="'+ image_id +'" class="alert error animated fadeIn"><p>'+ json.message +'.</p></div>')
                                   $(image_id).fadeIn('slow')
                                   $(obj).parent().remove();     
                                   window.setInterval("$('.alert').remove()", 5000);
                                   metro.alert_boxes();
                                   return false;
                               }
                            },
                            error: function(json){
                                $('#content-body').prepend('<div id="'+ image_id +'" class="alert error animated fadeIn"><p>Ocorreu um erro ao tentar obter informações. Recarregue está página e tente novamente!</p></div>')
                                $(image_id).fadeIn('slow')
                                metro.alert_boxes();
                                return false;
                            }
                        });
                    }        
                });                
        };

        metro.upload_buttons = function(){

            var buttons = '<a href="#" id="upload_start" class="btn btn-success">'+uploadButtonStart+'</a>&nbsp;';
            buttons += '<a href="#" id="upload_stop" class="btn btn-danger">'+uploadButtonStop+'</a>&nbsp;';
            buttons += '<a href="#" id="upload_cancel" class="btn btn-warning">'+uploadButtonClear+'</a>&nbsp;';

            $('#upload_buttons').html(buttons);

            $('#upload_start').click(function(){
                $('#userfile').uploadify('upload', '*');
                metro.alert_boxes();
                return false;
            });

            $('#upload_cancel').click(function(){
                $('#userfile').uploadify('cancel', '*');   

                $('.alert').remove();
                $('div#content-body').prepend('<div class="alert error"><p>'+uploadClearMessage+'</p></div>');

                clearInterval(timingRun);
                timingRun = setInterval("$('.alert').slideUp('slow')",5000);    
                metro.alert_boxes();
                return false;
            });

            $('#upload_stop').click(function(){
                $('#userfile').uploadify('stop');        

                $('.alert').remove();
                $('div#content-body').prepend('<div class="alert error"><p>'+uploadStopMessage+'</p></div>');

                clearInterval(timingRun);
                timingRun = setInterval("$('.alert').slideUp('slow')",5000);    
                metro.alert_boxes();
                return false;
            });
        };
        
        metro.uploadfy_source = function(){

            var timingRun = setInterval("$('.alert').slideUp('slow')",5000);

            $('#userfile').uploadify({
                'swf'      : uploadSWF,
                'uploader' : uploadURL,
                'onDialogClose'  : function(queueData) {
                    var post = $('#userfile').uploadify('settings','formData');            
                    post.folder = uploadFolder;
                    $('#userfile').uploadify('settings','formData', post);
                    console.log($('#userfile').uploadify('settings','formData'));                 
                },
                'onDialogOpen' : function() {
                    $('#upload_buttons').html('');     
                },
                'onSelect' : function(file) {
                    metro.upload_buttons();   
                },
                'progressData' : 'speed',
                'auto': false,
                'fileObjName' : 'userfile', 
                'method'   : 'post',
                'buttonText' : uploadButtonText, 
                'fileTypeDesc' : uploadFileTypeDesc,
                'fileTypeExts' : uploadAllowedExtensions, 
                'fileSizeLimit' : uploadSizeLimit,
                'formData' : { 
                    'csrf_hash_name': $('input[name=csrf_hash_name]').val(), 
                    uploadCookieName : uploadSessionId
                },
                'onUploadSuccess' : function(file, result, response) {

                    if (console) console.log(result);
                    result = jQuery.parseJSON(result)            

                    if (result.status) 
                    {
                        if (console) console.log (result.data);
                        var item = '<input type="hidden" name="images[]" value="'+ result.data.id + '" />';
                        var file = "<li><span>"+item;
                        file += '<a href="'+SITE_URL+'files/large/' + result.data.filename + '" class="fancybox" data-fancybox-group="gallery" title="'+ result.data.alt_attribute +'">';
                        file += '<img src="'+SITE_URL+'files/thumb/' + result.data.filename + '/150/120/fit" />';
                        file += '</a>';
                        file += '<a class="delete-image" onclick="javascript:metro.delete_image(this, \'' + result.data.id + '\');return false;" href="#">'+uploadButtonRemove+'</a>';                        
                        file += "</span></li>";
                        //thumb list                
                        $('#image_container').append(file);
                        $(".fancybox").fancybox();                    
                        $('.alert').remove();    
                        metro.alert_boxes();
                    } 
                    else 
                    {
                        $('.alert').remove();
                        $('div#content-body').prepend('<div class="alert error"><p>'+result.message+'</p></div>');
                        $(".alert").fadeIn("slow");
                        metro.alert_boxes();
                    }                    
                },
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    $('.alert').remove();
                    $('div#content-body').prepend('<div class="alert error"><p>'+errorMsg+'</p></div>');
                    $(".alert").fadeIn("slow");
                    metro.alert_boxes();
                },
                'onQueueComplete' : function(file) {
                    $('div#content-body').prepend('<div class="alert success"><p>'+uploadSuccessMessage+'</p></div>');
                    clearInterval(timingRun);
                    timingRun = setInterval("$('.alert').slideUp('slow')",5000);      
                    setInterval("$('#upload_progress').fadeOut('slow')",5000);

                    $('#upload_stop').click(function(){
                        metro.upload_buttons();
                    });       
                    metro.alert_boxes();
                },
                'onClearQueue' : function(queueItemCount) {
                    $('div#content-body').prepend('<div class="alert success"><p>'+queueItemCount + uploadClearMessage+'</p></div>');
                    clearInterval(timingRun);
                    timingRun = setInterval("$('.alert').slideUp('slow')",5000);

                    $('#upload_buttons').html('');
                    metro.alert_boxes();
                },
                'onUploadProgress' : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal) {
                    totalBytesUploaded = totalBytesUploaded/1024/1024;
                    totalBytesTotal = totalBytesTotal/1024/1024;

                    $('#upload_progress').html('<div class="uploaded_progress">' + totalBytesUploaded.toFixed(2) + 'MB enviados de ' + totalBytesTotal.toFixed(2) + 'MB.</div>');
                    metro.alert_boxes();
                }
            });
        };
        
        metro.uploadfy_source();
        metro.sortable();
            
        $('.delete-image').click(function() {
            return false;
        }); 

        $('.move-image').click(function(){
           return false; 
        });
        
    });
})(jQuery);