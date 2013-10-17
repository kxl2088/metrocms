(function($) {

	$(function(){

	metro.generate_slug('input[name="field_name"]', 'input[name="field_slug"]', '_', true);

	$('#field_type').change(function() {

		var field_type = $(this).val();
                var current_url = self.location.href;
                var splits = /admin\/(\w+)/.exec(current_url);
                var mode = '';
                var app_path = metro.current_app_path;
                
                if(splits.length > 1) mode = splits[1];
                                
		$.ajax({
			dataType: 'text',
			type: 'POST',
			data: 'data='+field_type+'&mode='+mode+'&app_path='+app_path+'&csrf_hash_name='+$.cookie(metro.csrf_cookie_name),
			url:  SITE_URL+'streams_core/ajax/build_parameters',
			success: function(returned_html){
				$('.streams_param_input').remove();
				$('.form_inputs > ul').append(returned_html);
				metro.chosen();
			}
		});

	});
	
	$(document).ready(function() {
	  	$('.input :input:visible:first').focus();
	});
	
	});

})(jQuery);
