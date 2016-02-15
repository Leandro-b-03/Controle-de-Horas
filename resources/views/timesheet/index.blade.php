@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.timesheets')]) !!}
@stop

@section('style')
    <!-- jQuery-Form-Validator -->
    {!! Html::style("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/theme-default.min.css") !!}
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
            @if ($data['workday']->end == '00:00:00' || ($data['workday']->nightly_start != '00:00:00' && $data['workday']->nightly_end == '00:00:00'))
            <div id="start_settings" class="col-xs-6 {!! !isset($data['timesheet_task']) ? '' : 'invisible' !!}">
                <div class="form-group col-xs-2 custom_a">
                    <a id="start" class="btn btn-success play"><span class="fa fa-play-circle-o"></span> {!! Lang::get('timesheets.start') !!}</a>
                    @if ($data['workday']->lunch_start == '00:00:00')
                    <a id="lunch" class="btn btn-primary play"><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.lunch_start') !!}</a>
                    @endif
                    @if ($data['workday']->lunch_start != '00:00:00' && $data['workday']->lunch_end == '00:00:00')
                    <a id="back" class="btn btn-primary play"><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.lunch_end') !!}</a>
                    @endif
                    <a id="end" class="btn btn-warning play"><span class="fa fa-stop-circle-o"></span> {!! Lang::get('timesheets.' .  ($data['workday']->nightly_start != '00:00:00:' ? 'end' : 'nightly_end')) !!}</a>
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
                <div id="task-menu" class="form-group col-xs-2 custom_a {!! isset($data['timesheet_task']) ? ($data['timesheet_task']->getProject()->getResults()->type_id == 1 ? '' : 'invisible' ) : 'invisible' !!}">
                    <a id="fail" class="btn btn-danger play"><span class="fa fa-ban"></span> {!! Lang::get('timesheets.fail') !!}</a>
                    <a id="pause" class="btn btn-warning play"><span class="fa fa-pause-circle-o"></span> {!! Lang::get('timesheets.pause') !!}</a>
                    <a id="finish" class="btn btn-success play"><span class="fa fa-stop-circle-o"></span> {!! Lang::get('timesheets.finish') !!}</a>
                </div>
                <div id="front-menu" class="form-group col-xs-2 custom_a {!! isset($data['timesheet_task']) ? ($data['timesheet_task']->getProject()->getResults()->type_id != 1 ? '' : 'invisible' ) : 'invisible' !!}">
                    <a id="finish-modal" class="btn btn-success play" data-toggle="modal" data-target="#finished"><span class="fa fa-stop-circle-o"></span> {!! Lang::get('timesheets.finish') !!}</a>
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
            @else
            <div class="col-xs-6">
              <div class="callout callout-success">
                <h4>{!! Lang::get('general.info') !!}</h4>
                <div class="col-xs-6">
                  <p>
                    <label>{!! Lang::get('timesheets.started') . ':' !!} </label> {!! $data['workday']->start !!}
                    <br />
                    <label>{!! Lang::get('timesheets.lunch_started') . ':' !!} </label> {!! $data['workday']->lunch_start !!}
                    <br />
                    <label>{!! Lang::get('timesheets.lunch_ended') . ':' !!} </label> {!! $data['workday']->lunch_end !!}
                    <br />
                    <label>{!! Lang::get('timesheets.lunch_total') . ':' !!} </label> {!! $data['workday']->lunch_hours !!}
                    <br />
                    <label>{!! Lang::get('timesheets.ended') . ':' !!} </label> {!! $data['workday']->end !!}
                    <br />
                    <label>{!! Lang::get('timesheets.total_day') . ':' !!} </label> {!! $data['workday']->hours !!}
                  </p>
                </div>
                <div class="col-xs-6">
                  <p>
                    <label>{!! Lang::get('timesheets.hours_to_achieve') . ':' !!} </label> {!! $data['info']['hours_day'] !!}
                    <br />
                    <label>{!! Lang::get('timesheets.hours_credit') . ':' !!} </label> {!! $data['info']['time_credit'] !!}
                    <br />
                    <label>{!! Lang::get('timesheets.hours_debit') . ':' !!} </label> {!! $data['info']['time_debit'] !!}
                  </p>
                </div>
                <hr class="clearfix" />
              </div>
            </div>
            @if (Auth::user()->can('TimesheetController@overttime-special'))
            <div class="col-xs-6">
              <h4>Você tem permissão para fazer hora-extra</h4>
              <p>Seu gestor aprovou ou aprovará suas horas extrar, para iniciar clique no botão abaixo</p>
              <a id="nightly" class="btn btn-success">{!! Lang::get('timesheets.start') !!}</a>
            </div>
            @endif
            @endif
        </div>
      <!-- /.box-body -->
      </div>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{!! Lang::get('general.timesheets') !!}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <p id="lunch_time" class="pull-left">{!! ($data['workday']->lunch_start != '00:00:00') 
          ? Lang::get('timesheets.lunch-time', ['start' => $data['workday']->lunch_start, 'end' => $data['workday']->lunch_end, 'hours' => $data['workday']->lunch_hours])
          : Lang::get('timesheets.lunch') !!}</p>s
        <table id="tasks-table" class="table table-responsive table-hover table-border table-striped table-bordered">
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
                    <td>{!! ($task->end == null || $task->end == '00:00:00') ? '---' : date('G:i a', strtotime($task->end)) !!}</td>
                    <td>{!! ($task->hours == null) ? '---' : date('G:i', strtotime($task->hours)) !!}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div><!-- /.box-body -->
    <div class="box-footer">
      <a class="btn btn-default pull-left"  href="{!! URL::to('timesheets/' . Auth::user()->id . '/') !!}">{!! Lang::get('timesheets.monthly') !!}</a>
      {!! $data['tasks']->render() !!}
  </div><!-- /.box-footer-->
  <!-- Modal -->
  <div class="modal fade" id="finished" tabindex="-1" role="dialog" aria-labelledby="{!! Lang::get('general.tasks') !!}">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="{!! Lang::get('general.back') !!}"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="{!! Lang::get('general.tasks') !!}">{!! Lang::get('timesheets.task') !!}</h4>
        </div>
        <div class="modal-body fixed">
          <div id="tasks-quantity">
            <div id="messages">
            </div>
            <!-- The form -->
            <div class="form-group col-xs-2">
              <label for="name">{!! Lang::get('timesheets.ok') !!}</label>
              <input type="number" class="form-control" name="ok" id="ok"  value="0" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-ok') !!}" required>
            </div>
            <div class="form-group col-xs-2">
              <label for="name">{!! Lang::get('timesheets.nok') !!}</label>
              <input type="number" class="form-control" name="nok" id="nok"  value="0" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-nok') !!}" required>
            </div>
            <div class="form-group col-xs-2">
              <label for="name">{!! Lang::get('timesheets.impacted') !!}</label>
              <input type="number" class="form-control" name="impacted" id="impacted"  value="0" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-impacted') !!}" required>
            </div>
            <div class="form-group col-xs-2">
              <label for="name">{!! Lang::get('timesheets.cancelled') !!}</label>
              <input type="number" class="form-control" name="cancelled" id="cancelled"  value="0" data-mask="999" data-validation="length" data-validation-length="1-40" data-validation-regexp="^\[1-9]{2}\" data-validation-error-msg="{!! Lang::get('timesheets.error-cancelled') !!}" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.back') !!}</button>
          <a id="finish" class="btn btn-success"><span class="fa fa-stop-circle-o"></span> {!! Lang::get('timesheets.finish') !!}</a>
        </div>
      </div>
    </div>
  </div>
