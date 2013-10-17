jQuery(document).ready(function ($) {

	// Add that cool orange bkg to the input that has focus
	$('input, select').bind({
		focusin: function () {
			$(this)
				.closest('.input')
				.addClass('block-message metro');
		},
		focusout: function () {
			$(this)
				.closest('.input')
				.removeClass('block-message metro');
		}
	});

	$('input[name="database"]').on('keyup', function () {
		var $db = $('input[name=database]');
		// check the database name for correct alphanumerics
		if ($db.val().match(/[^A-Za-z0-9_-]+/)) {
			$db.val($db.val().replace(/[^A-Za-z0-9_-]+/, ''));
		}
	});
            
        function test_db()
        {          
                $.post(base_url + 'index.php/ajax/confirm_database', {
                                database: $('input[name=database]').val(),
                                create_db: $('input[name=create_db]').is(':checked'),
                                server: $('input[name=hostname]').val(),
                                port: $('input[name=port]').val(),
                                username: $('input[name=username]').val(),
                                password: $('input[name=password]').val()
                        }, function (data) {
                                if (data.success === true) {
                                        $.gritter.add({
                                            // (string | mandatory) the heading of the notification
                                            title: 'Testando conexão com banco!',
                                            // (string | mandatory) the text inside the notification
                                            text: data.message
                                        });
                                        
                                        $('input[type=submit]').prop('disabled', false);
                                        return true;
                                } else {
                                        $.gritter.add({
                                            // (string | mandatory) the heading of the notification
                                            title: 'Testando conexão com banco!',
                                            // (string | mandatory) the text inside the notification
                                            text: data.message
                                        });
                                        
                                        $('input[type=submit]').prop('disabled', true);
                                        return false;
                                }
                        }, 'json'
                );
        }
        
        $('input[name=password]').change(function () {
            test_db();
        });
        
        $('form.step_1').submit(function () {
            test_db();
        });

	$('select#http_server').change(function () {
		if ($(this).val() == 'apache_w') {
			$.post(base_url + 'index.php/ajax/check_rewrite', '', function (data) {
				if (data !== 'enabled') {
                                        $.gritter.add({
                                            // (string | mandatory) the heading of the notification
                                            title: 'Testando servidor Apache!',
                                            // (string | mandatory) the text inside the notification
                                            text: data
                                        });
				}
			});
		}
	});

	// Password Complexity
	$('#user_password').complexify({}, function (valid, complexity) {
		var $progress = $('#progress');
		if (!valid) {
			$progress
				.css({ 'width': complexity + '%' })
				.removeClass('progressbarValid')
                                .removeClass('password-strong password-week')
				.addClass('password-weak');
		} else {
			$progress
				.css({ 'width': complexity + '%' })
				.removeClass('progressbarInvalid')
                                .removeClass('password-strong password-week')
				.addClass('password-strong');
		}
		$('#complexity').html(Math.round(complexity) + '%');
	});

});
