<div id="messages-task">
  @if (Session::get('return'))
  <div class="alert alert-{!! Session::get('return')['class'] !!} alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4>    <i class="icon fa fa-{!! Session::get('return')['faicon'] !!}"></i> {!! Session::get('return')['status'] !!}!</h4>
    {!! Session::get('return')['message'] !!}
  </div>
  @endif
</div>
<h1>{!! utf8_encode(strftime('%d de %B de %Y', strtotime($data['workday']->workday))) !!} </h1>
<table id="task-table" class="table table-responsive table-hover table-border table-striped table-bordered">
  <thead>
    <tr>
      <th>{!! Lang::get('timesheets.title-project') !!}</th>
      <th>{!! Lang::get('timesheets.title-task') !!}</th>
      <th>{!! Lang::get('timesheets.title-start') !!}</th>
      <th>{!! Lang::get('timesheets.title-end') !!}</th>
      <th>{!! Lang::get('general.total') !!}</th>
      <th>{!! Lang::get('general.edit') !!}<a id="add-task-row" class="btn btn-warning pull-right">{!! Lang::get('timesheets.add-row') !!}</a></th>
    </tr>
  </thead>
  <tbody>
    @if ($data['tasks'])
    @foreach ($data['tasks'] as $task)
    <tr>
      <td>{!! $task->getProject()->getResults()->name !!}</td>
      <td>{!! $task->getTask()->getResults()->subject !!}</td>
      <td>{!! $task->start !!}</td>
      <td>{!! $task->end !!}</td>
      <td>{!! $task->hours !!}</td>
      <td>
        <a data-id="{!! $task->id !!}" class="btn btn-primary pull-right edit-task-row">{!! Lang::get('general.edit') !!}</a>
        <a data-id="{!! $task->id !!}" class="btn btn-success pull-right save-task-row hide">{!! Lang::get('general.save') !!}</a>
      </td>
    </tr>
    @endforeach
  </tbody>
    @endif
