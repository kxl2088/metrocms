(function($) {
	$(function(){

		// Generate a slug from the title
		metro.generate_slug('input[name="title"]', 'input[name="slug"]', '_');

	});

})(jQuery);