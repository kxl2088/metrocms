function add_field_parameters()
{
	var data = $('#field_type').val();
	var namespace = $('#fields_current_namespace').val();
	
	$.ajax({
		dataType: "text",
		type: "POST",
		data: 'data='+data+'&namespace='+namespace+'&csrf_hash_name='+$.cookie('csrf_cookie_name'),
		url: SITE_URL+'streams_core/ajax/build_parameters',
		success: function(returned_html) {
			$('.streams_param_input').remove();
			$('#parameters').append(returned_html);
			metro.chosen();
		}
	});
}

(function($)
{
	$(function() {
		$('#field_name').keyup(function() {
 	 		$('#field_slug').val(slugify($('#field_name').val()));
		});
	});
})(jQuery);