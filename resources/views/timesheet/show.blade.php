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
          <table id="month-table" class="table table-responsive table-hover table-border table-striped table-bordered">
            <thead>
              <tr>
                <th rowspan="2">{!! Lang::get('timesheets.title-date') !!}</th>
                <th rowspan="2">{!! Lang::get('timesheets.title-day') !!}</th>
                <th rowspan="2">{!! Lang::get('timesheets.title-holiday') !!}</th>
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
                <td><a type="button" class="btn btn-primary btn-xs" data-id="{!! $workday->id !!}" data-toggle="modal" data-target="#md-timeline">{!! \Carbon\Carbon::createFromFormat('Y-m-d', $workday->workday)->format('m/d/Y') !!}</td>
                <td>{!! html_entity_decode(GeneralHelper::getWeekDay($workday->workday)) !!}</td>
                <td>{!! '' !!}</td>
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
      Footer
      </div><!-- /.box-footer-->
    </div><!-- /.box -->

    <!-- Modal -->
    <div class="modal fade" id="md-timeline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">{!! Lang::get('timesheets.task') !!}</h4>
          </div>
          <div class="modal-body fixed">
            <div class="tab-pane active" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    </script>
@endsection
