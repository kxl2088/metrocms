$(document).ready(function(){

   $("#generate_passwd").click(function(){

     var input_passowrd = $("#password");
     $.ajax({
         type: "GET",
         url: BASE_URL + "admin/users/password_generator",
         dataType: "json",
         success: function(json){
            if(json)
            {
                input_passowrd.val(json.password);
                input_passowrd.attr('type', 'text');
            }
         }
      });

      return false;

   });

   $("#generate_username").click(function(){

     var input_username = $("#username");
     $.ajax({
         type: "POST",
         url: BASE_URL + "admin/users/username_generator",
         dataType: "json",
         data: { email : $("#email").val(), first_name : $("#first_name").val(), last_name : $("#last_name").val() },
         success: function(json){
            if(json)
            {
                input_username.val(json.username);
                if(json.message != '')
                {
                    $('div#content-body').prepend('<div class="alert alert-error animated fadeIn user_gen"><i class="icon-exclamation-sign icon-minus-sign"></i><button type="button" class="close" data-dismiss="alert">×</button>' + json.message + '</div>');
                }
            }
         }
      });

      return false;

   });
});