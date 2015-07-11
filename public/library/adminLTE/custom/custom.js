$(function () {
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