@extends('app')

@section('title')
    SVLabs | Dashboard
@stop

@section('style')
    <!-- Morris chart -->
    {!! Html::style("library/adminLTE/plugins/morris/morris.css") !!}
    <!-- jvectormap -->
    {!! Html::style("library/adminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css") !!}
    <!-- Date Picker -->
    {!! Html::style("library/adminLTE/plugins/datepicker/datepicker3.css") !!}
    <!-- Daterange picker -->
    {!! Html::style("library/adminLTE/plugins/daterangepicker/daterangepicker-bs3.css") !!}
    <!-- bootstrap wysihtml5 - text editor -->
    {!! Html::style("library/adminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") !!}
@stop

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Version 2.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
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
            @if (isset($data['message-op']))
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>    <i class="icon fa fa-danger"></i> {{ Lang::get('general.atention') }}!</h4>
              {!! Lang::get('general.op-message') !!}
            </div>
            @endif
          </div>
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
              <!-- MAP & BOX PANE -->
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! Lang::get('dashboard.title-where_i_am') !!}</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <div class="row">
                    <div class="col-md-12 col-sm-12">
                      <div class="pad">
                        <!-- Map will be created here -->
                        {{-- <div id="world-map-markers" style="height: 325px;"></div> --}}
                        {{-- <div id="map"></div> --}}
                        <iframe class="map" id="map" frameborder="0" style="border:0" src="" allowfullscreen></iframe> 
                      </div>
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <div class="row">
                <div class="col-md-6">
                  <!-- DIRECT CHAT -->
                  <div id="chat">
                  </div>
                </div><!-- /.col -->

                <div class="col-md-6">
                  <!-- DIRECT CHAT -->
                  <div id="chat">
                  </div>
                </div><!-- /.col -->

                <div class="col-md-6">
                  <!-- USERS LIST -->
                  <div class="box box-danger">
                    <div class="box-header with-border">
                      <h3 class="box-title">{!! Lang::get('dashboard.title-users') !!}</h3>
                      <div class="box-tools pull-right">
                        <span class="label label-danger">{!! Lang::get('dashboard.new_users', ['count' => $data['new_users']->count()]) !!}</span>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">
                        @foreach ($data['new_users'] as $new_user)
                        <li>
                          <img src="{!! URL::to($new_user->photo) !!}" alt="{!! $new_user->first_name . ' ' . $new_user->last_name !!}">
                          <a class="users-list-name" href="{!! URL::to('profile/' . $new_user->id) !!}">{!! $new_user->first_name !!}</a>
                          @if($new_user->created_at->isToday())
                          <span class="users-list-date">{!! Lang::get('general.date-today') !!}</span>
                          @elseif($new_user->created_at->isYesterday())
                          <span class="users-list-date">{!! Lang::get('general.date-yesterday') !!}</span>
                          @else
                          <span class="users-list-date">{!! $new_user->created_at->format('d M'); !!}</span>
                          @endif
                        </li>
                        @endforeach
                      </ul><!-- /.users-list -->
                    </div><!-- /.box-body -->
                    <div class="box-footer text-center">
                      <a href="javascript::" class="uppercase">{!! Lang::get('dashboard.see_all_users') !!}</a>
                    </div><!-- /.box-footer -->
                  </div><!--/.box -->
                </div><!-- /.col -->
              </div><!-- /.row -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! Lang::get('dashboard.title-tasks') !!}</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>{!! Lang::get('general.tasks') !!}</th>
                          <th>{!! Lang::get('general.description') !!}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (isset($data['tasks']))
                        @foreach ($data['tasks'] as $task)
                        <tr>
                          <td>{!! $task->subject !!}</td>
                          <td>{!! $task->description !!}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="4">{!! Lang::get('general.dataTable-zeroRecords') !!}</td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <!-- <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                  <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a> -->
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-4">
              <!-- PRODUCT LIST -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">{!! Lang::get('dashboard.title-projects') !!}</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
                    @if (isset($data['new_projects']))
                    @foreach ($data['new_projects'] as $new_project)
                    <li class="item">
                      <div class="product-img">
                        {{-- <img src="dist/img/default-50x50.gif" alt="Product Image"> --}}
                        <span class="project-icon fa fa-suitcase"></span>
                      </div>
                      <div class="product-info">
                        <a href="javascript::;" class="product-title">{!! $new_project->name !!} <span class="label label-warning pull-right">{!! date('d/m/Y', strtotime($new_project->created_on)) !!}</span></a>
                        <span class="product-description">
                          {!! $new_project->description !!}
                        </span>
                      </div>
                    </li><!-- /.item -->
                    @endforeach
                    @endif
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                  <!-- <a href="javascript::;" class="uppercase">View All Products</a> -->
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
@endsection

