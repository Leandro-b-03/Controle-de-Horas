$(function () {
    $(window).on('beforeunload', function(){
        socket.close();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(':checkbox').iCheck({
        checkboxClass: 'icheckbox_square-yellow',
        radioClass: 'iradio_square-yellow',
        increaseArea: '20%' // optional
    });

    $('#delete').click(function() {
        if ($('#delete-id').val() != '') {
            $('#delete-form').submit();
        } else {
            var data = {
                type:'failed',
                name:$(this).attr('data-name'),
                kind:'no-data',
                message:'Não foram selecionados registros'
            }

            $.ajax({
                url: '/general/createMessageJSON',
                data: data,
                type: "GET",
                success: function(data) {
                    $('#messages').html(throwMessage(data));
                }
            });
        }
    });

    function throwMessage(data) {
        html = '<div class="alert alert-' + data.class + ' alert-dismissable">';
        html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        html += '<h4>    <i class="icon fa fa-' + data.faicon + '"></i> ' + data.status + '</h4>';
        html += data.message;
        html += '</div>';

        return html;
    }

    if ($.fn.DataTable) {
        if ($(".table").length > 0) {
            var table = $(".table").not('.permission').DataTable({
                language: {
                    processing:     dataTableLang.processing,
                    search:         dataTableLang.search,
                    lengthMenu:     dataTableLang.lengthMenu,
                    info:           dataTableLang.info,
                    infoEmpty:      dataTableLang.infoEmpty,
                    infoFiltered:   dataTableLang.infoFiltered,
                    infoPostFix:    dataTableLang.infoPostFix,
                    loadingRecords: dataTableLang.loadingRecords,
                    zeroRecords:    dataTableLang.zeroRecords,
                    emptyTable:     dataTableLang.emptyTable,
                    paginate: {
                        first:      dataTableLang.paginate_first,
                        previous:   dataTableLang.paginate_previous,
                        next:       dataTableLang.paginate_next,
                        last:       dataTableLang.paginate_last,
                    }
                }
            });
        }
    }

    var deselect = true;
    var delete_id = [];

    $('.select-all').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifChecked') {
            $(".delete").iCheck('check');
            deselect = true;
        } else {
            if(deselect){
                deselect = true;
                $(".delete").iCheck('uncheck');
            } else {
                deselect = true;
            }
        }
    });

    $('.delete').on('ifChecked ifUnchecked', function(event) {
        if (event.type == 'ifUnchecked') {
            if ($('.select-all').iCheck('ifChecked')) {
                deselect = false;
                $('.select-all').iCheck('uncheck');
            }

            var index = delete_id.indexOf($(this).attr('data-value'));
            delete_id.splice(index, 1);
        } else {
            if ($('table :checkbox').length == ($('table :checkbox:checked').length + 1))
                $('.select-all').iCheck('check');

            if (delete_id.indexOf($(this).attr('data-value')) == -1)
                delete_id.push($(this).attr('data-value'));
        }

        $('#delete-id').val(delete_id.join(','))
    });

    if (typeof inputmask !== 'undefined' && $.isFunction(inputmask)) {
        $('.input-mask').inputmask();
    }

    // console.log($.isFunction(datepicker));

    if ($('.date').length > 0) {
        $('.date').datepicker({
            format: 'dd/mm/yyyy'
        });
    }

    if ($(".permission-check").length > 0) {
        $(".permission-check").iCheck('destroy');
        $(".permission-check").bootstrapSwitch();
    }
});

function responsive_filemanager_callback(field_id){
    var url = $('#'+field_id).val();
    var url_web = location.origin;
    $('#'+field_id).val(url.replace(url_web, ''));
    
    $('#image').attr('src', url.replace('../', '/'));
}

//subscribe to our private channel
var PresenceChannel = pusher.subscribe("presence-user-" + user_id);

//do something with our new information
PresenceChannel.bind('new_notification', function(notification){
    // assign the notification's message to a <div></div>notification
    $('li.notifications-menu .dropdown-menu .menu').prepend(createNotification(notification));
});

//subscribe to our notifications channel
var notificationsChannel = pusher.subscribe('notifications');

//do something with our new information
notificationsChannel.bind('new_notification', function(notification){
    // assign the notification's message to a <div></div>notification
    $('li.notifications-menu .dropdown-menu .menu').prepend(createNotification(notification));

    titleCounter();
});

function createNotification(notification) {
    var count = $('.notification-count').html();
    if (count == '') {
        $('.notification-count').html(1);
    } else {
        $('.notification-count').html(parseInt($('.notification-count').html()) + 1);
    }

    var new_message = '';

    new_message += '<li>';
    new_message += '    <a href="' + notification.href + '">';
    new_message += '        <i class="fa fa-' + notification.faicon + ' text-aqua"></i> ' + notification.message;
    new_message += '    </a>';
    new_message += '</li>';

    return new_message;
}

function titleCounter() {
    original_title = document.title;

    update_count = parseInt($('.message-count').html()) + parseInt($('.notification-count').html()) + parseInt($('.tasks-count').html());

    document.title = "(" + update_count + ") " + original_title;
}