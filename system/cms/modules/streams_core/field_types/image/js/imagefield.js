$(function() {
  $('.image_remove').click(function(e){

    e.preventDefault();
    // Main Vars
    var field_slug = $(this).data('name');        
    // Vars
    var $field_remove = $('#'+ field_slug);
    var $field_link = $('#'+ field_slug +'_preview');
    var $field_hidden = $('#'+ field_slug +'_hidden');
    var file_id = $field_hidden.val();
    
    if( ACCESS_LEVEL == 1)
    {
        bootbox.confirm((metro.lang.dialog_message) , function (result) 
        {
            if (result == true){

                    $.post(SITE_URL + "files/remove_file", { id: file_id, level: ACCESS_LEVEL }, function(data, txtStatus) 
                    {
                        if(txtStatus == 'success')
                        {
                            if ( data.status == true)
                            {
                                $('.alert').remove();
                                $('#content-body').prepend('<div class="alert success"><p>'+data.message+'</p></div>');
                                $(".alert").fadeIn("slow");
                                metro.alert_boxes();
                                $field_hidden.attr('value', '');
                                // remove the a tag
                                $field_link.remove();
                                // remove this close button
                                $field_remove.remove();
                                if( $('#content-body').index() == -1){
                                    alert(data.message);
                                }
                            }
                            else{
                                $('.alert').remove();
                                $('#content-body').prepend('<div class="alert success"><p>'+data.message+'</p></div>');
                                $(".alert").fadeIn("slow");
                                metro.alert_boxes();
                                if( $('#content-body').index() == -1){
                                    alert(data.message);
                                }
                            }
                        }
                        else
                        {
                            alert('Ocorreu um erro inesperado!');
                        }
                    }, "json");    
            }
        });        
    }
    else
    {
        if( confirm(metro.lang.dialog_message) )
        {
            $.post(SITE_URL + "files/remove_file", { id: file_id, level: ACCESS_LEVEL }, function(data, txtStatus) 
            {
                if(txtStatus == 'success')
                {
                    if ( data.status == true)
                    {
                        $('.alert').remove();
                        $('#content-body').prepend('<div class="alert success"><p>'+data.message+'</p></div>');
                        $(".alert").fadeIn("slow");
                        $field_hidden.attr('value', '');
                        // remove the a tag
                        $field_link.remove();
                        // remove this close button
                        $field_remove.remove();
                    }
                    else{
                        $('.alert').remove();
                        $('#content-body').prepend('<div class="alert success"><p>'+data.message+'</p></div>');
                        $(".alert").fadeIn("slow");
                        if( $('#content-body').index() == -1){
                            alert(data.message);
                        }
                    }
                }
                else
                {
                    alert('Ocorreu um erro inesperado!');
                }
            }, "json");       
        }
    }
    return false;
  });
}); 