@section('scripts')
    <!-- jQuery UI 1.11.2 -->
    {!! Html::script("http://code.jquery.com/ui/1.11.2/jquery-ui.min.js") !!}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Morris.js charts -->
    {!! Html::script("http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js") !!}
    {!! Html::script("library/adminLTE/plugins/morris/morris.min.js") !!}
    <!-- Sparkline -->
    {!! Html::script("library/adminLTE/plugins/sparkline/jquery.sparkline.min.js") !!}
    <!-- jvectormap -->
    {!! Html::script("library/adminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") !!}
    {!! Html::script("library/adminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") !!}
    <!-- jQuery Knob Chart -->
    {!! Html::script("library/adminLTE/plugins/knob/jquery.knob.js") !!}
    <!-- Google Maps -->
    {!! Html::script("https://maps.googleapis.com/maps/api/js") !!}
    <!-- daterangepicker -->
    {!! Html::script("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js") !!}
    {!! Html::script("library/adminLTE/plugins/daterangepicker/daterangepicker.js") !!}
    <!-- datepicker -->
    {!! Html::script("library/adminLTE/plugins/datepicker/bootstrap-datepicker.js") !!}
    <!-- Bootstrap WYSIHTML5 -->
    {!! Html::script("library/adminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") !!}
    <!-- Sparkline -->
    {!! Html::script("library/adminLTE/plugins/sparkline/jquery.sparkline.min.js") !!}
    <!-- jvectormap -->
    {!! Html::script("library/adminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") !!}
    {!! Html::script("library/adminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") !!}
    <!-- ChartJS 1.0.1 -->
    {!! Html::script("library/adminLTE/plugins/chartjs/Chart.min.js") !!}
    <!-- Slimscroll -->
    {!! Html::script("library/adminLTE/plugins/slimScroll/jquery.slimscroll.min.js") !!}
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- {!! Html::script("library/adminLTE/dist/js/pages/dashboard2.js") !!} -->
    <!-- Custom PusherChatWidget.js -->
    {!! Html::script("library/adminLTE/custom/CustomPusherChatWidgetDashboard.js") !!}

    <script>
      window.onload = function() {
        var startPos;
        var coord;
        var geoOptions = {
          enableHighAccuracy: true
        }

        var geoSuccess = function(position) {
          startPos = position;

          var use_local = "{{ $data['location']['use'] }}";

          console.log(use_local);

          coord = null;

          if (use_local == 1) {
            coord = 'https://www.google.com/maps/embed/v1/place?q=' + "{{ $data['location']['lat'] }}" + ',' + "{{ $data['location']['lon'] }}" + '&key=AIzaSyAMjB9eA7xTNXxROIy_4IS4HbuijRQ84YA';

            savePosition("{{ $data['location']['lat'] }}", "{{ $data['location']['lon'] }}");
          } else {
            coord = 'https://www.google.com/maps/embed/v1/place?q=' + startPos.coords.latitude + ',' + startPos.coords.longitude + '&key=AIzaSyAMjB9eA7xTNXxROIy_4IS4HbuijRQ84YA';

            savePosition(startPos.coords.latitude, startPos.coords.longitude);
          }

          $('#map').attr('src', coord);
        };

        var geoError = function(error) {
          console.log('Error occurred. Error code: ' + error.code);
          // error.code can be:
          //   0: unknown error
          //   1: permission denied
          //   2: position unavailable (error response from location provider)
          //   3: timed out
        };

        navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
      };

      $(function() {
        var chatWidget = new PusherChatWidgetDashboard(pusher, {
        channelName: 'presence-chat',
        appendTo: '#chat',
        debug: false
        });
      });
    </script>
@endsection