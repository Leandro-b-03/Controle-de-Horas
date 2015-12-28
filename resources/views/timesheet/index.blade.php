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
            <div class="col-xs-6">
                <div class="form-group col-xs-2 custom_a">
                    <a class="btn btn-large btn-default play"><span class="fa fa-play-circle-o"></span> Iniciar</a>
                </div>
                <div class="form-group col-xs-8">
                    <label for="projects">{!! Lang::get('general.projects') !!}</label>
                    <select name="projects" class="form-control" data-validation="required" required>
                        <option value="">{!! Lang::get('general.select') !!}</option>
                        @foreach ($data['projects'] as $project)
                        <option value="{!! $project->id !!}">{!! $project->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-xs-8">
                    <label for="tasks">{!! Lang::get('general.tasks') !!}</label>
                    <select name="tasks" class="form-control" data-validation="required" required>
                        <option value="">{!! Lang::get('general.select') !!}</option>
                    </select>
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
        <table class="table">
            <thead>
                <tr>
                    <th>header</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>data</td>
                </tr>
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
        var timesheet = {!! (isset($data['timesheet_today']) ? 'JSON.parse(\'' . $data['timesheet_today'] . '\')' : '{}') !!};

        $('#timer').stopwatch().stopwatch('start');

        $('#start').click(function() {
            $.ajax({
                url: '/timesheets',
                data: 'lunch_start=false&start=true',
                type: "POST",
                success: function(data) {
                    data = JSON.parse(data);
                    $('#start').remove();

                    var html = '<p>' + data.start + '</p>';
                    $('#start_now').append(html);

                    $('#lunch_time').html('<a id="lunch_start" class="btn btn-primary" ><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.lunch_start') !!}</a>');

                    timesheet = data;
                }
            });
        });

        $('#tasks').on('change', function() {
            getCycle($(this).val())
        });

        function getCycle(id) {
          $.ajax({
            url: '/timesheets',
            data: {id: id},
            type: "GET",
            success: function(data) {
              var project_times = JSON.parse(data);

              console.log(project_times);

              if (project_times.length > 0) {
                $('#project_time_id').prop( "disabled", false );
                $('#project_time_id').find('option[value!=""]').remove();

                var options = [];

                $.each(project_times, function(i, project_time) {

                  options.push('<option value="' + project_time.id + '">' + project_time.cycle + '</select>');
                  return;
                });

                $('#project_time_id').append(options);
              } else {
                $('#project_time_id').prop( "disabled", true ).val($("#target option:first").val());
                $('#project_time_id').find('option[value!=""]').remove();
              }
            }
          });
        }
    </script>
@endsection
