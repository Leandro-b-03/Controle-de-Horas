@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.timesheets')]) !!}
@stop

@section('style')
@stop

@section('content')
        <h1>
            {!! Lang::get('general.timesheets') !!}
            <small>{!! Lang::get('timesheets.list') !!}</small>
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div id="messages">
        @if (Session::get('return'))
        <div class="alert alert-{!! Session::get('return')['class'] !!} alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4>    <i class="icon fa fa-{!! Session::get('return')['faicon'] !!}"></i> {!! Session::get('return')['status'] !!}!</h4>
          {!! Session::get('return')['message'] !!}
        </div>
        @endif
      </div>
      <div class="box box-solid box-primary">
        <div class="box-header with-border">
            <i class="fa fa-tasks"></i>
            <h3 class="box-title">Tarefa atual</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="start_settings" class="col-xs-6 {!! !isset($data['timesheet_task']) ? '' : 'invisible' !!}">
                <div class="form-group col-xs-2 custom_a">
                    <a id="start" class="btn btn-success play"><span class="fa fa-play-circle-o"></span> {!! Lang::get('timesheets.start') !!}</a>
                    @if ($data['workday']->lunch_start == '00:00:00')
                    <a id="lunch" class="btn btn-primary play"><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.lunch_start') !!}</a>
                    @endif
                    @if ($data['workday']->lunch_start != '00:00:00' && $data['workday']->lunch_end == '00:00:00')
                    <a id="back" class="btn btn-primary play"><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.lunch_end') !!}</a>
                    @endif
                </div>
                <div class="form-group col-xs-8">
                    <label for="projects">{!! Lang::get('general.projects') !!}</label>
                    <select id="projects" name="projects" class="form-control" data-validation="required" required>
                        <option value="">{!! Lang::get('general.select') !!}</option>
                        @foreach ($data['projects'] as $project)
                        <option value="{!! $project->id !!}">{!! $project->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-8">
                    <label for="tasks">{!! Lang::get('general.tasks') !!}</label>
                    <select id="tasks" name="tasks" class="form-control" data-validation="required" required disabled="disabled">
                        <option value="">{!! Lang::get('general.select') !!}</option>
                    </select>
                </div>
            </div>
            <div id="finish_settings" class="col-xs-6 {!! isset($data['timesheet_task']) ? '' : 'invisible' !!}">
                <div class="form-group col-xs-2 custom_a">
                    <a id="fail" class="btn btn-danger play"><span class="fa fa-ban"></span> {!! Lang::get('timesheets.fail') !!}</a>
                    <a id="pause" class="btn btn-warning play"><span class="fa fa-pause-circle-o"></span> {!! Lang::get('timesheets.pause') !!}</a>
                    <a id="finish" class="btn btn-success play"><span class="fa fa-stop-circle-o"></span> {!! Lang::get('timesheets.finish') !!}</a>
                </div>
                <div class="form-group col-xs-8">
                    <label for="projects">{!! Lang::get('general.projects') !!}</label>
                    <p id="project-name">{!! isset($data['timesheet_task']) ? $data['timesheet_task']->getProject()->getResults()->name : "" !!}</p>
                </div>
                <div class="form-group col-xs-8">
                    <label for="tasks">{!! Lang::get('general.tasks') !!}</label>
                    <p id="task-subject">{!! isset($data['timesheet_task']) ? $data['timesheet_task']->getTask()->getResults()->subject : "" !!}</p>
                </div>
            </div>
            <div class="col-xs-6">
              <div class="callout callout-success custom-callout">
                <h4>{!! Lang::get('general.info') !!}</h4>
                <p id="task-info">{!! isset($data['timesheet_task']) ? $data['timesheet_task']->getTask()->getResults()->description : Lang::get('timesheets.no-task') !!}</p>
              </div>
            </div>
        </div>
      <!-- /.box-body -->
      </div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{!! Lang::get('general.timesheets') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <p id="lunch_time">{!! ($data['workday']->lunch_start != '00:00:00') ? Lang::get('timesheet.lunch-time') : Lang::get('timesheet.lunch') !!}</p>
        <table id="tasks-table" class="table table-border">
            <thead>
                <tr>
                    <th>{!! Lang::get('timesheets.title-project') !!}</th>
                    <th>{!! Lang::get('timesheets.title-task') !!}</th>
                    <th>{!! Lang::get('timesheets.title-start') !!}</th>
                    <th>{!! Lang::get('timesheets.title-end') !!}</th>
                    <th>{!! Lang::get('general.total') !!}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['tasks'])
                @foreach ($data['tasks'] as $task)
                <tr>
                    <td>{!! $task->getProject()->getResults()->name !!}</td>
                    <td>{!! $task->getTask()->getResults()->subject !!}</td>
                    <td>{!! date('G:i a', strtotime($task->start)) !!}</td>
                    <td>{!! ($task->end == null) ? '---' : date('G:i a', strtotime($task->end)) !!}</td>
                    <td>{!! ($task->hours == null) ? '---' : date('G:i', strtotime($task->hours)) !!}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div><!-- /.box-body -->
    <div class="box-footer">
      Footer
  </div><!-- /.box-footer-->
</div><!-- /.box -->

@endsection

@section('scripts')
    <!-- SlimScroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- FastClick -->
    {!! Html::script("library/adminLTE/plugins/fastclick/fastclick.min.js") !!}
    <!-- Stopwacth -->
    {!! Html::script("library/adminLTE/plugins/jquery-stopwatch/jquery.stopwatch.js") !!}

    <script type="text/javascript" charset="utf-8" async defer>
        // var timesheet = {!! (isset($data['timesheet_today']) ? 'JSON.parse(\'' . $data['timesheet_today'] . '\')' : '{}') !!};

        $('#timer').stopwatch().stopwatch('start');

        $('#start').click(function() {
          var data = {};

          data.start = true;
          data.project_id = $('#projects').val();
          data.task_id = $('#tasks').val();

          $.ajax({
            url: '/timesheets',
            data: data,
            type: "POST",
            success: function(data) {
              var task = JSON.parse(data);
              $('#start_settings').addClass('invisible');
              $('#finish_settings').removeClass('invisible');

              $('#project-name').html($('#projects option:selected').text());
              $('#task-subject').html($('#tasks option:selected').text());
              
              var line = generateLine(task);

              $('#tasks-table tbody').prepend($(line));
            }
          });
        });

        $('#lunch').click(function() {
          var data = {};

          data.lunch = true;
          data.start_lunch = true;

          lunch(data);
        });

        $('#back').click(function() {
          var data = {};

          data.lunch = true;
          data.start_lunch = false;

          lunch(data);
        });

        $('#pause').click(function() {
          var data = {};

          data.pause = true;

          endTask(data);
        });

        $('#fail').click(function() {
          var data = {};

          data.fail = true;

          endTask(data);
        });

        $('#finish').click(function() {
          var data = {};

          data.finish = true;

          endTask(data);
        });

        function lunch(data) {
          var redirect = data.start_lunch;
          console.log(redirect);
          $.ajax({
            url: '/timesheets',
            data: data,
            type: "POST",
            success: function(data) {
              var lunch = JSON.parse(data);
              
              $('#lunch_time').html('Horario de saida: ' + lunch.lunch_start + '. Horario da volta: ' + lunch.lunch_end + '. Tempo total: ' + lunch.lunch_hours + '.');

              $('#back').hide();
            }
          });

          if (redirect) {
              window.location = "http://timesheet.localhost.com/lock";
          }
        }

        function endTask(data) {
          $.ajax({
            url: '/timesheets',
            data: data,
            type: "POST",
            success: function(data) {
              var task = JSON.parse(data);
              $('#start_settings').removeClass('invisible');
              $('#finish_settings').addClass('invisible');

              $('#projects').select2();
              $('#tasks').select2({
                templateResult: getIcon
              });

              var line = generateLine(task);

              $('#tasks-table tbody tr:first').remove();

              $('#tasks-table tbody').prepend($(line));
            }
          });
        }

        function generateLine(task) {
          var html = '';

          html += '<tr>';
          html +=   '<td>';
          html +=     task.project;
          html +=   '</td>';
          html +=   '<td>';
          html +=     task.task;
          html +=   '</td>';
          html +=   '<td>';
          html +=     task.start;
          html +=   '</td>';
          html +=   '<td>';
          html +=     (task.end == null ? '---' : task.end) ;
          html +=   '</td>';
          html +=   '<td>';
          html +=     (task.hours == null ? '---' : task.hours) ;
          html +=   '</td>';

          return html;
        }

        var _tasks = {};

        $('#projects').on('change', function() {
            getCycle($(this).val())
        });

        $('#tasks').on('change', function() {
            var id = $(this).val();
            var found = 0;

            $.each(_tasks, function(i, task) {
              if (task.id == id) {
                if (task.description != null || task.description != "") 
                  $('#task-info').html(task.description);
                else
                  $('#task-info').html('Tarefa sem descrição');

                found++;
                return;
              } else {
                if (!found) {
                  $('#task-info').html('Selecione uma tarefa');
                  return;
                }
              }
          });
        });

        function getCycle(id) {
          $.ajax({
            url: '/general/getTasks',
            data: {id: id},
            type: "GET",
            success: function(data) {
              var tasks = JSON.parse(data);

              _tasks = tasks;

              if (tasks.length > 0) {
                $('#tasks').prop( "disabled", false );
                $('#tasks').find('option[value!=""]').remove();

                var options = [];

                $.each(tasks, function(i, task) {
                  options.push('<option value="' + task.id + '" data-type="' + task.type_id + '">' + task.subject + '</select>');
                  return;
                });


                $('#tasks').append(options).select2({
                  templateResult: getIcon
                });
              } else {
                $('#tasks').prop( "disabled", true ).val($("#target option:first").val());
                $('#tasks').find('option[value!=""]').remove();
              }
            }
          });
        }

        function getIcon (task) {
          if (!task.id) { return task.text; }
          var $task = $(
            '<span><span class="fa ' + ($(task.element).data('type') == 1 ? 'fa-file' : 'fa-exclamation-triangle ') + '"></span> ' + task.text + '</span>'
          );
          return $task;
        };
    </script>
@endsection
