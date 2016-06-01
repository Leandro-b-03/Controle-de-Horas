@extends('app')

@section('title')
    {!! Lang::get('general.app-tittle', ['controller' => Lang::get('general.timesheets')]) !!}
@stop

@section('style')
@stop

@section('content')
        <h1>
            {!! Lang::get('general.timesheets') !!}
            <small>{!! Lang::get('timesheets.months') !!}</small>
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
          <i class="fa fa-calendar"></i>
          <h3 class="box-title">Tarefa atual</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="left-tables pull-left">
            <a class="title-href pull-right" href="{!! URL::to('timesheets/' . Auth::user()->id . '/') !!}"><span class="fa fa-calendar-o"></span> {!! Lang::get('timesheets.actual_month') !!}</a>
            <table id="month-table-header" class="table table-responsive table-hover table-border table-striped table-bordered">
              <thead>
                <tr>
                  <td class="arrow">
                    <button id="previous" class="btn btn-default">‹</button>
                  </td>
                  <th class="month">
                    {!! $data['$month_name'] !!}
                  </th>
                  <td class="arrow">
                    <button id="next" class="btn btn-default">›</button>
                  </td>
                </tr>
              </thead>
            </table>
            <table id="month-table-holidays" class="table table-responsive table-hover table-border table-striped table-bordered">
              <tbody>
                <tr>
                  <td>Data</td>
                  <td>Descrição</td>
                  <td>Tipo</td>
                </tr>
                @foreach ($data['holidays'] as $holiday)
                <tr>
                  <td>{!! ($holiday->day < 9 ? '0' . $holiday->day : $holiday->day) . '/' . ($holiday->month < 9 ? '0' . $holiday->month : $holiday->month) !!}</td>
                  <td>{!! $holiday->name !!}</td>
                  <td>{!! $holiday->holiday_type !!}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <table id="month-table-total" class="table table-responsive table-hover table-border table-striped table-bordered pull-right">
            <thead>
              <tr>
                <th colspan="2">Geral</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>{!! Lang::get('timesheets.title-total_hours') !!}</th>
                <td>{!! $data['total_month_hours']['month_hours'] !!}</td>
              </tr>
              <tr>
                <th>{!! Lang::get('timesheets.title-total_work_month') !!}</th>
                <td>{!! $data['total_month_hours']['work_month_hours'] !!}</td>
              </tr>
              <tr>
                <th>{!! Lang::get('timesheets.title-total_credit') !!}</th>
                <td>{!! $data['total_month_hours']['time_credit'] !!}</td>
              </tr>
              <tr>
                <th>{!! Lang::get('timesheets.title-total_debit') !!}</th>
                <td>{!! $data['total_month_hours']['time_debit'] !!}</td>
              </tr>
              <tr>
                <th>{!! Lang::get('timesheets.title-total_loitered') !!}</th>
                <td>00:00:00</td>
              </tr>
              <tr>
                <th>{!! Lang::get('timesheets.title-total_credit_debit') !!}</th>
                <td>{!! $data['overtime']->hours !!}</td>
              </tr>
            </tbody>
          </table>
          <table id="month-table" class="table table-responsive table-hover table-border table-striped table-bordered">
            <thead>
              <tr>
                <th rowspan="2">{!! Lang::get('timesheets.title-date') !!}</th>
                <th rowspan="2">{!! Lang::get('timesheets.title-day') !!}</th>
                <th rowspan="2">{!! Lang::get('timesheets.title-start') !!}</th>
                <th colspan="2">{!! Lang::get('timesheets.title-lunch') !!}</th>
                <th rowspan="2">{!! Lang::get('timesheets.title-end') !!}</th>
                <th colspan="2">{!! Lang::get('timesheets.title-nightly') !!}</th>
                <th rowspan="2">{!! Lang::get('general.total') !!}</th>
              </tr>
              <tr>
                <th>{!! Lang::get('timesheets.title-start') !!}</th>
                <th>{!! Lang::get('timesheets.title-end') !!}</th>
                <th>{!! Lang::get('timesheets.title-start') !!}</th>
                <th>{!! Lang::get('timesheets.title-end') !!}</th>
              </tr>
            </thead>
            <tbody>
              @if ($data['month'])
              @foreach ($data['month'] as $workday)
              <tr>
                <td><a type="button" data-id="{!! $workday->id !!}" class="btn btn-primary btn-xs tasks-day" data-toggle="modal" data-target="#md-timeline">{!! \Carbon\Carbon::createFromFormat('Y-m-d', $workday->workday)->format('d/m/Y') !!}</td>
                <td>{!! html_entity_decode(GeneralHelper::getWeekDay($workday->workday)) !!}</td>
                <td>{!! $workday->start !!}</td>
                <td>{!! $workday->lunch_start !!}</td>
                <td>{!! $workday->lunch_end !!}</td>
                <td>{!! $workday->end !!}</td>
                <td>{!! $workday->nightly_start !!}</td>
                <td>{!! $workday->nightly_end !!}</td>
                <td>{!! GeneralHelper::getHoursTotal($workday->hours, $workday->nightly_hours) !!}</td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div><!-- /.box-body -->
      <div class="box-footer">
      <a class="btn btn-danger" href="{!! URL::to('timesheets') !!}">{!! Lang::get('general.back') !!}</a>
      </div><!-- /.box-footer-->
    </div><!-- /.box -->

    <!-- Modal -->
    <div class="modal fade" id="md-timeline" tabindex="-1" role="dialog" aria-labelledby="Timeline">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{!! Lang::get('general.back') !!}"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="Timeline">{!! Lang::get('timesheets.task') !!}</h4>
          </div>
          <div class="modal-body fixed">
            <div id="timeline">
                <!-- The timeline -->
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">{!! Lang::get('general.back') !!}</button>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
    <!-- SlimScroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- FastClick -->
    {!! Html::script("library/adminLTE/plugins/fastclick/fastclick.min.js") !!}
    <!-- Stopwacth -->
    {!! Html::script("library/adminLTE/plugins/jquery-stopwatch/jquery.stopwatch.js") !!}

    <script type="text/javascript" charset="utf-8" async defer>
      $('.tasks-day').click(function() {
        var data = {};
        data.id = $(this).data('id');
        $('#timeline').html('');

        $.ajax({
          url: '/general/getTasksDay',
          data: data,
          type: "GET",
          success: function(data) {
            $('#timeline').html('');
            $('#timeline').html($(data));
          }
        });
      });

      $('#next').click(function() {
        var month = parseInt("{!! $data['actual_month'] !!}");
        var year = parseInt("{!! $data['year'] !!}");

        if (month == 12) {
          month = 1;
          year++;
        }
        else
          month++;

        window.location.href = '?month=' + month + '&year=' + year;
      });

      $('#previous').click(function() {
        var month = parseInt("{!! $data['actual_month'] !!}");
        var year = parseInt("{!! $data['year'] !!}");

        if (month == 1) {
          month = 12;
          year--;
        }
        else
          month--;

        window.location.href = '?month=' + month + '&year=' + year;
      });
    </script>
@endsection