</div><!-- /.box -->
@endsection

@section('scripts')
    <!-- SlimScroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- FastClick -->
    {!! Html::script("library/adminLTE/plugins/fastclick/fastclick.min.js") !!}
    <!-- Stopwacth -->
    {!! Html::script("library/adminLTE/plugins/jquery-stopwatch/jquery.stopwatch.js") !!}
    <!-- jQuery-Form-Validator -->
    {!! Html::script("library/adminLTE/plugins/jQuery-Form-Validator/form-validator/jquery.form-validator.min.js") !!}

    <script type="text/javascript" charset="utf-8" async defer>
        var workday = {!! $data['workday'] !!};
        
        $.validate();

        $('form').submit(function(e) {
          if ($(this).find('.has-error').length > 0) {
            e.preventDefault();
            var data = {class:'danger', faicon:'ban', status:"{!! Lang::get('general.failed') !!}", message:"{!! html_entity_decode(Lang::get('general.failed-fields')) !!}"};
              $('#messages').html(throwMessage(data));
          } else {
            return;
          }
        });

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
              var task = data
              
              if (!task.error) {
                $('#start_settings').addClass('invisible');
                $('#finish_settings').removeClass('invisible');

                $('#project-name').html($('#projects option:selected').text());
                $('#task-subject').html($('#tasks option:selected').text());

                if (data.type_id == 1) 
                  $('#task-menu').removeClass('invisible');
                else
                  $('#front-menu').removeClass('invisible');
                
                var line = generateLine(task);

                $('#tasks-table tbody').prepend($(line));
              } else {
                data = { class: 'danger', faicon: 'ban', status: "{!! Lang::get('general.failed') !!}", message: data.error };
                throwMessage(data);
              }
            }
          });
        });

        $('#end').click(function() {
          var data = {};

          if (workday.nightly_start == "00:00:00")
            data.end = true;
          else {
            data.nightly = true;
            data.nightly_end = true
          }

          $.ajax({
            url: '/timesheets',
            data: data,
            type: "POST",
            success: function(data) {
                var task = data;

              if (!task.error) {
                window.location.href = '/timesheets';
              } else {
                data = { class: 'danger', faicon: 'ban', status: "{!! Lang::get('general.failed') !!}", message: data.error };
                throwMessage(data);
              }
            }
          });
        });

        $('#nightly').click(function() {
          var data = {};

          data.nightly = true;
          data.nightly_start = true;

          $.ajax({
            url: '/timesheets',
            data: data,
            type: "POST",
            success: function(data) {
                var task = data;

              if (!task.error) {
                window.location.href = '/timesheets';
              } else {
                data = { class: 'danger', faicon: 'ban', status: "{!! Lang::get('general.failed') !!}", message: data.error };
                throwMessage(data);
              }
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

        $(document).on("click", "#finish", function(event) {
          var data = {};

          data.finish = true;
          data.ok = $('#ok').val();
          data.nok = $('#nok').val();
          data.impacted = $('#impacted').val();
          data.cancelled = $('#cancelled').val();

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
              var lunch = data;

              if (!lunch.error) {
                $('#lunch_time').html('Horário de saida: ' + lunch.lunch_start + '. Horario da volta: ' + lunch.lunch_end + '. Tempo total: ' + lunch.lunch_hours + '.');

                $('#back').hide();
              } else {
                data = { class: 'danger', faicon: 'ban', status: "{!! Lang::get('general.failed') !!}", message: data.error };
                throwMessage(data);
              }
            }
          });

          if (redirect) {
              window.location = "http://timesheet.localhost.com/lock";
          }
        }

        function endTask (data) {
          $.ajax({
            url: '/timesheets',
            data: data,
            type: "POST",
            success: function(data) {
              var task = data;

              if (!task.error) {
                $('#finished').modal('hide');

                $('#start_settings').removeClass('invisible');
                $('#finish_settings').addClass('invisible');

                $('#projects').select2();
                $('#tasks').select2({
                  templateResult: getIcon
                });
                
                $('#task-menu').addClass('invisible');
                $('#front-menu').addClass('invisible');

                $('#ok').val(0);
                $('#nok').val(0);
                $('#impacted').val(0);
                $('#cancelled').val(0);

                var line = generateLine(task);

                $('#tasks-table tbody tr:first').remove();

                $('#tasks-table tbody').prepend($(line));
              } else {
                data = { class: 'danger', faicon: 'ban', status: "{!! Lang::get('general.failed') !!}", message: data.error };
                throwMessage(data);
              }
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
          html +=     (task.end == null || task.end == '00:00:00' ? '---' : task.end) ;
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

        if ($('#projects').val() != '') {
          getCycle($('#projects').val());
        }

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
              var tasks = data

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

        function throwMessage(data) {
            html = '<div class="alert alert-' + data.class + ' alert-dismissable">';
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            html += '<h4>    <i class="icon fa fa-' + data.faicon + '"></i> ' + data.status + '</h4>';
            html += data.message;
            html += '</div>';

            return html;
        };
    </script>
@endsection
