$(document).ready(function(){
    /**
    * Autocomplete Search
    */
    metro.get_items_autocomplete = function(){

            function split( val ) {
              return val.split( /,\s*/ );
            }
            function extractLast( term ) {
              return split( term ).pop();
            }

            $( ".label_field" )
              // don't navigate away from the field on tab when selecting an item
              .bind( "keydown", function( event ) {           
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).data( "ui-autocomplete" ).menu.active ) {                                
                    event.preventDefault();                                
                }
              })
              .autocomplete({
                source: function( request, response ) {                                
                  $.getJSON( SITE_URL + "streams_core/public_ajax/field/multiple/autocomplete", {
                    term: extractLast( request.term ),
                    stream_id: STREAM_ID
                  }, response );
                },
                search: function() {
                  // custom minLength
                  var term = extractLast( this.value );
                  if ( term.length < 1 ) {
                    return false;
                  }
                },
                focus: function() {
                  // prevent value inserted on focus
                  return false;
                },
                select: function( event, ui ) {
                    var test = false;
                    
                    $('.id_text_field').each(function(){
                        if($(this).text() == ui.item.value){
                            test = true;
                            $(this).parent().parent().find('.label_field').focus();
                        }
                    });
                    
                    if(test == false){
                        $(this).parent().parent().find('.id_field').val(ui.item.value);  
                        $(this).parent().parent().find('.id_text_field').html(ui.item.value);  
                        $(this).val(ui.item.name);     
                    }else{
                        $(this).val(''); 
                    }
                    return false;
                }
              });
    };
    
    metro.sort_items = function() {
        
        $("#item-multiple-list tr:not(.skip)").each(function(index) {
            var $selector = $(this);            
            $selector.attr('id', 'item_'+ index);
            
            $.each(FIELDS_NAMES, function(key, value){                
                $selector.find('td .'+ value +'_field').attr('name', SLUG_NAME + '['+ index +']['+ value +']');
            });
            
            $selector.find('td .remove').attr('data-row', 'item_'+ index);
        });
        
    };
    
    metro.get_items_autocomplete();

    $('#add-item-multiple').click(function() {
        var index = $("#item-multiple-list tr:not(.skip)").length;
        var content = '<tr id="item_'+ index +'">';

        $.each(FIELDS, function(key, value){
            content += '<td>'+ value +'</td>';
        });
        
        content += '<td><a class="btn red remove" data-row="item_' + index + '">'+ LANG_DELETE +'</a></td>';  
        content += '</tr>';

        $('#item-multiple-list').append(content);
        $("td:nth-child(2) input").focus();

        metro.sort_items();
        metro.get_items_autocomplete();
        
        return false;
    });

    $('#item-multiple-list .remove').on('click', function() {
        var item = $(this).attr('data-row');
        var test = confirm(metro.lang.dialog_message);
        if (test) {
            $('#'+item).remove();
            metro.sort_items();
        }
        return false;
    });
});