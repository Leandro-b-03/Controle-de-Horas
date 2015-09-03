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
        <hr class="clearfix" />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="day">{!! Lang::get('timesheets.title-day') !!}</th>
                    <th class="month">{!! $data['today']->format('F') !!}</th>
                    <th class="start">{!! Lang::get('timesheets.title-start') !!}</th>
                    <th class="end">{!! Lang::get('timesheets.title-lunch') !!}</th>
                    <th class="end">{!! Lang::get('timesheets.title-end') !!}</th>
                    <th class="task">{!! Lang::get('timesheets.title-task') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['week'] as $day)
                <tr class="{!! ($day['day']->dayOfWeek === 0 || $day['day']->dayOfWeek === 6 ?  'weekend' : '') !!} {!! ($day['day']->isSameDay($data['today']) ? 'today active' : '') !!}">
                    <td>{!! $day['day']->format('d') !!}</td>
                    <td>{!! $day['day']->format('l') !!}</td>
                    <td {!! ($day['day']->isSameDay($data['today']) ? 'id="start_now"' : '') !!}>{!! ($day['workday'] ? '<p>' . $day['workday']->start . '</p>' : ($day['day']->isSameDay($data['today']) ? '<a id="start" class="btn btn-primary" ><span class="fa fa-calendar-plus-o"></span> ' . Lang::get('timesheets.start') . '</a>' : '---')) !!}</td>
                    <td {!! ($day['day']->isSameDay($data['today']) ? 'id="lunch_time"' : '') !!}>{!! $day['lunch'] !!}</td>
                    <td>{!! ($day['workday'] ? '<a id="start" class="btn btn-primary" ><span class="fa fa-clock-o"></span> ' . Lang::get('timesheets.end') . '</a>' : '---') !!}</td>
                    <td>
                        @if ($day['workday'])
                        <select id="" class="" data-validation="required" data-validation-error-msg="{!! Lang::get('proposals.error-clients') !!}" required>
                            <option value="">{!! Lang::get('general.select') !!}</option>
                        </select>
                        <a id="start" class="btn btn-primary"><span class="fa fa-calendar-plus-o"></span> {!! Lang::get('timesheets.start') !!}</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr></tr>
            </tfoot>
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

    <script type="text/javascript" charset="utf-8" async defer>
        var timesheet = {!! (isset($data['timesheet_today']) ? 'JSON.parse(\'' . $data['timesheet_today'] . '\')' : '{}') !!};

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

                    $('#lunch_time').html('<a id="lunch_start" class="btn btn-primary" ><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.start') !!}</a>');

                    timesheet = data;
                }
            });
        });

        $(document).on('click', '#lunch_start', function() {
            $.ajax({
                url: '/timesheets',
                data: 'lunch_start=true&id=' + timesheet.id,
                type: "POST",
                success: function(data) {
                    data = JSON.parse(data);
                    $('#lunch_start').remove();

                    var html = '<a id="lunch_end" class="btn btn-primary" ><span class="fa fa-cutlery"></span> {!! Lang::get('timesheets.end') !!}</a>';
                    $('#lunch_time').append(html);

                    timesheet = data;
                }
            });
        });

        $(document).on('click', '#lunch_end', function() {
            $.ajax({
                url: '/timesheets',
                data: 'lunch_end=true&id=' + timesheet.id,
                type: "POST",
                success: function(data) {
                    data = JSON.parse(data);
                    if (!data.error) {
                        $('#lunch_end').remove();

                        var html = '<p>' + data.start + '</p>';
                        $('#lunch_time').append(html);

                        timesheet = data;
                    } else {
                        new PNotify({
                            type: "error",
                            title: "{!! Lang::get('general.failed') !!}",
                            text: data.message,
                            addclass: "stack-bottomleft"
                        });
                    }
                }
            });
        })
    </script>
@endsection
