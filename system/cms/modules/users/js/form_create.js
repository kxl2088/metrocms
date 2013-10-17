$(document).ready(function(){
    $("#email").change(function(){
     $.ajax({
         type: "POST",
         url: BASE_URL + "admin/users/email_ajax_check",
         dataType: "json",
         data: { email : $("#email").val() },
         success: function(json){
            if(json)
            {
                if(json.status == true)
                {
                    $("#messages").html('<div class="alert error">' + json.message + '.</div>');
                    $("#messages").slideDown('fast');
                }
            }
         }
      });
   });
});