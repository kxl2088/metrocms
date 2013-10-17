$(document).ready(function () {
    var checkedBoxes = $(".errors_overview input:checkbox:checked").length;
    var totalErrors = parseInt($('input[name=total_errors]').attr('value'));
    var checkbox_disabled_at = parseInt($('input[name=checkbox_disabled_at]').attr('value'));
    var notify = function () {
        setTimeout(function () {
            jSuccess(
                finishedScrolling,
                {
                    autoHide:true, // added in v2.0
                    TimeShown:2000,
                    HorizontalPosition:'center',
                    VerticalPosition:'center',
                    ShowOverlay:false,
                    onCompleted:function () { // added in v2.0
                    }
                }
            )
        }, 250);
    };

    $('.scroll-to-bottom').click(function () {
        $('html, body').animate({scrollTop:$(document).height()}, 'slow');
        return false;
    });

    $('.scroll-to-top').click(function () {
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });

    // Onclick with each log_errors anchor
    $('.log_errors a').livequery('click', function () {
        // Open a new window with the correct function in the PHP.net manual
        window.open('http://php.net/manual/en/' + $(this).attr('href'), '_blank');
        // Don't follow the original URL
        return false;
    });

    // Hovering on anchors
    $(".log_errors a").hover(
        // Add the title of the function
        function () {
            $(this).attr('title', $(this).html().split('.')[1]);
        },
        // Remove it, so we don't have all this ridicolous data in our html
        function () {
            $(this).removeAttr('title');
        }
    );


    $('.errors_overview input[type=checkbox]').click(function (checkbox) {
        var rows = $('.log_errors tr .' + ($(this).attr('name')));
        var actions = $(this).parent().parent().find('.actions');
        if ($(this).is(':checked')) {
            actions.show();
            rows.each(function () {
                $(this).parent().parent().show('fast');
            });
            checkedBoxes++;
        }
        else {
            actions.hide();
            rows.each(function () {
                $(this).parent().parent().hide('medium');
            });
            checkedBoxes--;
        }
        if (checkedBoxes == 0) {
            $(".log_errors").hide();
        }
        else if (!$(".log_errors").is(":visible")) {
            $(".log_errors").show();
        }
    });

    // When this number is above [xxx]
    if (totalErrors > checkbox_disabled_at) {
        // Loop through all it's checkboxes
        $('.errors_overview input[type=checkbox]').each(function () {
            // And disable to make sure the page doesn't fail on further (user)actions
            $(this).attr('disabled', 'disabled');
        });
    }


    // On one of the errors clicked in the overview, scroll to the error (depends on the rel if it's the first or last occurence)
    $(".errors_overview a").livequery('click', function () {
        $('.log_errors tr .' + ($(this).attr('class')) + ':' + ($(this).attr('rel'))).scrollintoview({
            duration:"slow",
            direction:"y",
            complete:notify
        });
        return false;
    });
});