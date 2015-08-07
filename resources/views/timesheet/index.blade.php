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
        <div class="pull-right">
            <a href="{!! URL::to('timesheets/create') !!}" class="btn btn-primary">{!! Lang::get('timesheets.new') !!}</a>
            <a id="delete" data-name="Cliente" class="btn btn-danger">{!! Lang::get('timesheets.delete') !!}</a>
        </div>
        <hr class="clearfix" />
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="day">{!! Lang::get('timesheets.title-day') !!}</th>
                    <th class="month">{!! $data['today']->format('F') !!}</th>
                    <th class="start">{!! Lang::get('timesheets.title-start') !!}</th>
                    <th class="task">{!! Lang::get('timesheets.title-task') !!}</th>
                    <th class="end">{!! Lang::get('timesheets.title-end') !!}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['week'] as $day)
                <tr {!! ($day->dayOfWeek === 0 || $day->dayOfWeek === 6 ?  'class="weekend"' : '') !!} {!! ($day->isSameDay($data['today']) ?  'class="today active"' : '') !!}>
                    <td>{!! $day->format('j') !!}</td>
                    <td>{!! $day->format('l') !!}</td>
                    <td {!! ($day->isSameDay($data['today']) ?  'id="start_now"' : '') !!}>{!! ($data['timesheet_today'] ? ($day->isSameDay($data['timesheet_today']->workday) ? '<p>' . $data['timesheet_today']->start . '</p>' : ($day->isSameDay($data['today']) ? '<a id="start" class="btn btn-primary" ><span class="fa fa-calendar-plus-o"></span> ' . Lang::get('timesheets.start') . '</a>' : '')) : '') !!}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr></tr>
            </tfoot>
        </table>
        {!! Form::open(array('route' => 'timesheets.destroy', 'method' => 'DELETE', 'id' => 'delete-form')) !!}
            <input type="hidden" name="id" id="delete-id" name="delete_id" value="">
        {!! Form::close() !!}
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
        var timesheet;
        $('#start').click(function() {
            $.ajax({
                url: '/timesheets',
                type: "POST",
                success: function(data) {
                    data = JSON.parse(data);
                    $('#start').remove();

                    var html = '<p>' + data.start + '</p>';

                    $('#start_now').append(html);

                    timesheet = data;
                }
            });
        })
    </script>
@endsection
