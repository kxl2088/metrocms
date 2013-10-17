$(document).ready(function() {    
        alert_boxes();
});

// Add icon and button close to alert boxes
function alert_boxes(){
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
             $(document).find('.add.btn').prepend('<i class="icon-plus"></i>&nbsp;');
             $(document).find('button[value=delete]').removeClass('btn-primary').addClass('btn-danger');
}