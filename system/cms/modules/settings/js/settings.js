jQuery(function($){
	var parents = '.tab-content .form_inputs';
	
	$(parents +' fieldset').sortable({
		handle: 'i.icon-move',
		update: function() {
			//$(parents +' ul li').removeClass('even');
			//$(parents +' ul li:nth-child(even)').addClass('even');
			order = new Array();
			$(parents +' .control-group').each(function(){
				order.push( this.id );
			});
			order = order.join(',');

			$.post(SITE_URL + 'admin/settings/ajax_update_order', { order: order });
		}

	});
});