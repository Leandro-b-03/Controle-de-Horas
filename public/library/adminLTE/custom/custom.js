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

    var table = $(".table").DataTable({
        language: {
            processing:     "Carregando...",
            search:         "Pesquisar&nbsp;:",
            lengthMenu:     "Exibir _MENU_ registros",
            info:           "Exibindo de _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:      "Exibindo de 0 a 0 de 0 registros",
            infoFiltered:   "(filtrado de _MAX_ registros no total)",
            infoPostFix:    "",
            loadingRecords: "Carregando...",
            zeroRecords:    "Não foram encontrados resultados",
            emptyTable:     "Não há dados disponíveis na tabela",
            paginate: {
                first:      "«« Primeiro",
                previous:   "« Anterior",
                next:       "Seguinte »",
                last:       "Último »»"
            }
        }
    });

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
});