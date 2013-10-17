$(function () {
    $("#tree2").dynatree({
        checkbox:true,
        selectMode:2,
        initAjax:{
            url: SITE_URL + "admin/log/physical/log_files"
        },
        onClick:function (node, event) {
            // We should not toggle, if target was "checkbox", because this
            // would result in double-toggle (i.e. no toggle)
            if (node.getEventTargetType(event) == "title")
                node.toggleSelect();
        },
        onKeydown:function (node, event) {
            if (event.which == 32) {
                node.toggleSelect();
                return false;
            }
        }
    });

    $('.buttons .btn').click(function () {
        metro.clear_notifications();
        var tree = $("#tree2").dynatree("getTree");
        var logs = tree.serializeArray();
        var btnAction = $(this).attr('rel')
        var formData = {
            logs:logs,
            action:btnAction
        };
        $.ajax({
            url:SITE_URL + 'admin/log/sync_log_files',
            type:"POST",
            data:formData,
            dataType:'json',
            success:function (data) {
                // If we are going to delete files
                if (btnAction == 'del_physical') {
                    // Loop through each node
                    $.each(logs, function (index, value) {
                        // And delete the fucker
                        tree.getNodeByKey(value.value).remove();
                    });
                }
                else if (btnAction == 'sync') {
                    $.each(logs, function (index, value) {
                        var node = tree.getNodeByKey(value.value);
                        if (node.data.addClass != 'oversized') {
                            node.data.addClass = 'saved-in-database';
                        }
                        node.data.select = false;
                        node.render();
                    });
                    deselectAll();
                }
                else if (btnAction == 'download') {
                    if (data.url) {
                        window.open(data.url);
                        $.each(logs, function (index, value) {
                            var node = tree.getNodeByKey(value.value);
                            node.data.select = false;
                            node.render();
                        });
                    }
                }
                if (data.count != undefined) {
                    showSelectedNotification(0, 'jError', data.message);
                }
                else {
                    metro.add_notification($('<div class="alert ' + data.status + '">' + data.message + '</div>'));
                }
            }
        });
        return false;
    });

    function showSelectedNotification(count, statusFunction, customline) {
        metro.clear_notifications();
        if (count == 0) {
            $.ajax({
                type:'POST',
                url:SITE_URL + 'admin/log/physical/selected_error',
                success:function (data) {
                    //Create the function
                    var fn = window[statusFunction];
                    //Call the function
                    fn(
                        (customline != undefined) ? (customline) : (data.errorLine),
                        {
                            autoHide:true, // added in v2.0
                            TimeShown:3000,
                            HorizontalPosition:'center',
                            VerticalPosition:'center',
                            ShowOverlay:true,
                            clickOverlay:true,
                            autoHide:false,
                            onCompleted:function () { // added in v2.0
                            }
                        }
                    );
                },
                dataType:'JSON'
            });
        }
    }

    function deselectAll() {
        $("#tree2").dynatree("getRoot").visit(function (node) {
            node.select(false);
        });
    }

    $("#btnSelectNonSynced").click(function () {
        var selectedNodes = 0;
        $("#tree2").dynatree("getRoot").visit(function (node) {
            // Any of those who have an 'addClass' are oversized or in our database :)
            if (node.data.addClass == '') {
                node.select(true);
                selectedNodes++;
            }
            else {
                node.select(false);
            }
        });
        showSelectedNotification(selectedNodes, 'jNotify');
        return false;
    });

    $("#btnSelectOversized").click(function () {
        var selectedNodes = 0;
        $("#tree2").dynatree("getRoot").visit(function (node) {
            // Any of those who have an 'addClass' are oversized or in our database :)
            if (node.data.addClass == 'oversized') {
                node.select(true);
                selectedNodes++;
            }
            else {
                node.select(false);
            }
        });
        showSelectedNotification(selectedNodes, 'jNotify');
        return false;
    });

    $("#btnToggleSelect").click(function () {
        $("#tree2").dynatree("getRoot").visit(function (node) {
            node.toggleSelect();
        });
        return false;
    });

    $("#btnDeselectAll").click(function () {
        deselectAll();
        return false;
    });

    $("#btnSelectAll").click(function () {
        $("#tree2").dynatree("getRoot").visit(function (node) {
            node.select(true);
        });
        return false;
    });
});