</table>
<input type="hidden" id="workday_id" value="{!! $data['workday_id'] !!}">
<script>
  $('#add-task-row').click(function() {
    $(this).hide();
    $('.edit-task-row').hide();

    var project = $('<td>');
    var task = $('<td>');
    var start = $('<td>');
    var end = $('<td>');
    var edit = $('<td>');

    project_s =  '<select id="project_new" name="projects" class="form-control projects" data-validation="required" required>';
    project_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    @foreach ($data['projects'] as $project)
    project_s += '<option value="{!! $project->id !!}">{!! $project->name !!}</option>';
    @endforeach
    project_s += '</select>';

    task_s =  '<select id="task_new" name="tasks" class="form-control tasks" data-validation="required" required>';
    task_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    task_s += '</select>';

    project.html(project_s);
    task.html(task_s);
    start.html('<input class="form-control time" type="text" id="start_new" value="08:00"/>');
    end.html('<input class="form-control time" type="text" id="end_new" value="17:00"/>');
    edit.html('<a data-id="new" class="btn btn-success pull-right save-task-row">' + "{!! Lang::get('general.save') !!}" + '</a>');

    var row = $('<tr>');

    project.find('select').select2()
    task.find('select').select2();

    row.append(project);
    row.append(task);
    row.append(start);
    row.append(end);
    row.append($('<td>'));
    row.append(edit);

    row.find('.time').inputmask({
      mask: '99:99:99'
    });

    $('#task-table').append(row);
  });

  $('.edit-task-row').click(function() {
    var par = $(this).parent().parent();
    var project = par.children("td:nth-child(1)");
    var task = par.children("td:nth-child(2)");
    var start = par.children("td:nth-child(3)");
    var end = par.children("td:nth-child(4)");

    var task_id = $(this).data('id');

    var id = 0;

    var task_name = task.html();

    project_s =  '<select id="project_' + $(this).data('id') + '" name="projects" class="form-control projects" data-validation="required" required>';
    project_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    @foreach ($data['projects'] as $project)
    var select = '';
    if (project.html() == "{!! $project->name !!}") {
      select = 'selected="selected"'; 
      id = "{!! $project->id !!}";
    }

    project_s += '<option value="{!! $project->id !!}"' + select + '>{!! $project->name !!}</option>';
    @endforeach
    project_s += '</select>';

    task_s =  '<select id="task_' + $(this).data('id') + '" name="tasks" class="form-control tasks" data-validation="required" required>';
    task_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    task_s += '</select>';

    project.html(project_s);
    task.html(task_s);
    start.html('<input class="form-control time" type="text" id="start_' + $(this).data('id') + '" value="' + start.html() + '" data-mask="99:99:99"/>');
    end.html('<input class="form-control time" type="text" id="end_' + $(this).data('id') + '" value="' + end.html() + '" data-mask="99:99:99"/>');


    project.find('select').select2();
    
    if ($('.projects').val() != '') {
      getCycle(id, task_name);
    }

    setTimeout(function(){
      var type = $('.tasks').select2().find(":selected").data('type');

      if (type !== undefined) {
        if (type == 3) {
          var data = {id: task_id};
          console.log(data);
          $.ajax({
            url: '/general/getUseCase',
            data: data,
            type: "GET",
            success: function(data) {
              stats = "";
              stats += '<div id="tasks-quantity">';
              stats += '  <div id="messages">';
              stats += '  </div>';
              stats += '  <!-- The form -->';
              stats += '  <div class="form-group col-xs-2">';
              stats += '    <label for="name">{!! Lang::get('timesheets.ok') !!}</label>';
              stats += '    <input type="number" class="form-control" name="ok" id="ok" value="' + data.ok + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-ok') !!}" required>';
              stats += '  </div>';
              stats += '  <div class="form-group col-xs-2">';
              stats += '    <label for="name">{!! Lang::get('timesheets.nok') !!}</label>';
              stats += '    <input type="number" class="form-control" name="nok" id="nok" value="' + data.nok + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\\[1-9]{2}\\" data-validation-error-msg="{!! Lang::get('timesheets.error-nok') !!}" required>';
              stats += '  </div>';
              stats += '  <div class="form-group col-xs-2">';
              stats += '    <label for="name">{!! Lang::get('timesheets.impacted') !!}</label>';
              stats += '    <input type="number" class="form-control" name="impacted" id="impacted" value="' + data.impacted + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-impacted') !!}" required>';
              stats += '  </div>';
              stats += '  <div class="form-group col-xs-2">';
              stats += '    <label for="name">{!! Lang::get('timesheets.cancelled') !!}</label>';
              stats += '    <input type="number" class="form-control" name="cancelled" id="cancelled" value="' + data.cancelled + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-cancelled') !!}" required>';
              stats += '  </div>';
              stats += '</div>';

              new_line = $('<tr>');
              new_field = $('<td>');
              par.after(new_line.html(new_field.html(stats).attr('colspan', 6)));
            }
          });
        }
      }
    }, 2000);

    task.find('select').select2();
    $('.time').inputmask({
      mask: '99:99:99'
    });

    $(this).hide();
    $(this).parent().find('.save-task-row').removeClass('hide');
  });

  $('table').on('click', '.save-task-row', function() {
    var start = $('#start_' + $(this).data('id')).val().split(':');
    var end = $('#end_' + $(this).data('id')).val().split(':');

    start = (parseInt(start[0]) * 60) + parseInt(start[1]);
    end = (parseInt(end[0]) * 60) + parseInt(end[1]);

    if (start > end) {
      var html = '';

      html += '<div class="alert alert-danger alert-dismissable">';
      html += '  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      html += '  <h4>    <i class="icon fa fa-error"></i> ' + "{!! Lang::get('general.failed') !!}" + '!</h4>';
      html += "A hora do fim não pode ser maior que a hora de inicio";
      html += '</div>';

      $('#messages-task').html(html);
    } else {
      var data = {
        user_id: $('#user_id').val(),
        id:  $(this).data('id'),
        workday_id:  $('#workday_id').val(),
        project_id: $('#project_' + $(this).data('id')).val(),
        task_id: $('#task_' + $(this).data('id')).val(),
        start: $('#start_' + $(this).data('id')).val(),
        end: $('#end_' + $(this).data('id')).val(),
      }

      console.log(data);

      $.ajax({
        url: '/general/changeTaskDay',
        data: data,
        type: "GET",
        success: function(data) {
          if (data == 'true') {
            location.reload();
          } else {
            var html = '';

            html += '<div class="alert alert-danger alert-dismissable">';
            html += '  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            html += '  <h4><i class="icon fa fa-error"></i> ' + "{!! Lang::get('general.failed') !!}" + '!</h4>';
            html += "{!! Lang::get('general.error') !!}";
            html += '</div>';

            $('#messages-task').append(html);
          }
        }
      });
    }
  });
  var _tasks = {};

 $('table').on('change', '.projects', function() {
    console.log ($('.projects').val())
    if ($('.projects').val() != '')
      getCycle($(this).val())
    else {
      $('.tasks').prop( "disabled", true ).val($("#target option:first").val());
      $('.tasks').find('optgroup').remove();
      $('.tasks').find('option[value!=""]').remove();
    }
  });

  $('table').on('change', '.tasks', function() {
    var id = $(this).val();
    var type = $(this).select2().find(":selected").data('type');

    if (type !== undefined) {
      if (type == 3) {
        stats = "";
        stats += '<div id="tasks-quantity">';
        stats += '  <div id="messages">';
        stats += '  </div>';
        stats += '  <!-- The form -->';
        stats += '  <div class="form-group col-xs-2">';
        stats += '    <label for="name">{!! Lang::get('timesheets.ok') !!}</label>';
        stats += '    <input type="number" class="form-control" name="ok" id="ok" value="' + data.ok + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-ok') !!}" required>';
        stats += '  </div>';
        stats += '  <div class="form-group col-xs-2">';
        stats += '    <label for="name">{!! Lang::get('timesheets.nok') !!}</label>';
        stats += '    <input type="number" class="form-control" name="nok" id="nok" value="' + data.nok + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\\[1-9]{2}\\" data-validation-error-msg="{!! Lang::get('timesheets.error-nok') !!}" required>';
        stats += '  </div>';
        stats += '  <div class="form-group col-xs-2">';
        stats += '    <label for="name">{!! Lang::get('timesheets.impacted') !!}</label>';
        stats += '    <input type="number" class="form-control" name="impacted" id="impacted" value="' + data.impacted + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-impacted') !!}" required>';
        stats += '  </div>';
        stats += '  <div class="form-group col-xs-2">';
        stats += '    <label for="name">{!! Lang::get('timesheets.cancelled') !!}</label>';
        stats += '    <input type="number" class="form-control" name="cancelled" id="cancelled" value="' + data.cancelled + '" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-cancelled') !!}" required>';
        stats += '  </div>';
        stats += '</div>';

        new_line = $('<tr>');
        new_field = $('<td>');
        $(this).parent().parent().after(new_line.html(new_field.html(stats).attr('colspan', 6)));
      }
    }
  });

  function getCycle(id, select) {
    $.ajax({
      url: '/general/getTasks',
      data: {id: id, select: select},
      type: "GET",
      success: function(data) {
        var html = data

        _html = html;

        console.log(html != null && html != '');

        if (html != null && html != '') {
          $('.tasks').prop( "disabled", false );
          $('.tasks').find('option[value!=""]').remove();
          $('.tasks').find('optgroup').remove();
          var options = [];
          $('.tasks').append(html).select2({
            templateResult: getIcon
          });
        } else {
          $('.tasks').prop( "disabled", true ).val($(".tasks option:first").val());
          $('.tasks').find('option[value!=""]').remove();
        }
      }
    });
    return $.Deferred().resolve();
  }

  function getIcon (task) {
    if (!task.id) { return task.text; }
    var $task = $(
      '<span><span class="fa ' + ($(task.element).data('type') == 1 ? 'fa-file' : 'fa-exclamation-triangle ') + '"></span> ' + task.text + '</span>'
    );
    return $task;
  };
</script>