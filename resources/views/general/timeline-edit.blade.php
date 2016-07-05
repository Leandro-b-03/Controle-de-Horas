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
        <a data-id="{!! $data['workday']->id !!}" class="btn btn-primary pull-right edit-task-row">{!! Lang::get('general.edit') !!}</a>
        <a data-id="{!! $data['workday']->id !!}" class="btn btn-success pull-right save-task-row hide">{!! Lang::get('general.save') !!}</a>
      </td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>
<script>
  $('#add-task-row').click(function() {
    $(this).hide();
    $('.edit-task-row').hide();

    var project = $('<td>');
    var task = $('<td>');
    var start = $('<td>');
    var end = $('<td>');
    var edit = $('<td>');

    project_s =  '<select id="project_' + $(this).attr('id') + '" name="projects" class="form-control projects" data-validation="required" required>';
    project_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    @foreach ($data['projects'] as $project)
    project_s += '<option value="{!! $project->id !!}">{!! $project->name !!}</option>';
    @endforeach
    project_s += '</select>';

    task_s =  '<select id="task_' + $(this).attr('id') + '" name="tasks" class="form-control tasks" data-validation="required" required>';
    task_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    task_s += '</select>';

    project.html(project_s);
    task.html(task_s);
    start.html('<input class="form-control time" type="text" id="start_new" value="08:00"/>');
    end.html('<input class="form-control time" type="text" id="end_new" value="17:00"/>');
    edit.html('<a id="new" class="btn btn-success pull-right save-task-row">' + "{!! Lang::get('general.save') !!}" + '</a>');

    var row = $('<tr>');

    project.find('select').select2()
    task.find('select').select2();

    row.append(project);
    row.append(task);
    row.append(start);
    row.append(end);
    row.append($('<td>'));
    row.append(edit);

    row.find('.time').wickedpicker({twentyFour: true});

    $('#task-table').append(row);
  });

  $('.edit-task-row').click(function() {
    var par = $(this).parent().parent();
    var project = par.children("td:nth-child(1)");
    var task = par.children("td:nth-child(2)");
    var start = par.children("td:nth-child(3)");
    var end = par.children("td:nth-child(4)");

    var id = 0;

    var task_name = task.html();

    project_s =  '<select id="project_' + $(this).attr('id') + '" name="projects" class="form-control projects" data-validation="required" required>';
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

    task_s =  '<select id="task_' + $(this).attr('id') + '" name="tasks" class="form-control tasks" data-validation="required" required>';
    task_s += '<option value="">' + '{!! Lang::get('general.select') !!}' + '</option>';
    task_s += '</select>';

    project.html(project_s);
    task.html(task_s);
    start.html('<input class="form-control time" type="text" id="start_' + $(this).data('id') + '" value="' + start.html() + '"/>');
    end.html('<input class="form-control time" type="text" id="end_' + $(this).data('id') + '" value="' + end.html() + '"/>');


    project.find('select').select2();
    
    if ($('.projects').val() != '') {
      getCycle(id, task_name);
    }

    task.find('select').select2();
    $('.time').wickedpicker({twentyFour: true});

    $(this).hide();
    $(this).parent().find('.save-task-row').removeClass('hide');
  });

  $('table').on('click', '.save-task-row', function() {
    var data = {
      user_id: $('#user_id').val(),
      id:  $(this).data('id'),
      project: $('#project_' + $(this).data('id')).val(),
      task: $('#task_' + $(this).data('id')).val(),
      start: $('#start_' + $(this).data('id')).val(),
      end: $('#end_' + $(this).data('id')).val(),
    }

    $(this).hide();

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
          html += '  <h4>    <i class="icon fa fa-error"></i> ' + "{!! Lang::get('general.failed') !!}" + '!</h4>';
          html += "{!! Lang::get('general.error') !!}";
          html += '</div>';

          $('#message').append(html);
        }
      }
    });
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